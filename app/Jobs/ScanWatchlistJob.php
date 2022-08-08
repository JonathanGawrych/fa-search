<?php declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMXPath;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ScanWatchlistJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/** @var User $user **/
	private $user;
	/** @var string $mode (Either 'by' or 'to' **/
	private $mode;
	/** @var int|null $next **/
	private $next;

	public function __construct(User $user, string $mode, ?int $next = null)
	{
		$this->onQueue('watchlist');
		$this->user = $user;
		$this->mode = $mode;
		$this->next = $next;
	}

	public function handle(): void
	{
		DB::transaction(function (): void {
			$client = App::make('FuraffinityClient');
			assert($client instanceof Client);

			$url = '/watchlist/' . $this->mode . '/' . $this->user->lower . '/';
			if ($this->next !== null) {
				$url .= $this->next . '/?';
			}

			// Get the user's page
			$response = $client->request('GET', $url);
			$content = $response->getBody()->getContents();

			// Turn off strict xml errors
			libxml_use_internal_errors(true);

			// Load the document
			$doc = new DOMDocument();
			$doc->preserveWhiteSpace = false;
			$doc->loadHTML($content, LIBXML_NOBLANKS | LIBXML_COMPACT);
			$xpath = new DOMXPath($doc);

			$watchers = [];
			$watchersDom = $xpath->evaluate('//div[@class="section-body watch-list"]//a');
			assert($watchersDom instanceof DOMNodeList);
			for ($i = 0; $i < $watchersDom->count(); $i++) {
				$watcher = $watchersDom->item($i);
				assert($watcher instanceof DOMElement);
				$watcherLower = substr($watcher->getAttribute('href'), strlen('/user/'), -strlen('/'));
				$watcherName = $watcher->textContent;
				$watcher = User::firstOrCreate(
					['lower' => $watcherLower],
					['name' => $watcherName]
				);
				$watchers[] = $watcher->getKey();
			}

			if ($this->mode === 'by') {
				$this->user->watchedBy()->syncWithoutDetaching($watchers);
			} else {
				$this->user->watches()->syncWithoutDetaching($watchers);
			}

			$next = ($this->next ?? 1) + 1;
			if ($xpath->evaluate("//form[@action=\"/watchlist/$this->mode/scale/$next/\"]")->count() > 0) {
				ScanWatchlistJob::dispatch($this->user, $this->mode, $next);
			}
		});
	}
}

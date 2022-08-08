<?php declare(strict_types=1);

namespace App\Jobs;

use App\Models\Submission;
use App\Models\User;
use DOMDocument;
use DOMElement;
use DOMEntity;
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

class ScanFavoritesJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/** @var User $user **/
	private $user;
	/** @var int|null $next */
	private $next;

	public function __construct(User $user, ?int $next = null)
	{
		$this->onQueue('favorite');
		$this->user = $user;
		$this->next = $next;
	}

	public function handle(): void
	{
		DB::transaction(function (): void {
			$client = App::make('FuraffinityClient');
			assert($client instanceof Client);

			$url = '/favorites/' . $this->user->lower . '/';
			if ($this->next !== null) {
				$url .= $this->next . '/next';
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

			$favorites = [];
			$favoritesDom = $xpath->evaluate('//figure[@data-fav-id]');
			assert($favoritesDom instanceof DOMNodeList);
			for ($i = 0; $i < $favoritesDom->count(); $i++) {
				$favorite = $favoritesDom->item($i);
				assert($favorite instanceof DOMElement);
				$id = (int) $favorite->getAttribute('data-fav-id');
				$submissionId = (int) substr($favorite->getAttribute('id'), strlen('sid-'));
				$lower = substr($favorite->getAttribute('data-user'), strlen('u-'));
				$name = $xpath->evaluate('string(//a[3]/@text)');
				$user = User::firstOrCreate(
					['lower' => $lower],
					['name' => $name]
				);

				$favorites[$submissionId] = ['id' => $id];
				Submission::firstOrCreate(
					['id' => $submissionId],
					['user_id' => $user->getKey()]
				);
			}
			$this->user->favorites()->syncWithoutDetaching($favorites);

			/** @var DOMElement|null $nextBtn */
			$nextBtn = $xpath->evaluate('//a[@class="button standard right"]')->item(0);
			if ($nextBtn !== null) {
				$href = $nextBtn->getAttribute('href');
				$nextId = substr($href, strlen("/favorites/{$this->user->lower}/"), -strlen('/next'));
				static::dispatch($this->user, $nextId);
			}
		});
	}
}

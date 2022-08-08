<?php declare(strict_types=1);

namespace App\Jobs;

use App\Models\Submission;
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

class ScanGalleryJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/** @var User $user **/
	private $user;
	/** @var string $mode (Either 'gallery' or 'scraps' **/
	private $mode;
	/** @var int|null $next **/
	private $next;

	public function __construct(User $user, string $mode, ?int $next = null)
	{
		$this->onQueue('gallery');
		$this->user = $user;
		$this->mode = $mode;
		$this->next = $next;
	}

	public function handle(): void
	{
		DB::transaction(function (): void {
			$client = App::make('FuraffinityClient');
			assert($client instanceof Client);

			$url = '/' . $this->mode . '/' . $this->user->lower . '/';
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

			$submissionsDom = $xpath->evaluate('//figure');
			assert($submissionsDom instanceof DOMNodeList);
			for ($i = 0; $i < $submissionsDom->count(); $i++) {
				$submissionDom = $submissionsDom->item($i);
				assert($submissionDom instanceof DOMElement);
				$submissionId = (int) substr($submissionDom->getAttribute('id'), strlen('sid-'));
				Submission::firstOrCreate(
					['id' => $submissionId],
					['user_id' => $this->user->getKey()]
				);
			}

			if ($xpath->evaluate('//button[text()="Next"]')->count() > 0) {
				ScanGalleryJob::dispatch($this->user, $this->mode, ($this->next ?? 1) + 1);
			}
		});
	}
}

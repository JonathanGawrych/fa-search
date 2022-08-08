<?php declare(strict_types=1);

namespace App\Jobs;

use App\Models\Submission;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ScanSubmissionJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/** @var Submission $submission **/
	private $submission;

	public function __construct(Submission $submission)
	{
		$this->onQueue('submission');
		$this->submission = $submission;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		DB::transaction(function (): void {
			$client = App::make('FuraffinityClient');
			assert($client instanceof Client);

			// Get the submission's page
			$response = $client->request('GET', '/view/' . $this->submission->getKey());
			$content = $response->getBody()->getContents();

			// Turn off strict xml errors
			libxml_use_internal_errors(true);

			// Load the document
			$doc = new DOMDocument();
			$doc->preserveWhiteSpace = false;
			$doc->loadHTML($content, LIBXML_NOBLANKS | LIBXML_COMPACT);
			$xpath = new DOMXPath($doc);
		});
	}
}

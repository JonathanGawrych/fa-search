<?php declare(strict_types=1);

namespace App\Jobs;

use App\Models\Journal;
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

class ScanJournalJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/** @var Journal $journal **/
	private $journal;

	public function __construct(Journal $journal)
	{
		$this->onQueue('journal');
		$this->journal = $journal;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void
	{
		DB::transaction(function (): void {
			$client = App::make('FuraffinityClient');
			assert($client instanceof Client);

			// Get the journal's page
			$response = $client->request('GET', '/journal/' . $this->journal->getKey());
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

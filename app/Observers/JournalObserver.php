<?php declare(strict_types=1);

namespace App\Observers;

use App\Jobs\ScanJournalJob;
use App\Models\Journal;

class JournalObserver
{
	public function created(Journal $journal): void
	{
		ScanJournalJob::dispatch($journal);
	}
}

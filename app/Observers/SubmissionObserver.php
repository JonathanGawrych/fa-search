<?php declare(strict_types=1);

namespace App\Observers;

use App\Jobs\ScanSubmissionJob;
use App\Models\Submission;

class SubmissionObserver
{
	public function created(Submission $submission): void
	{
		ScanSubmissionJob::dispatch($submission);
	}
}

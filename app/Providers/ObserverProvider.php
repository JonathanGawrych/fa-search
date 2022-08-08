<?php declare(strict_types=1);

namespace App\Providers;

use App\Models\Journal;
use App\Models\Submission;
use App\Models\User;
use App\Observers\JournalObserver;
use App\Observers\SubmissionObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class ObserverProvider extends ServiceProvider
{
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		User::observe(UserObserver::class);
		Submission::observe(SubmissionObserver::class);
		Journal::observe(JournalObserver::class);
	}
}

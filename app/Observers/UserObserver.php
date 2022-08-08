<?php declare(strict_types=1);

namespace App\Observers;

use App\Jobs\ScanFavoritesJob;
use App\Jobs\ScanGalleryJob;
use App\Jobs\ScanProfileJob;
use App\Jobs\ScanWatchlistJob;
use App\Models\User;

class UserObserver
{
	public function created(User $user): void
	{
		if ($user->name !== 'TuringTibbit') {
			return;
		}
		ScanProfileJob::dispatch($user);
		ScanFavoritesJob::dispatch($user);
		ScanGalleryJob::dispatch($user, 'gallery');
		ScanGalleryJob::dispatch($user, 'scraps');
		ScanWatchlistJob::dispatch($user, 'to');
		ScanWatchlistJob::dispatch($user, 'by');
	}
}

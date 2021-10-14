<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Disable Eloquent's guard system. It just leads to repetition.
		Model::unguard();

		// InnoDB has a maximum index length of 767 bytes. So for utf8mb4 which is 4 bytes per char, you
		// can index a maximum of 767/4 = 191 characters. We'll make this default from now on.
		// @see https://dev.mysql.com/doc/refman/5.7/en/charset-unicode-conversion.html#:~:text=InnoDB%20has%20a%20maximum%20index%20length%20of%20767%20bytes
		Schema::defaultStringLength(191);
	}
}

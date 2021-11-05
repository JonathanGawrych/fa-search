<?php declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		App::singleton('GuzzleHandler', function (): callable {
			return Utils::chooseHandler();
		});

		App::singleton('FuraffinityClient', function (): Client {
			$cookieJar = CookieJar::fromArray([
				'a' => config('auth.furaffinity.cookie.a'),
				'b' => config('auth.furaffinity.cookie.b'),
				'cf_clearance' => config('auth.furaffinity.cloudflare.clearance'),
				'cf_chl_prog' => config('auth.furaffinity.cloudflare.challenge_prog'),
				'cf_chl_2' => config('auth.furaffinity.cloudflare.challenge_two')
			], config('auth.furaffinity.domain'));
			return new Client([
				'base_uri' => 'https://www.furaffinity.net/',
				'headers' => [
					'User-Agent' => config('auth.furaffinity.user-agent')
				],
				'cookies' => $cookieJar,
				'handler' => HandlerStack::create(App::make('GuzzleHandler'))
			]);
		});
	}

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

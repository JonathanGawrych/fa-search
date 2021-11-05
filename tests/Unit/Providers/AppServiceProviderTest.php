<?php declare(strict_types=1);

namespace Tests\Unit\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AppServiceProviderTest extends TestCase
{
	protected function setUp(): void
	{
		$this->createApplication();
		parent::setUp();
	}

	public function testGuzzleCanGetHandler(): void
	{
		$handler = App::make('GuzzleHandler');
		static::assertTrue(is_callable($handler));
	}

	public function testCanGetGuzzleClientForFA(): void
	{
		App::instance('GuzzleHandler', new MockHandler([
			function (Request $request, array $options): Response {
				static::assertEquals('www.furaffinity.net', $options['base_uri']->getHost());
				return new Response(200);
			}
		]));
		$client = App::make('FuraffinityClient');
		assert($client instanceof Client);
		$client->get('/');
	}
}

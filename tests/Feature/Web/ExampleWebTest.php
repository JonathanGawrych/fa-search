<?php declare(strict_types=1);

namespace Tests\Feature\Web;

use Tests\TestCase;

class ExampleWebTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testExample()
	{
		$response = $this->get('/');

		$response->assertStatus(200);
	}
}

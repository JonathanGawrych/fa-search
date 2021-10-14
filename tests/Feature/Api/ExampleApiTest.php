<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class ExampleApiTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function test_example()
	{
		$response = $this->get('/api/whats-my-ip');

		$response->assertStatus(200);
	}
}

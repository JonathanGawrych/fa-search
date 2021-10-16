<?php declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication, RefreshDatabase;

	protected bool $seed = true;

	public static function assertEqualsIgnoringCaseAndWhitespace(
		string $expected,
		string $actual,
		string $message = ''
	): void
	{
		$expectedWithoutWhitespace = trim(preg_replace('/\s+/', ' ', $expected) ?? '');
		$actualWithoutWhitespace = trim(preg_replace('/\s+/', ' ', $actual) ?? '');
		static::assertEqualsIgnoringCase($expectedWithoutWhitespace, $actualWithoutWhitespace, $message);
	}
}

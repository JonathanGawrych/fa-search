<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected bool $seed = true;

    public function assertEqualsIgnoringCaseAndWhitespace(string $expected, string $actual, string $message = ''): void
    {
        $expectedWithoutWhitespace = trim(preg_replace('/\s+/', ' ', $expected) ?? '');
        $actualWithoutWhitespace = trim(preg_replace('/\s+/', ' ', $actual) ?? '');
        $this->assertEqualsIgnoringCase($expectedWithoutWhitespace, $actualWithoutWhitespace, $message);
    }
}

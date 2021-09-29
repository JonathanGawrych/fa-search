<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function assertEqualsIgnoringCaseAndWhitespace($expected, $actual, string $message = ''): void
    {
        $expectedWithoutWhitespace = trim(preg_replace('/\s+/', ' ', $expected));
        $actualWithoutWhitespace = trim(preg_replace('/\s+/', ' ', $actual));
        $this->assertEqualsIgnoringCase($expectedWithoutWhitespace, $actualWithoutWhitespace, $message);
    }
}

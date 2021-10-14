<?php declare(strict_types=1);

namespace Tests\Unit\Lang;

use Tests\TestCase;

class LangTest extends TestCase
{
	/**
	 * A simple test mainly for coverage
	 */
	public function testLangWorks(): void
	{
		$requiredMsg = __('validation.required', ['attribute' => 'foo']);
		static::assertSame('The foo field is required.', $requiredMsg);
	}
}

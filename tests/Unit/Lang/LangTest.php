<?php

namespace Tests\Unit\Lang;

use Tests\TestCase;

class LangTest extends TestCase
{
    /**
     * A simple test mainly for coverage
     */
    public function testLangWorks()
    {
        $requiredMsg = __('validation.required', ['attribute' => 'foo']);
        $this->assertSame('The foo field is required.', $requiredMsg);
    }
}

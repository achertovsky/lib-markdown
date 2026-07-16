<?php

declare(strict_types=1);

namespace tests\Converter\MarkdownToHtml;

use achertovsky\markdown\Converter\MarkdownToHtml\BoldConverter;
use PHPUnit\Framework\TestCase;

class BoldConverterTest extends TestCase
{
    private BoldConverter $converter;

    protected function setUp(): void
    {
        $this->converter = new BoldConverter();
    }

    public function test(): void
    {
        $this->assertTrue(false, 'implement me');
    }

    public function testWouldIgnoreItalicOnlyLine(): void
    {
        $this->assertTrue(false, 'implement me');
    }

    public function testWouldConvertOnlyBoldInBoldAndItalicCase(): void
    {
        $this->assertTrue(false, 'implement me');
    }
}

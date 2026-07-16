<?php

declare(strict_types=1);

namespace tests\Converter\MarkdownToHtml;

use achertovsky\markdown\Converter\MarkdownToHtml\ItalicConverter;
use achertovsky\markdown\DTO\Lines;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ItalicConverterTest extends TestCase
{
    private ItalicConverter $converter;

    protected function setUp(): void
    {
        $this->converter = new ItalicConverter();
    }

    public function test(): void
    {
        $this->assertTrue(false, 'implement me');
    }

    public function testWouldIgnoreBoldOnlyLine(): void
    {
        $this->assertTrue(false, 'implement me');
    }

    public function testWouldConvertOnlyItalicInBoldAndItalicCase(): void
    {
        $this->assertTrue(false, 'implement me');
    }
}

<?php

declare(strict_types=1);

namespace tests\Orchestrator;

use PHPUnit\Framework\TestCase;
use tests\TestDouble\Converter\ConverterHumbleFake;
use achertovsky\markdown\Exception\MarkdownException;
use achertovsky\markdown\Orchestrator\MarkdownToHTMLConvertOrchestrator;
use achertovsky\markdown\DTO\Lines;

class MarkdownToHTMLConvertOrchestratorTest extends TestCase
{
    private MarkdownToHTMLConvertOrchestrator $orchestrator;
    private ConverterHumbleFake $converterFake;

    protected function setUp(): void
    {
        $this->converterFake = new ConverterHumbleFake();

        $this->orchestrator = new MarkdownToHTMLConvertOrchestrator();

        $this->orchestrator->addConverter($this->converterFake);
    }

    public function testEmptyLinesWouldBeProcessedBeforePassingToConvertersChain(): void
    {
        $input = sprintf(
            "\n\n%s\n\n",
            'This is a heading'
        );

        $expectedLines = new Lines(
            [
                2 => 'This is a heading',
            ],
            [
                0 => '',
                1 => '',
                3 => '',
                4 => '',
            ]
        );

        $this->orchestrator->convert($input);

        $this->assertEquals(
            [
                $expectedLines
            ],
            $this->converterFake->convertCalledWith
        );
    }

    public function testInputHasNoLineWrappingHtmlFormatting(): void
    {
        $this->expectExceptionMessage(MarkdownException::INPUT_HAS_HTML_FORMATTING);
        $this->expectException(MarkdownException::class);

        $input = '<h1>This is a heading</h1>';

        $this->orchestrator->convert($input);
    }

    public function testInputHasTextHtmlFormatting(): void
    {
        $input = 'This is a paragraph with <strong>bold</strong> text.';
        $expectedOutput = 'This is a paragraph with <strong>bold</strong> text.';

        $this->assertEquals(
            $expectedOutput,
            $this->orchestrator->convert($input)
        );
    }
}

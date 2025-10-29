<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use tests\TestDouble\Converter\ConverterHumbleFake;
use achertovsky\markdown\Exception\MarkdownException;
use achertovsky\markdown\MarkdownToHTMLConvertOrchestrator;
use achertovsky\markdown\DTO\Lines;

class MarkdownToHTMLConvertOrchestratorTest extends TestCase
{
    private MarkdownToHTMLConvertOrchestrator $orchestrator;
    private ConverterHumbleFake $converterFake;

    protected function setUp(): void
    {
        $this->converterFake = new ConverterHumbleFake();

        $this->orchestrator = new MarkdownToHTMLConvertOrchestrator(
            $this->converterFake
        );
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
            $expectedLines,
            $this->converterFake->convertCalledWith
        );
    }

    public function testInputHasNoHtmlFormatting(): void
    {
        $this->expectExceptionMessage(MarkdownException::INPUT_HAS_HTML_FORMATTING);
        $this->expectException(MarkdownException::class);

        $input = '<h1>This is a heading</h1>';

        $this->orchestrator->convert($input);
    }

    // public function testInputHasTextHtmlFormatting(): void
    // {
    //     $input = 'This is a paragraph with <strong>bold</strong> text.';
    //     $expectedOutput = 'This is a paragraph with <strong>bold</strong> text.';

    //     $this->assertEquals(
    //         $expectedOutput,
    //         $this->converter->convert($input)
    //     );
    // }

    // #[DataProvider('dataConvertsParagraphs')]
    // public function testConvertsParagraphs(
    //     string $input,
    //     string $expectedOutput
    // ): void {
    //     $this->assertEquals(
    //         $expectedOutput,
    //         $this->converter->convert($input)
    //     );
    // }

    // /**
    //  * @return array<int|string, array{0: string, 1: string}>
    //  */
    // public static function dataConvertsParagraphs(): array
    // {
    //     return [
    //         [
    //             'This is a paragraph.',
    //             '<p>This is a paragraph.</p>',
    //         ],
    //         [
    //             sprintf(
    //                 "%s\n\n%s",
    //                 'This is the first paragraph.',
    //                 'This is the second paragraph.'
    //             ),
    //             sprintf(
    //                 "%s\n\n%s",
    //                 '<p>This is the first paragraph.</p>',
    //                 '<p>This is the second paragraph.</p>'
    //             ),
    //         ],
    //         'ignores single newlines within a paragraph' => [
    //             sprintf(
    //                 "%s\n%s",
    //                 'This is a paragraph that',
    //                 'spans multiple lines.'
    //             ),
    //             '<p>This is a paragraph that spans multiple lines.</p>',
    //         ],
    //         'handles leading and trailing whitespace' => [
    //             sprintf(
    //                 "%s\n\n%s\n\n%s",
    //                 '   This is a paragraph with leading whitespace.   ',
    //                 'This is another paragraph.',
    //                 '   Yet another paragraph with trailing whitespace.   '
    //             ),
    //             sprintf(
    //                 "%s\n\n%s\n\n%s",
    //                 '<p>This is a paragraph with leading whitespace.</p>',
    //                 '<p>This is another paragraph.</p>',
    //                 '<p>Yet another paragraph with trailing whitespace.</p>'
    //             ),
    //         ],
    //     ];
    // }
}

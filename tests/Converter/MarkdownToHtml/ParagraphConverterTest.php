<?php

declare(strict_types=1);

namespace tests\Converter\MarkdownToHtml;

use achertovsky\markdown\Converter\MarkdownToHtml\ParagraphConverter;
use achertovsky\markdown\DTO\Lines;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ParagraphConverterTest extends TestCase
{
    private ParagraphConverter $converter;

    protected function setUp(): void
    {
        $this->converter = new ParagraphConverter();
    }

    public function testWithEmptyArrayWontDoAThing(): void
    {
        $input = new Lines([]);

        $this->converter->convert($input);

        $this->assertEquals(
            new Lines([]),
            $input
        );
    }

    #[DataProvider('dataConvertsParagraph')]
    public function testConvertsParagraph(
        Lines $input,
        Lines $expectedOutput
    ): void {
        $this->converter->convert($input);

        $this->assertEquals(
            $expectedOutput,
            $input
        );
    }

    /**
     * @return array<int|string, array{0: Lines, 1: Lines}>
     */
    public static function dataConvertsParagraph(): array
    {
        return [
            [
                new Lines(
                    [
                        'This is a paragraph.',
                    ]
                ),
                new Lines(
                    [],
                    [
                        '<p>This is a paragraph.</p>',
                    ]
                ),
            ],
            [
                new Lines(
                    [
                        0 => 'This is the first paragraph.',
                        2 => 'This is the second paragraph.',
                    ],
                    [
                        1 => '',
                    ]
                ),
                new Lines(
                    [],
                    [
                        0 => '<p>This is the first paragraph.</p>',
                        1 => '',
                        2 => '<p>This is the second paragraph.</p>',
                    ]
                ),
            ],
            'ignores single newlines within a paragraph' => [
                new Lines(
                    [
                        'This is a paragraph that',
                        'spans multiple lines.',
                    ]
                ),
                new Lines(
                    [],
                    [
                        '<p>This is a paragraph that spans multiple lines.</p>',
                    ]
                ),
            ],
            'handles leading and trailing whitespace' => [
                new Lines(
                    [
                        0 => '   This is a paragraph with leading whitespace.   ',
                        2 => 'This is another paragraph.',
                        4 => '   Yet another paragraph with trailing whitespace.   ',
                    ],
                    [
                        1 => '',
                        3 => '',
                    ]
                ),
                new Lines(
                    [],
                    [
                        '<p>This is a paragraph with leading whitespace.</p>',
                        '',
                        '<p>This is another paragraph.</p>',
                        '',
                        '<p>Yet another paragraph with trailing whitespace.</p>',
                    ]
                ),
            ],
        ];
    }
}

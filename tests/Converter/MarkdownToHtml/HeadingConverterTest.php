<?php

declare(strict_types=1);

namespace tests\Converter\MarkdownToHtml;

use achertovsky\markdown\Converter\MarkdownToHtml\HeadingConverter;
use achertovsky\markdown\DTO\Lines;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class HeadingConverterTest extends TestCase
{
    private HeadingConverter $converter;

    protected function setUp(): void
    {
        $this->converter = new HeadingConverter();
    }

    #[DataProvider('dataConvertsHeading')]
    public function testConvertsHeading(
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
    public static function dataConvertsHeading(): array
    {
        return [
            [
                new Lines(
                    [
                        '# Heading 1',
                    ]
                ),
                new Lines(
                    [],
                    [
                        '<h1>Heading 1</h1>',
                    ]
                ),
            ],
            [
                new Lines(
                    [
                        '## Heading 2',
                    ]
                ),
                new Lines(
                    [],
                    [
                        '<h2>Heading 2</h2>',
                    ]
                ),
            ],
            [
                new Lines(
                    [
                        '### Heading 3',
                    ]
                ),
                new Lines(
                    [],
                    [
                        '<h3>Heading 3</h3>',
                    ]
                ),
            ],
            [
                new Lines(
                    [
                        '#### Heading 4',
                    ]
                ),
                new Lines(
                    [],
                    [
                        '<h4>Heading 4</h4>',
                    ]
                ),
            ],
            [
                new Lines(
                    [
                        '##### Heading 5',
                    ]
                ),
                new Lines(
                    [],
                    [
                        '<h5>Heading 5</h5>',
                    ]
                ),
            ],
            [
                new Lines(
                    [
                        '###### Heading 6',
                    ]
                ),
                new Lines(
                    [],
                    [
                        '<h6>Heading 6</h6>',
                    ]
                ),
            ],
            'wont tolerate missing whitespace' => [
                new Lines(
                    [
                        '#Heading',
                    ]
                ),
                new Lines(
                    [
                        '#Heading',
                    ]
                ),
            ],
            'wont tolerate missing lines before and after heading' => [
                new Lines(
                    [
                        '# heading',
                        '### Heading',
                        '# heading',
                    ]
                ),
                new Lines(
                    [
                        '# heading',
                        '### Heading',
                        '# heading',
                    ]
                ),
            ],
            'previous line does not exist and still heading' => [
                new Lines(
                    [
                        0 => '# Heading',
                    ],
                    [
                        1 => '',
                        2 => 'Some text',
                    ]
                ),
                new Lines(
                    [],
                    [
                        '<h1>Heading</h1>',
                        '',
                        'Some text',
                    ]
                ),
            ],
            'next line does not exist and still heading' => [
                new Lines(
                    [
                        2 => '## Heading',
                    ],
                    [
                        0 => 'Some text',
                        1 => '',
                    ]
                ),
                new Lines(
                    [],
                    [
                        'Some text',
                        '',
                        '<h2>Heading</h2>',
                    ]
                ),
            ],
        ];
    }
}

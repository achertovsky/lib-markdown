<?php

declare(strict_types=1);

namespace achertovsky\markdown\tests;

use PHPUnit\Framework\TestCase;
use achertovsky\markdown\HTMLConverter;
use PHPUnit\Framework\Attributes\DataProvider;

class HTMLConverterTest extends TestCase
{
    private HTMLConverter $converter;

    protected function setUp(): void
    {
        $this->converter = new HTMLConverter();
    }

    #[DataProvider('dataConvertsHeading')]
    public function testConvertsHeading(
        string $input,
        string $expectedOutput
    ): void {
        $this->assertEquals(
            $expectedOutput,
            $this->converter->convert($input)
        );
    }

    public static function dataConvertsHeading(): array
    {
        return [
            [
                '# Heading 1',
                '<h1>Heading 1</h1>',
            ],
            [
                '## Heading 2',
                '<h2>Heading 2</h2>',
            ],
            [
                '### Heading 3',
                '<h3>Heading 3</h3>',
            ],
            [
                '#### Heading 4',
                '<h4>Heading 4</h4>',
            ],
            [
                '##### Heading 5',
                '<h5>Heading 5</h5>',
            ],
            [
                '###### Heading 6',
                '<h6>Heading 6</h6>',
            ],
            [
                sprintf(
                    "%s\n%s\n%s\n%s\n%s",
                    'not a heading',
                    '',
                    '### Heading',
                    '',
                    'not a heading'
                ),
                sprintf(
                    "%s\n%s\n%s\n%s\n%s",
                    'not a heading',
                    '',
                    '<h3>Heading</h3>',
                    '',
                    'not a heading'
                ),
            ],
            'wont tolerate missing whitespace' => [
                '#Heading',
                '#Heading',
            ],
            'wont tolerate missing lines before and after heading' => [
                sprintf(
                    "%s\n%s\n%s",
                    'not a heading',
                    '### Heading',
                    'not a heading'
                ),
                sprintf(
                    "%s\n%s\n%s",
                    'not a heading',
                    '### Heading',
                    'not a heading'
                ),
            ]
        ];
    }
}

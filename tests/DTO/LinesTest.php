<?php

declare(strict_types=1);

namespace tests\DTO;

use achertovsky\markdown\DTO\Lines;
use PHPUnit\Framework\TestCase;

class LinesTest extends TestCase
{
    public function testMoveLines(): void
    {
        $dto = new Lines(
            [
                0 => 'Line 1',
                1 => 'Line 2',
            ]
        );

        $dto->moveLineToProcessed(1);

        $this->assertEquals(
            new Lines(
                [
                    0 => 'Line 1',
                ],
                [
                    1 => 'Line 2',
                ]
            ),
            $dto
        );
    }

    public function testGetProcessedLines(): void
    {
        $dto = new Lines(
            [],
            [
                1 => 'Line 2',
                0 => 'Line 1',
            ]
        );

        $this->assertSame(
            [
                0 => 'Line 1',
                1 => 'Line 2',
            ],
            $dto->getProcessedLines()
        );
    }
}

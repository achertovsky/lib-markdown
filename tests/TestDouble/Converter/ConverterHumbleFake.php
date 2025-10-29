<?php

declare(strict_types=1);

namespace tests\TestDouble\Converter;

use achertovsky\markdown\Converter\ConverterInterface;
use achertovsky\markdown\DTO\Lines;

class ConverterHumbleFake implements ConverterInterface
{
    /**
     * @var Lines[]
     */
    public array $convertCalledWith = [];

    public function convert(Lines $lines): void
    {
        $this->convertCalledWith[] = clone $lines;

        foreach ($lines->getLinesLeftToProcess() as $index => $line) {
            $lines->removeLineFromLeftovers($index);
            $lines->addLineToProcessed($index, $line);
        }
    }
}

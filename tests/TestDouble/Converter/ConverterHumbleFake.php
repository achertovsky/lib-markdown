<?php

declare(strict_types=1);

namespace tests\TestDouble\Converter;

use achertovsky\markdown\Converter\ConverterInterface;
use achertovsky\markdown\DTO\Lines;

class ConverterHumbleFake implements ConverterInterface
{
    public ?Lines $convertCalledWith = null;

    public function convert(Lines $lines): void
    {
        $this->convertCalledWith = $lines;
    }
}

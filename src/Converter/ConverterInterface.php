<?php

declare(strict_types=1);

namespace achertovsky\markdown\Converter;

use achertovsky\markdown\DTO\Lines;

interface ConverterInterface
{
    public function convert(Lines $input): void;
}

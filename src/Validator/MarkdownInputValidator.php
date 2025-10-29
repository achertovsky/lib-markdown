<?php

declare(strict_types=1);

namespace achertovsky\markdown\Validator;

use achertovsky\markdown\DTO\Lines;
use achertovsky\markdown\Exception\MarkdownException;

class MarkdownInputValidator
{
    public static function validate(Lines $lines): void
    {
        foreach ($lines->getLinesLeftToProcess() as $line) {
            if (preg_match('/^<[^>]+>/', $line)) {
                MarkdownException::throwInputHasHtmlFormatting();
            }
        }
    }
}

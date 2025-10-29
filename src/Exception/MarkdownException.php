<?php

declare(strict_types=1);

namespace achertovsky\markdown\Exception;

use RuntimeException;

class MarkdownException extends RuntimeException
{
    public const string INPUT_HAS_HTML_FORMATTING = 'Input has HTML formatting which is not supported.';

    public static function throwInputHasHtmlFormatting(): void
    {
        throw new self(self::INPUT_HAS_HTML_FORMATTING);
    }
}

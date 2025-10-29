<?php

declare(strict_types=1);

namespace achertovsky\markdown;

use achertovsky\markdown\Exception\MarkdownException;

class MarkdownToHTMLConvertOrchestrator
{
    public function convert(string $text): string
    {
        $this->validate($text);

        $text = $this->convertParagraphs($text);

        return $text;
    }

    private function validate(string $text): void
    {
        $lines = explode("\n", $text);
        foreach ($lines as $line) {
            if (preg_match('/<[^>]+>/', $line)) {
                MarkdownException::throwInputHasHtmlFormatting();
            }
        }
    }

    private function convertParagraphs(string $text): string
    {
        $lines = explode("\n", $text);
        foreach ($lines as $index => &$line) {
            if (
                trim($line) !== '' &&
                !preg_match('/^<h[1-6]>.*<\/h[1-6]>$/', $line)
            ) {
                $line = sprintf('<p>%s</p>', trim($line));
            }
        }

        return implode("\n", $lines);
    }
}

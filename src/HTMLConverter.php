<?php

declare(strict_types=1);

namespace achertovsky\markdown;

class HTMLConverter
{
    public function convert(string $text): string
    {
        $text = $this->convertHeadings($text);

        return $text;
    }

    private function convertHeadings(string $text): string
    {
        $lines = explode("\n", $text);
        foreach ($lines as $index => &$line) {
            if (preg_match('/^(#{1,6})\s+(.*)$/', $line, $matches)) {
                $level = strlen($matches[1]);
                $content = trim($matches[2]);
                if ($this->previosAndNextLineIsEmptyLines(
                    $lines,
                    $index
                ) === false) {
                    continue;
                }
                $line = sprintf(
                    '<h%d>%s</h%d>',
                    $level,
                    $content,
                    $level
                );
            }
        }

        return implode("\n", $lines);
    }

    private function previosAndNextLineIsEmptyLines(
        array $lines,
        int $currentLineIndex
    ): bool {
        $previousLineIndex = $currentLineIndex - 1;
        $nextLineIndex = $currentLineIndex + 1;

        $isPreviousLineEmpty = $previousLineIndex < 0 || trim($lines[$previousLineIndex]) === '';
        $isNextLineEmpty = $nextLineIndex >= count($lines) || trim($lines[$nextLineIndex]) === '';

        return $isPreviousLineEmpty && $isNextLineEmpty;
    }
}

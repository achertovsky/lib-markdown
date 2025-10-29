<?php

declare(strict_types=1);

namespace achertovsky\markdown\Converter\MarkdownToHtml;

use achertovsky\markdown\Converter\ConverterInterface;
use achertovsky\markdown\DTO\Lines;

class HeadingConverter implements ConverterInterface
{
    public function convert(Lines $lines): void
    {
        $linesArray = $lines->getLinesLeftToProcess();
        foreach ($linesArray as $index => &$line) {
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

                $lines->removeLineFromLeftovers($index);
                $lines->addLineToProcessed(
                    $index,
                    $line
                );
            }
        }
    }

    private function previosAndNextLineIsEmptyLines(
        Lines $lines,
        int $currentLineIndex
    ): bool {
        $previousLineIndex = $currentLineIndex - 1;
        $nextLineIndex = $currentLineIndex + 1;

        $previousLine = $lines->getProcessedLine($previousLineIndex)
            ?? $lines->getLineLeftToProcess($previousLineIndex)
        ;
        $nextLine = $lines->getProcessedLine($nextLineIndex)
            ?? $lines->getLineLeftToProcess($nextLineIndex)
        ;

        $isPreviousLineEmpty = $previousLine === null || trim($previousLine) === '';
        $isNextLineEmpty = $nextLine === null || trim($nextLine) === '';

        return $isPreviousLineEmpty && $isNextLineEmpty;
    }
}

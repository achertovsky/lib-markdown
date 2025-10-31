<?php

declare(strict_types=1);

namespace achertovsky\markdown\Converter\MarkdownToHtml;

use achertovsky\markdown\Converter\ConverterInterface;
use achertovsky\markdown\DTO\Lines;

class ParagraphConverter implements ConverterInterface
{
    public function convert(Lines $input): void
    {
        $lines = $input->getLinesLeftToProcess();
        $paragraphs = [];
        $currentParagraphIndex = 0;
        $maxIndex = max(array_keys($lines));
        for ($i = 0; $i <= $maxIndex; $i++) {
            if (($lines[$i] ?? null) === null) {
                $currentParagraphIndex = $i + 1;
                continue;
            }

            $paragraphs[$currentParagraphIndex][$i] = $lines[$i];
        }

        foreach ($paragraphs as $paragraphIndex => $lines) {
            $processedParagraph = '<p>' . implode(' ', array_map('trim', $lines)) . '</p>';
            foreach (array_keys($lines) as $lineIndex) {
                $input->removeLineFromLeftovers($lineIndex);
            }
            $input->addLineToProcessed($paragraphIndex, $processedParagraph);
        }
    }
}

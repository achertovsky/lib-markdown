<?php

declare(strict_types=1);

namespace achertovsky\markdown\DTO;

class Lines
{
    public function __construct(
        private array $linesLeftToProcess,
        private array $processedLines = []
    ) {
    }

    public function moveLineToProcessed(int $index): void
    {
        $line = $this->linesLeftToProcess[$index];
        unset($this->linesLeftToProcess[$index]);
        $this->processedLines[$index] = $line;
    }

    /**
     * @return string[]
     */
    public function getProcessedLines(): array
    {
        ksort($this->processedLines);

        return $this->processedLines;
    }
}

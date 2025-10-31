<?php

declare(strict_types=1);

namespace achertovsky\markdown\DTO;

class Lines
{
    /**
     * @param array<int, string> $linesLeftToProcess
     * @param array<int, string> $processedLines
     */
    public function __construct(
        private array $linesLeftToProcess,
        private array $processedLines = []
    ) {
    }

    /**
     * @return string[]
     */
    public function getLinesLeftToProcess(): array
    {
        return $this->linesLeftToProcess;
    }

    public function getLineLeftToProcess(int $index): ?string
    {
        return $this->linesLeftToProcess[$index] ?? null;
    }

    public function removeLineFromLeftovers(int $index): void
    {
        unset($this->linesLeftToProcess[$index]);
    }

    public function addLineToProcessed(
        int $index,
        string $line
    ): void {
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

    public function getProcessedLine(int $index): ?string
    {
        return $this->processedLines[$index] ?? null;
    }
}

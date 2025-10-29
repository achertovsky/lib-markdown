<?php

declare(strict_types=1);

namespace achertovsky\markdown;

use achertovsky\markdown\Converter\ConverterInterface;
use achertovsky\markdown\Exception\MarkdownException;
use achertovsky\markdown\DTO\Lines;
use achertovsky\markdown\Validator\MarkdownInputValidator;

class MarkdownToHTMLConvertOrchestrator
{
    public function __construct(
        private MarkdownInputValidator $validator = new MarkdownInputValidator(),
    ) {
    }

    /**
     * @var ConverterInterface[]
     */
    private array $converters = [];

    public function addConverter(ConverterInterface $converter): self
    {
        $this->converters[] = $converter;

        return $this;
    }

    public function convert(string $text): string
    {
        $linesArray = explode(
            "\n",
            $text
        );
        $lines = new Lines($linesArray);
        $this->processEmptyLines($lines);
        $this->validator->validate($lines);

        foreach ($this->converters as $converter) {
            $converter->convert($lines);
        }

        return implode(
            "\n",
            $lines->getProcessedLines()
        );
    }

    private function processEmptyLines(Lines $lines): void
    {
        foreach ($lines->getLinesLeftToProcess() as $index => $line) {
            if (trim($line) === '') {
                $lines->removeLineFromLeftovers($index);
                $lines->addLineToProcessed($index, '');
            }
        }
    }
}

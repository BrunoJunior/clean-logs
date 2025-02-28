<?php

namespace CleanLogs\FileReader;
use CleanLogs\Exception\TransformerException;
use CleanLogs\Transformer\ToLineTransformer;
use CleanLogs\ValueObject\Line;
use Generator;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

class ToLineReader implements FileReader
{
    /** @var resource  */
    private mixed $inputFile = null;
    private int $lineNumber = 0;

    public function __construct(
        private readonly array $filters = [],
        private readonly LoggerInterface $logger,
        private readonly ToLineTransformer $lineTransformer,
    ) {
    }

    public function __destruct()
    {
        $this->reinit();
    }

    /**
     * @return Generator<Line>
     */
    public function readLine(string $filepath): Generator
    {
        $this->reinit();
        $this->openForReading($filepath);
        while (($buffer = fgets($this->inputFile, 4096)) !== false) {
            $this->lineNumber++;
            try {
                $line = $this->lineTransformer->transform($buffer);
                if ($this->isValidLine($line)) {
                    yield $line;
                }
            } catch (TransformerException $e) {
                $this->logger->warning("[l.$this->lineNumber] " . $e->getMessage());
            }
        }
    }

    private function reinit(): void
    {
        if ($this->inputFile) {
            fclose($this->inputFile);
        }
        $this->lineNumber = 0;
    }

    private function openForReading(string $filepath): void
    {
        $fileResource = fopen($filepath, "r");
        if (!$fileResource) {
            throw new InvalidArgumentException("Unable to open the input file!");
        }
        $this->inputFile = $fileResource;
    }

    private function isValidLine(Line $line): bool
    {
        foreach ($this->filters as $filter) {
            if (!$filter->filter($line)) {
                return false;
            }
        }
        return true;
    }
}
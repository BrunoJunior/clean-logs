<?php

namespace CleanLogs\Exporter;

use CleanLogs\Hasher\Hasher;
use CleanLogs\ValueObject\Line;

class UniqueHashExporter implements Exporter
{

    /** @var resource */
    private mixed $outputFile;
    private array $alreadyExported = [];

    public function __construct(
        private readonly Hasher $hasher,
        private readonly string $outputFilename,
        private readonly string $outputDirectory,
    ) {
        $this->openOutputFileForWriting();
    }

    public function __destruct()
    {
        if ($this->outputFile) {
            fclose($this->outputFile);
        }
    }

    private function openOutputFileForWriting(): void
    {
        $fileResource = fopen($this->outputDirectory . '/' . $this->outputFilename, "w");
        if (!$fileResource) {
            throw new \InvalidArgumentException("Unable to open the output file!");
        }
        $this->outputFile = $fileResource;
    }

    public function export(Line $line): void {
        $hash = $this->hasher->hash($line);
        if (!array_key_exists($hash, $this->alreadyExported)) {
            $this->alreadyExported[$hash] = null;
            fwrite($this->outputFile, $line->getMessage() . "\n");
        }
    }
}
<?php

namespace CleanLogs\Cleaner;

use CleanLogs\Exporter\Exporter;
use CleanLogs\LineReader\LineReader;

class Cleaner
{

    public function __construct(
        private readonly LineReader $reader,
        private readonly Exporter $exporter,
    )
    {
    }

    public function run(): void
    {
        foreach ($this->reader->readLine() as $line) {
            $this->exporter->export($line);
        }
    }
}
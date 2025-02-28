<?php

namespace CleanLogs\LineReader;

use CleanLogs\FileReader\FileReader;
use Generator;

class AllInputLogsLineReader implements LineReader
{
    public function __construct(
        private readonly string $inputDirectory,
        private readonly FileReader $fileReader,
    ) {
    }

    public function readLine(): Generator
    {
        $logFilenames = array_filter(scandir($this->inputDirectory), [self::class, 'isFilenameEndsByLog']);
        foreach ($logFilenames as $filename) {
            yield from $this->fileReader->readLine($this->inputDirectory . '/' . $filename);
        }
    }

    private static function isFilenameEndsByLog(string $filename): bool
    {
        return str_ends_with($filename, '.log');
    }
}
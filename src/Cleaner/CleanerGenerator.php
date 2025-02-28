<?php

namespace CleanLogs\Cleaner;

use CleanLogs\Exporter\UniqueHashExporter;
use CleanLogs\FileReader\ToLineReader;
use CleanLogs\Filter\CategoryLineFilter;
use CleanLogs\Filter\SeverityLineFilter;
use CleanLogs\Hasher\Sha1MessageHasher;
use CleanLogs\LineReader\AllInputLogsLineReader;
use CleanLogs\Transformer\SymfonyLogToLineTransformer;
use Psr\Log\LoggerInterface;

class CleanerGenerator
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function buildUniqueDeprecationsCleaner(string $inputDirectory, string $outputDirectory): Cleaner
    {
        $filters = [
            new CategoryLineFilter(['deprecation']),
            new SeverityLineFilter(['INFO']),
        ];
        $symfonyLogFileReader = new ToLineReader(
            filters: $filters,
            logger: $this->logger,
            lineTransformer: new SymfonyLogToLineTransformer(),
        );
        $allLogFilesReader = new AllInputLogsLineReader($inputDirectory, $symfonyLogFileReader);
        $uniqueHashExporter = new UniqueHashExporter(
            hasher: new Sha1MessageHasher(),
            outputFilename: date('Ymd_His_') . 'deprecations.log',
            outputDirectory: $outputDirectory,
        );
        return new Cleaner($allLogFilesReader, $uniqueHashExporter);
    }
}
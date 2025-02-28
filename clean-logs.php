<?php
include_once "./vendor/autoload.php";

$start = microtime(true);

$publicDir = __DIR__ . '/public';
echo 'Init...';
$fileLogger = new \Analog\Logger();
$fileLogger->handler(\Analog\Handler\File::init("{$publicDir}/logs/" . date("Ymd_His") . ".log"));
$cleanerFactory = new \CleanLogs\Cleaner\CleanerGenerator($fileLogger);

echo "Cleaning...";
$cleanerFactory->buildUniqueDeprecationsCleaner(
    inputDirectory: "{$publicDir}/input",
    outputDirectory: "{$publicDir}/output",
)->run();

$end = microtime(true);

echo sprintf("End of cleaning in %01.2f sec !\n", $end - $start);
echo sprintf("Memory consumed: %01.2f KB \n", memory_get_usage() / 1024);
echo sprintf("Memory peak usage: %01.2f KB \n", memory_get_peak_usage() / 1024);

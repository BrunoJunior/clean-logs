<?php

namespace CleanLogs\FileReader;

use CleanLogs\ValueObject\Line;
use Generator;

interface FileReader
{
    /**
     * @return Generator<Line>
     */
    public function readLine(string $filepath): Generator;
}
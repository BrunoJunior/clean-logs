<?php

namespace CleanLogs\LineReader;

use CleanLogs\ValueObject\Line;
use Generator;

interface LineReader
{
    /**
     * @return Generator<Line>
     */
    function readLine(): Generator;
}
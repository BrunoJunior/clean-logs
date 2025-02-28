<?php

namespace CleanLogs\Hasher;

use CleanLogs\ValueObject\Line;

interface Hasher
{
    function hash(Line $lineReader): string;
}
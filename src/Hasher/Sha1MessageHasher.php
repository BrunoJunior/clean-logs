<?php

namespace CleanLogs\Hasher;

use CleanLogs\ValueObject\Line;

class Sha1MessageHasher implements Hasher
{

    function hash(Line $lineReader): string
    {
        return sha1($lineReader->getMessage());
    }
}
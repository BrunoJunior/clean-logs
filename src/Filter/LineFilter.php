<?php

namespace CleanLogs\Filter;

use CleanLogs\ValueObject\Line;

interface LineFilter
{
    public function filter(Line $line): bool;
}
<?php

namespace CleanLogs\Filter;

use CleanLogs\ValueObject\Line;

class SeverityLineFilter implements LineFilter
{

    public function __construct(private readonly array $validSeverities)
    {
    }

    public function filter(Line $line): bool
    {
        return in_array($line->getSeverity(), $this->validSeverities);
    }
}
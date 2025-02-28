<?php

namespace CleanLogs\Filter;

use CleanLogs\ValueObject\Line;

class CategoryLineFilter implements LineFilter
{

    public function __construct(private readonly array $validCategories)
    {
    }

    public function filter(Line $line): bool
    {
        return in_array($line->getCategory(), $this->validCategories);
    }
}
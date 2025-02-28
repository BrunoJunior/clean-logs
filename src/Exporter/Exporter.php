<?php

namespace CleanLogs\Exporter;

use CleanLogs\ValueObject\Line;

interface Exporter
{
    function export(Line $line): void;
}
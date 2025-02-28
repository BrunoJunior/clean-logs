<?php

namespace CleanLogs\Transformer;

use CleanLogs\Exception\TransformerException;
use CleanLogs\ValueObject\Line;

interface ToLineTransformer
{
    /**
     * @throws TransformerException
     */
    function transform(string $data): Line;
}
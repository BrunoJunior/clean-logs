<?php

namespace CleanLogs\Exception;

use Throwable;

class TransformerException extends \Exception
{
    public function __construct(string $originalValue, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("$message ($originalValue)", $code, $previous);
    }
}
<?php

namespace CleanLogs\Transformer;

use CleanLogs\Exception\TransformerException;
use CleanLogs\ValueObject\Line;

class SymfonyLogToLineTransformer implements ToLineTransformer
{
    private const CHECK_REGEX = "#^\[(\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{6}\+\d{2}:\d{2})] (\w+)\.([A-Z]+): (.*) (\[(.*)])?#";

    /**
     * @throws TransformerException
     */
    function transform(string $data): Line
    {
        $matches = [];
        $match = (bool) preg_match(self::CHECK_REGEX, $data, $matches);
        if (!$match) {
            throw new TransformerException($data, "The line does not respect the correct log format!", 1);
        }
        try {
            return new Line(
                logDateTime: new \DateTimeImmutable($matches[1]),
                category: $matches[2],
                severity: $matches[3],
                message: $matches[4],
                complements: $matches[5] ?? '',
            );
        } catch (\Exception $exception) {
            throw new TransformerException($data, "Unable to get the line date!", 2, $exception);
        }
    }
}
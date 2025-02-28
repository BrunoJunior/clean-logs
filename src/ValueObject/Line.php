<?php

namespace CleanLogs\ValueObject;

class Line
{

    public function __construct(
        private readonly \DateTimeImmutable $logDateTime,
        private readonly string $category,
        private readonly string $severity,
        private readonly string $message,
        private readonly string $complements,
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getLogDateTime(): \DateTimeImmutable
    {
        return $this->logDateTime;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getSeverity(): string
    {
        return $this->severity;
    }

    public function getComplements(): string
    {
        return $this->complements;
    }
}
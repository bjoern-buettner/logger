<?php

namespace Me\BjoernBuettner\Logger;

use Psr\Log\LoggerInterface;

interface LogEntryWriter
{
    public function write(
        string $level,
        string $message,
        array $context,
        int|float $timestamp,
        LoggerInterface $logger
    ): void;
}
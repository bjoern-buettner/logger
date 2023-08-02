<?php
declare(strict_types=1);

namespace Me\BjoernBuettner\Logger;

use Psr\Log\LoggerInterface;

final class LazyWritingLogEntryWriter implements LogEntryWriter
{
    public function write(
        string $level,
        string $message,
        array $context,
        int|float $timestamp,
        LoggerInterface $logger
    ): void {
        register_shutdown_function(function () use ($logger, $level, $message, $context, $timestamp){
            $logger->{$level}(
                $message,
                $context + ['captured@timestamp' => $timestamp],
            );
        });
    }
}
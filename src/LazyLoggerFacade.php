<?php

declare(strict_types=1);

namespace Me\BjoernBuettner\Logger;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Stringable;

final class LazyLoggerFacade implements LoggerInterface
{
    private LogEntryWriter $entry;

    public function __construct(private readonly LoggerInterface $logger, LogEntryWriter $entry)
    {
        $this->entry = $entry ?? new LazyWritingLogEntryWriter();
    }

    public function emergency(Stringable|string $message, array $context = []): void
    {
        $this->log('emergency', $message, $context);
    }

    public function alert(Stringable|string $message, array $context = []): void
    {
        $this->log('alert', $message, $context);
    }

    public function critical(Stringable|string $message, array $context = []): void
    {
        $this->log('critical', $message, $context);
    }

    public function error(Stringable|string $message, array $context = []): void
    {
        $this->log('error', $message, $context);
    }

    public function warning(Stringable|string $message, array $context = []): void
    {
        $this->log('warning', $message, $context);
    }

    public function notice(Stringable|string $message, array $context = []): void
    {
        $this->log('notice', $message, $context);
    }

    public function info(Stringable|string $message, array $context = []): void
    {
        $this->log('info', $message, $context);
    }

    public function debug(Stringable|string $message, array $context = []): void
    {
        $this->log('debug', $message, $context);
    }

    public function log($level, Stringable|string $message, array $context = []): void
    {
        if (!in_array($level, ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'], true)) {
            throw new InvalidArgumentException("Invalid log level $level.");
        }
        $this->entry->write(
            $level,
            "$message",
            $context,
            microtime(true),
            $this->logger,
        );
    }
}
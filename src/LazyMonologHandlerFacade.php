<?php

declare(strict_types=1);

namespace Me\BjoernBuettner\Logger;

use Monolog\Handler\HandlerInterface;
use Monolog\LogRecord;

final class LazyMonologHandlerFacade implements HandlerInterface
{
    public function __construct(private readonly HandlerInterface $handler)
    {
    }

    public function isHandling(LogRecord $record): bool
    {
        return $this->handler->isHandling($record);
    }

    public function handle(LogRecord $record): bool
    {
        if (!$this->handler->isHandling($record)) {
            return false;
        }
        register_shutdown_function(function () use ($record) {
            $this->handler->handle($record);
        });
        return true;
    }

    public function handleBatch(array $records): void
    {
        foreach ($records as $record) {
            $this->handle($record);
        }
    }

    public function close(): void
    {
        // nothing to do here
    }
}
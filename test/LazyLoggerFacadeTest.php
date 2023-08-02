<?php

namespace Me\BjoernBuettner\Logger;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

#[CoversClass(LazyLoggerFacade::class)]
class LazyLoggerFacadeTest extends TestCase
{
    public static function logDoesNotHappenImmediatelyDataProvider(): array
    {
        return [
            'emergency' => ['emergency'],
            'alert' => ['alert'],
            'critical' => ['critical'],
            'error' => ['error'],
            'warning' => ['warning'],
            'notice' => ['notice'],
            'info' => ['info'],
            'debug' => ['debug'],
        ];
    }
    #[DataProvider('logDoesNotHappenImmediatelyDataProvider')]
    #[Test]
    public function logDoesNotHappenImmediately(string $level): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->never())->method($level);
        $logger->expects($this->never())->method('log');
        $writer = $this->createMock(LogEntryWriter::class);
        $writer
            ->expects($this->once())
            ->method('write')
            ->with(
                $level,
                'message',
                [],
                $this->isType('float'),
                $logger
            );
        $lazyLogger = new LazyLoggerFacade($logger, $writer);
        $lazyLogger->{$level}('message');
    }
}

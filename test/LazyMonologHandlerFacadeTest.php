<?php

namespace Me\BjoernBuettner\Logger;

use Monolog\Handler\HandlerInterface;
use Monolog\LogRecord;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LazyMonologHandlerFacadeTest extends TestCase
{
    public static function provideHandling(): iterable
    {
        yield 'true' => [true];
        yield 'false' => [false];
    }
    #[DataProvider('provideHandling')]
    #[Test]
    public function isHandlingPassesThroughResultOfWrappedHandler($handling): void
    {
        $handler = $this->createMock(HandlerInterface::class);
        $handler
            ->expects($this->once())
            ->method('isHandling')
            ->with($record = $this->createStub(LogRecord::class))
            ->willReturn($handling);

        $facade = new LazyMonologHandlerFacade($handler);
        $this->assertSame($handling, $facade->isHandling($record));
    }
    #[Test]
    public function handleCallsWrappedHandler(): void
    {
        $handler = $this->createMock(HandlerInterface::class);
        $handler
            ->expects($this->exactly(2))
            ->method('handle');
        $handler
            ->expects($this->exactly(2))
            ->method('isHandling')
            ->willReturn(true);
        $records = [
            $this->createStub(LogRecord::class),
            $this->createStub(LogRecord::class),
        ];

        $facade = new LazyMonologHandlerFacade($handler);
        $facade->handleBatch($records);
    }
    #[Test]
    public function handleCallsWrappedHandlerOnlyForRelevantRecords(): void
    {
        $handler = $this->createMock(HandlerInterface::class);
        $handler
            ->expects($this->never())
            ->method('handle');
        $handler
            ->expects($this->exactly(2))
            ->method('isHandling')
            ->willReturn(false);
        $records = [
            $this->createStub(LogRecord::class),
            $this->createStub(LogRecord::class),
        ];

        $facade = new LazyMonologHandlerFacade($handler);
        $facade->handleBatch($records);
    }
}

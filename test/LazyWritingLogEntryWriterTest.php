<?php

namespace Me\BjoernBuettner\Logger;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LazyWritingLogEntryWriterTest extends TestCase
{
    public static function provideWriteLog(): array
    {
        return [
            ['debug', 'debug message', ['foo' => 'bar'], time()],
            ['info', 'info message', ['foo' => 'bar'], microtime(true)],
            ['notice', 'notice message', ['foo' => 'bar'], 1234567890],
            ['warning', 'warning message', ['foo' => 'bar'], 1234567891],
            ['error', 'error message', ['foo' => 'bar'], 1234267890],
            ['critical', 'critical message', ['foo' => 'bar'], 1134567890],
            ['alert', 'alert message', ['foo' => 'bar'], 1234557890],
            ['emergency', 'emergency message', ['foo' => 'bar'], 1234567790],
        ];
    }
    #[DataProvider('provideWriteLog')]
    #[Test]
    public function writeLog(string $level, string $message, array $context, int|float $timestamp): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(self::once())->method($level)->with(
            $message,
            $context + ['captured@timestamp' => $timestamp],
        );
        $writer = new LazyWritingLogEntryWriter();
        $writer->write($level, $message, $context, $timestamp, $logger);
    }
}

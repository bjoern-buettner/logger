<?php

namespace Me\BjoernBuettner\Logger;

use PHPUnit\Framework\TestCase;

class EagerRoundRobinFileHandlerTest extends TestCase
{
    public function testEagerRoundRobinFileHandler(): void
    {
        $handler = new EagerRoundRobinFileHandler(__DIR__, $file = uniqid('test', true));
        $this->assertMatchesRegularExpression(
            '#'. preg_quote(__DIR__. DIRECTORY_SEPARATOR . $file . '.', '#') . '[0-9]{8}\.[0-9]{3}\.log#',
            $handler->getUrl(),
        );
    }
}

<?php
declare(strict_types=1);

namespace Me\BjoernBuettner\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Level;

class EagerRoundRobinFileHandler extends StreamHandler
{
    /**
     * Creates a logfile in the given directory with the given filename.
     * Adds date(Ymd) and a three digit random number to the filename.
     * The extension log is added automatically.
     */
    public function __construct(
        string $directory = '/var/logs',
        string $filename = 'application',
        int $randomDigits = 3,
        int|string|Level $level = Level::Debug,
        bool $bubble = true,
        ?int $filePermission = null,
        bool $useLocking = false
    ) {
        $maxNumber = 10 ** $randomDigits - 1;
        $stream = $directory . DIRECTORY_SEPARATOR . $filename . '.' . date('Ymd') . '.'
            . str_pad((string) mt_rand(0,$maxNumber), $randomDigits, '0', STR_PAD_LEFT) . '.log';
        parent::__construct($stream, $level, $bubble, $filePermission, $useLocking);
    }
}
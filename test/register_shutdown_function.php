<?php
declare(strict_types=1);

namespace Me\BjoernBuettner\Logger;

function register_shutdown_function(callable $function): void
{
    $function();
}

<?php

namespace Infra\Log;

use Domain\Log\LoggerInterface;

class StdErrorLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        error_log($message);
    }
}
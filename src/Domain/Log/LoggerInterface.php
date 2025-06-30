<?php

namespace Domain\Log;

interface LoggerInterface
{
    public function log(string $message): void;
}
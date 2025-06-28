<?php

class Redis {
    public function connect(string $host, int $port = 6379): bool {
        return true;
    }

    public function set(string $key, string $value): bool {
        return true;
    }

    public function get(string $key): ?string {
        return null;
    }

    public function flushAll(): bool {
        return true;
    }

    public function setex(string $key, int $ttl, string $value): bool { return true; }

}


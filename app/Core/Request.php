<?php

declare(strict_types=1);

class Request
{
    public function query(
        string $key,
        mixed $default = null
    ): mixed {

        if (isset($_GET[$key])) {
            return trim((string) $_GET[$key]);
        }
        return $default;
    }

    public function post(
        string $key,
        mixed $default = null
    ): mixed {

        if (isset($_POST[$key])) {
            if (is_array($_POST[$key])) {
                return $_POST[$key];
            }
            return trim((string) $_POST[$key]);
        }
        return $default;
    }

    public function all(): array
    {
        return $_POST;
    }

    public function has(string $key): bool
    {
        return isset($_POST[$key]);
    }

    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isGet(): bool
    {
        return $this->method() === 'GET';
    }

    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    public function file(string $key): ?array
    {
        return $_FILES[$key] ?? null;
    }
}

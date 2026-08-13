<?php

declare(strict_types=1);

class Session
{
    public function set(
        string $key,
        mixed $value
    ): void {

        $_SESSION[$key] = $value;
    }

    public function get(
        string $key,
        mixed $default = null
    ): mixed {

        return $_SESSION[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function clear(): void
    {
        session_unset();
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function flash(
        string $key,
        mixed $value
    ): void {

        $_SESSION['flash'][$key] = $value;
    }

    public function getFlash(
        string $key,
        mixed $default = null
    ): mixed {

        if (!isset($_SESSION['flash'][$key])) {
            return $default;
        }

        $value = $_SESSION['flash'][$key];

        unset($_SESSION['flash'][$key]);

        return $value;
    }
}
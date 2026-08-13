<?php

declare(strict_types=1);

function dd(...$value): void
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    exit();
}
function d(...$value): void
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}
function e(string|int|float|bool|null $value): string
{
    return htmlspecialchars((string) $value ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): never
{
    header("Location: {$url}");
    exit;
}

function redirectBack(): never
{
    $url = $_SERVER['HTTP_REFERER'] ?? '/';

    redirect($url);
}

function old(string $key, string $default = ''): string
{
    return $_SESSION['old'][$key] ?? $default;
}

function flash(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

function asset(string $path): string
{
    return APP_URL . '/' . ltrim($path, '/');
}

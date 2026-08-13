<?php

declare(strict_types=1);

class Auth
{
    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public function user(): ?array // mixed<->array
    {
        return $_SESSION['user'] ?? null;
    }
    public function role(): ?string
    {
        return $_SESSION['user']['role'] ?? null;
    }

    public function id(): ?int // mixed<-> int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    public function login(array $user): void
    {
        session_regenerate_id(true); // This prevents session fixation attacks after login
        $_SESSION['user'] = [

            'id' => $user['id'],

            'username' => $user['username'],

            'full_name' => $user['full_name'],

            'role' => $user['role']
        ];
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {

            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }
    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role(), $roles, true);
    }
}

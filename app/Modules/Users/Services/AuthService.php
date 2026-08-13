<?php

declare(strict_types=1);

class AuthService
{
    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }

    public function authenticate(
        string $username,
        string $password
    ): array|false {

        $user = $this->users->findByUsername($username);

        if (!$user) {
            return false;
        }

        // compare given password with hashed password
        // if (!password_verify($password, $user['password'])) {
        //     return false;
        // }

        //compare passwords as they are
        if ($password !== $user['password']) {
            return false;
        }

        return $user;
    }
}

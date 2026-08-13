<?php

declare(strict_types=1);

class AuthMiddleware
{
    public function handle(): void
    {
        $auth = new Auth();

        
        if (!$auth->check()) {

            header('Location: ' . APP_URL . '/login');

            exit;
        }
    }
}

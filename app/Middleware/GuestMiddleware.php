<?php
// for login pages
declare(strict_types=1);

class GuestMiddleware
{
    public function handle(): void
    {
        $auth = new Auth();

        if ($auth->check()) {

            header('Location: ' . APP_URL);

            exit;
        }
    }
}
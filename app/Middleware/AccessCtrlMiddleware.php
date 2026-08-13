<?php

// Instead of creating
// AdminMiddleware
// SupervisorMiddleware
// PHMMiddleware
// MOHMiddleware


declare(strict_types=1);

class AccessCtrlMiddleware
{
    public function handle(string ...$roles): void
    {
        $auth = new Auth();


        //NOTE CHECK AUTHENTICATION TWICE AS EXTRA SECURITY MEASURE
        if (!$auth->check()) {

            header('Location: ' . APP_URL . '/login');

            exit;
        }
        if (!$auth->hasRole(...$roles)) {

            http_response_code(403);

            echo "403 Forbidden";

            exit;
        }
    }
}

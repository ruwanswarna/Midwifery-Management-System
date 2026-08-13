<?php

declare(strict_types=1);

class App
{
    public function run(): void
    {
        $router = new Router();

        require ROOT_PATH . '/routes/web/index.php';
        require ROOT_PATH . '/routes/api/index.php';

        $router->dispatch();
    }
}

<?php

declare(strict_types=1);

class Response
{   // redirect to this location
    public function redirect(string $url): never
    {
        header("Location: {$url}");
        exit;
    }

    // redirect back to the same page
    public function back(): never
    {
        $url = $_SERVER['HTTP_REFERER'] ?? APP_URL;

        $this->redirect($url);
    }

    // send json response
    public function json(array $data): never
    {
        header('Content-Type: application/json');

        echo json_encode($data);

        exit;
    }

    //set the status code to the given
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    //REDIRECT TO NOT FOUND PAGE
    public static function notFound(): void
    {
        http_response_code(404);

        require ROOT_PATH . '/resources/views/errors/404.php';

        exit;
    }
}

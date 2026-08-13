<?php

declare(strict_types=1);

// Every controller will extend this.
class Controller
{
    protected Request $request;
    protected Response $response;
    protected View $view;
    protected Session $session;
    public function __construct()
    {
        $this->request = new Request(); // request object
        $this->response = new Response(); // response object
        $this->view = new View(); //view object
        $this->session = new Session(); // session object
    }
}

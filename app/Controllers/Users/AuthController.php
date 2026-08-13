<?php

declare(strict_types=1);

class AuthController extends Controller
{
    private AuthService $service;
    public function __construct()
    {
        parent::__construct();

        $this->service = new AuthService();
    }

    public function indexLogin(): void
    {
        $this->view->render(
            'auth/login',
            ['title' => 'Sign In'],
            'auth'
        );
    }

    public function indexRegister(): void
    {
        $this->view->render(
            'auth/register',
            ['title' => 'Register'],
            'auth'
        );
    }

    public function register(): void
    {
        // User accounts include a full name, role and status. Those values
        // must be assigned through the administrator-managed Users module;
        // accepting only a public username/password would create an invalid
        // or over-privileged account.
        $_SESSION['errors'] = [
            'register' => 'New user accounts must be created by an administrator.',
        ];

        $this->response->back();
    }

    public function login(): void
    {
        $validator = new LoginValidator();
        if (!$validator->validate($_POST)) {

            $_SESSION['errors'] = $validator->errors(); // if there are errors put them in to a session

            $this->response->back(); // back to the same page since ther are errors
        }

        // if no errors continue
        $user = $this->service->authenticate(
            $this->request->post('username'),
            $this->request->post('password')
        );

        if (!$user) {

            $_SESSION['errors'] = [
                'login' => 'Invalid username or password.'
            ];

            $this->response->back();
        }

        (new Auth())->login($user);


        $this->response->redirect(APP_URL);
    }

    public function logout(): void
    {
        (new Auth())->logout();

        $this->response->redirect(APP_URL . '/login');
    }
}

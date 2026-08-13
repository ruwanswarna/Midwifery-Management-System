<?php

declare(strict_types=1);

class UserController extends Controller
{
    private UserService $service;

    public function __construct()
    {
        parent::__construct();

        $this->service = new UserService();
    }

    /**
     * Display all users.
     */
    public function index(): void
    {

        $middleware = new AuthMiddleware();
        $middleware->handle();

        $this->view->render(
            'users/index',
            [
                'title' => 'Users',
                'breadcrumbs' => [
                    'Dashboard' => '/dashboard',
                    'Mothers' => '/mothers',
                ],
                'users' => $this->service->getAll(),
                'roles' => $this->service->getRoles()
            ]
        );
    }

    /**
     * Display create form.
     */
    public function create(): void
    {
        $this->view->render(
            'users/create',
            [
                'title' => 'Create User',
                'roles' => $this->service->getRoles()
            ]
        );
    }

    /**
     * Store new user.
     */
    public function store(): void
    {
        if ($this->service->create($_POST)) {

            $_SESSION['success'] = 'User created successfully.';

            $this->response->redirect(
                APP_URL . '/users'
            );
        }

        $this->response->back();
    }

    /**
     * Display one user.
     */
    public function show(int $id): void
    {
        $user = $this->service->findById($id);

        if (!$user) {

            $this->response->notFound();

            return;
        }

        $this->view->render(
            'users/show',
            [
                'title' => 'User Details',
                'user' => $user
            ]
        );
    }

    /**
     * Display edit form.
     */
    public function edit(int $id): void
    {
        $user = $this->service->findById($id);

        if (!$user) {

            $this->response->notFound();

            return;
        }

        $this->view->render(
            'users/edit',
            [
                'title' => 'Edit User',
                'user' => $user,
                'roles' => $this->service->getRoles()
            ]
        );
    }

    /**
     * Update existing user.
     */
    public function update(int $id): void
    {
        if ($this->service->update($id, $_POST)) {

            $_SESSION['success'] = 'User updated successfully.';

            $this->response->redirect(
                APP_URL . '/users'
            );
        }

        $this->response->back();
    }

    /**
     * Delete user.
     */
    public function delete(int $id): void
    {
        if ($this->service->delete($id)) {

            $_SESSION['success'] = 'User deleted successfully.';
        }

        $this->response->redirect(
            APP_URL . '/users'
        );
    }
}

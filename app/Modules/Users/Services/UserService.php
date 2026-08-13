<?php

declare(strict_types=1);

class UserService
{
    private UserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    /**
     * Get all users.
     */
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    /**
     * Get one user.
     */
    public function findById(int $id): array|false
    {
        return $this->repository->findById($id);
    }

    /**
     * Get all roles.
     */
    public function getRoles(): array
    {
        return $this->repository->getRoles();
    }

    /**
     * Create user.
     */
    public function create(array $data): bool
    {
        $validator = new UserValidator();

        if (!$validator->validate($data)) {

            $_SESSION['errors'] = $validator->errors();

            return false;
        }

        if ($this->repository->findByUsername($data['username'])) {

            $_SESSION['errors']['username'] =
                'Username already exists.';

            return false;
        }

        return $this->repository->create($data);
    }

    /**
     * Update user.
     */
    public function update(
        int $id,
        array $data
    ): bool {

        $validator = new UserValidator();

        if (!$validator->validate($data, $id)) {

            $_SESSION['errors'] = $validator->errors();

            return false;
        }

        return $this->repository->update(
            $id,
            $data
        );
    }

    /**
     * Update password.
     */
    public function updatePassword(
        int $id,
        string $password
    ): bool {

        return $this->repository->updatePassword(
            $id,
            $password
        );
    }

    /**
     * Delete user.
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}

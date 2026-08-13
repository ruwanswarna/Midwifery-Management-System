<?php

declare(strict_types=1);

class UserValidator
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Validate user creation
     */
    public function validateCreate(array $data): array
    {
        $errors = [];

        /* ---------- Username ---------- */

        if (empty(trim($data['username'] ?? ''))) {

            $errors['username'] = 'Username is required.';
        } else {

            $existingUser = $this->userRepository
                ->findByUsername($data['username']);

            if ($existingUser) {
                $errors['username'] = 'Username already exists.';
            }
        }

        /* ---------- Full Name ---------- */

        if (empty(trim($data['full_name'] ?? ''))) {

            $errors['full_name'] = 'Full name is required.';
        }

        /* ---------- Password ---------- */

        if (empty($data['password'])) {

            $errors['password'] = 'Password is required.';
        } elseif (strlen($data['password']) < 8) {

            $errors['password'] =
                'Password must be at least 8 characters.';
        }

        /* ---------- Role ---------- */

        if (empty($data['role_id'])) {

            $errors['role_id'] = 'Please select a role.';
        }

        /* ---------- Status ---------- */

        if (empty($data['status'])) {

            $errors['status'] = 'Please select a status.';
        }

        return $errors;
    }

    /**
     * Validate user update
     */
    public function validateUpdate(
        int $id,
        array $data
    ): array {

        $errors = [];

        /* ---------- Username ---------- */

        if (empty(trim($data['username'] ?? ''))) {

            $errors['username'] = 'Username is required.';
        } else {

            $existingUser = $this->userRepository
                ->findByUsername($data['username']);

            if (
                $existingUser &&
                (int)$existingUser['id'] !== $id
            ) {

                $errors['username'] =
                    'Username already exists.';
            }
        }

        /* ---------- Full Name ---------- */

        if (empty(trim($data['full_name'] ?? ''))) {

            $errors['full_name'] = 'Full name is required.';
        }

        /* ---------- Password ---------- */

        if (!empty($data['password'])) {

            if (strlen($data['password']) < 8) {

                $errors['password'] =
                    'Password must be at least 8 characters.';
            }
        }

        /* ---------- Role ---------- */

        if (empty($data['role_id'])) {

            $errors['role_id'] = 'Please select a role.';
        }

        /* ---------- Status ---------- */

        if (empty($data['status'])) {

            $errors['status'] = 'Please select a status.';
        }

        return $errors;
    }
}

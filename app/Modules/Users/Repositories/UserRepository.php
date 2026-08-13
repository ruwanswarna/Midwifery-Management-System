<?php

declare(strict_types=1);

class UserRepository extends Repository
{
    public function getAll(): array
    {
        return $this->findAll(
            "
            SELECT
                users.*,
                roles.name AS role_name
            FROM users
            INNER JOIN roles
                ON users.role_id = roles.id
            ORDER BY users.full_name
            "
        );
    }

    public function findById(int $id): ?array
    {
        return $this->findOne(
            "
            SELECT
                users.*,
                roles.name AS role_name
            FROM users
            INNER JOIN roles
                ON users.role_id = roles.id
            WHERE users.id = :id
            ",
            [
                'id' => $id
            ]
        );
    }

    public function findByUsername(string $username): ?array
    {
        return $this->findOne(
            "
            SELECT users.*,
            roles.name AS role
            FROM users
            INNER JOIN roles
                ON users.role_id = roles.id
            WHERE username = :username
            LIMIT 1
            ",
            [
                'username' => $username
            ]
        );
    }

    public function create(array $data): bool
    {
        return $this->execute(
            "
            INSERT INTO users
            (
                username,
                password,
                full_name,
                role_id,
                status
            )
            VALUES
            (
                :username,
                :password,
                :full_name,
                :role_id,
                :status
            )
            ",
            [
                'username'  => $data['username'],
                'password'  => $data['password'],
                'full_name' => $data['full_name'],
                'role_id'   => $data['role_id'],
                'status'    => $data['status']
            ]
        );
    }

    public function update(
        int $id,
        array $data
    ): bool {

        return $this->execute(
            "
            UPDATE users
            SET
                username = :username,
                full_name = :full_name,
                role_id = :role_id,
                status = :status
            WHERE id = :id
            ",
            [
                'id'        => $id,
                'username'  => $data['username'],
                'full_name' => $data['full_name'],
                'role_id'   => $data['role_id'],
                'status'    => $data['status']
            ]
        );
    }

    public function updatePassword(
        int $id,
        string $password
    ): bool {

        return $this->execute(
            "
            UPDATE users
            SET
                password = :password
            WHERE id = :id
            ",
            [
                'id'       => $id,
                'password' => $password
            ]
        );
    }

    public function delete(int $id): bool
    {
        return $this->execute(
            "
            DELETE FROM users
            WHERE id = :id
            ",
            [
                'id' => $id
            ]
        );
    }

    public function getRoles(): array
    {
        return $this->findAll(
            "
            SELECT *
            FROM roles
            ORDER BY name
            "
        );
    }
}

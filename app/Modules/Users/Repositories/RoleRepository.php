<?php
class RoleRepository extends Repository
{
    public function getAll(): array
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

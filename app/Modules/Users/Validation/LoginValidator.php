<?php

declare(strict_types=1);

class LoginValidator extends Validator
{
    public function validate(array $data): bool
    {
        $this->required(
            'username',
            $data['username'] ?? ''
        );

        $this->required(
            'password',
            $data['password'] ?? ''
        );

        return $this->passes(); // if errors return false
    }
}

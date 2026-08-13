<?php

declare(strict_types=1);

abstract class Validator
{
    protected array $errors = [];

    public function errors(): array
    {
        return $this->errors;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    protected function addError(
        string $field,
        string $message
    ): void {

        $this->errors[$field] = $message;
    }

    protected function required(
        string $field,
        mixed $value
    ): void {

        if (trim($value) === '') {
            $this->addError(
                $field,
                "{$field} is required."
            );
        }
    }

    protected function maxLength(
        string $field,
        string $value,
        int $length
    ): void {

        if (strlen($value) > $length) {
            $this->addError(
                $field,
                "{$field} may not exceed {$length} characters."
            );
        }
    }

    protected function minLength(
        string $field,
        string $value,
        int $length
    ): void {

        if (strlen($value) < $length) {
            $this->addError(
                $field,
                "{$field} must contain at least {$length} characters."
            );
        }
    }

    protected function email(
        string $field,
        string $value
    ): void {

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError(
                $field,
                "Invalid email address."
            );
        }
    }

    protected function numeric(
        string $field,
        mixed $value
    ): void {

        if (!is_numeric($value)) {
            $this->addError(
                $field,
                "{$field} must be numeric."
            );
        }
    }
}
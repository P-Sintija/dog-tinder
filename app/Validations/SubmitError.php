<?php

namespace App\Validations;

class SubmitError
{
    private string $name = '';
    private string $password = '';

    public function setNameError(string $error): void
    {
        $this->name = $error;
    }

    public function getNameError(): string
    {
        return $this->name;
    }

    public function setPasswordError(string $error): void
    {
        $this->password = $error;
    }

    public function getPasswordError(): string
    {
        return $this->password;
    }
}
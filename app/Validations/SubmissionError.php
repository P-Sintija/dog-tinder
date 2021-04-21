<?php

namespace App\Validations;

class SubmissionError
{
    private string $name = '';
    private string $password = '';
    private string $personality = '';

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

    public function setPersonalityError(string $error): void
    {
        $this->personality = $error;
    }

    public function getPersonalityError(): string
    {
        return $this->personality;
    }
}
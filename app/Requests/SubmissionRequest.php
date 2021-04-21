<?php

namespace App\Requests;

class SubmissionRequest
{
    private string $name;
    private string $password;
    private string $personality;

    public function __construct(string $name, string $password, string $personality)
    {
        $this->name = $name;
        $this->password = $password;
        $this->personality = $personality;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPersonality(): string
    {
        return $this->personality;
    }
}
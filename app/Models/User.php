<?php

namespace App\Models;

class User
{
    private string $name;
    private string $hash;
    private string $personality;
    private string $gender;
    private string $lookingFor;
    private ?int $id;

    public function __construct(
        string $name,
        string $hash,
        string $personality,
        string $gender,
        string $lookingFor,
        int $id = null)
    {
        $this->name = $name;
        $this->hash = $hash;
        $this->personality = $personality;
        $this->gender = $gender;
        $this->lookingFor = $lookingFor;
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getLookingFor(): string
    {
        return $this->lookingFor;
    }

    public function getPersonality(): string
    {
        return $this->personality;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}
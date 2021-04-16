<?php
namespace App\Models;

class UserImages
{
    private int $id;
    private ?string $first;
    private ?string $second;
    private ?string $third;

    public function __construct(int $id, ?string $first, ?string $second, ?string $third)
    {
        $this->id = $id;
        $this->first = $first;
        $this->second = $second;
        $this->third = $third;
    }

    public function getFirstImage(): ?string
    {
        return $this->first;
    }

    public function getSecondImage(): ?string
    {
        return $this->second;
    }

    public function getThirdImage(): ?string
    {
        return $this->third;
    }
}
<?php

namespace App\Models;

class ImagePaths
{
    private string $fileExtension;
    private string $temporaryLocation;
    private int $id;
    private string $key;

    public function __construct(
        string $fileExtension,
        string $temporaryLocation,
        int $id,
        string $key)
    {
        $this->fileExtension = $fileExtension;
        $this->temporaryLocation = $temporaryLocation;
        $this->id = $id;
        $this->key = $key;
    }


    public function getFileExtension(): string
    {
        return $this->fileExtension;
    }

    public function getTemporaryLocation(): string
    {
        return $this->temporaryLocation;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
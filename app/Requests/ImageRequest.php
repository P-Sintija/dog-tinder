<?php

namespace App\Requests;

class ImageRequest
{
    private string $originalName;
    private string $fileExtension;
    private string $temporaryLocation;
    private int $id;
    private string $key;

    public function __construct(
        string $originalName,
        string $fileExtension,
        string $temporaryLocation,
        int $id,
        string $key)
    {
        $this->originalName = $originalName;
        $this->fileExtension = $fileExtension;
        $this->temporaryLocation = $temporaryLocation;
        $this->id = $id;
        $this->key = $key;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
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
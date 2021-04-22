<?php

namespace App\Requests;

class ImageRequest
{
    private string $originalName;
    private string $type;
    private string $temporaryLocation;
    private string $error;
    private string $size;
    private string $fileExtension;
    private int $id;
    private string $key;

    public function __construct(
        string $originalName,
        string $type,
        string $temporaryLocation,
        string $error,
        string $size,
        string $fileExtension,
        int $id,
        string $key)
    {
        $this->originalName = $originalName;
        $this->type = $type;
        $this->temporaryLocation = $temporaryLocation;
        $this->error = $error;
        $this->size = $size;
        $this->fileExtension = $fileExtension;
        $this->id = $id;
        $this->key = $key;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTemporaryLocation(): string
    {
        return $this->temporaryLocation;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getFileExtension(): string
    {
        return $this->fileExtension;
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
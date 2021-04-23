<?php
namespace App\Validations;

class ImageValidationErrors
{
    private string $type = '';
    private string $size = '';
    private string $status = '';

    public function setTypeError(string $error): void
    {
        $this->type = $error;
    }

    public function getTypeError(): string
    {
        return $this->type;
    }

    public function setSizeError(string $error): void
    {
        $this->size = $error;
    }

    public function getSizedError(): string
    {
        return $this->size;
    }

    public function setStatusError(string $error): void
    {
        $this->status = $error;
    }

    public function getStatusError(): string
    {
        return $this->status;
    }
}
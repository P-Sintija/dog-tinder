<?php

namespace App\Controllers;


use App\Requests\ImageRequest;
use App\Services\ImageUploadService;
use App\Validations\ImageValidation;


class ImageUploadController
{
    private ImageUploadService $service;
    private ImageValidation $validation;

    public function __construct(ImageUploadService $service, ImageValidation $validation)
    {
        $this->service = $service;
        $this->validation = $validation;
    }


    public function upload(array $vars): void
    {
        $fileExtension = explode('.', $_FILES['image']['name']);
        $fileExtensionLowercase = strtolower(end($fileExtension));

        $image = new ImageRequest(
            $_FILES['image']['name'],
            $_FILES['image']['type'],
            $_FILES['image']['tmp_name'],
            $_FILES['image']['error'],
            $_FILES['image']['size'],
            $fileExtensionLowercase,
            (int)$vars['id'],
            $_POST['upload']
        );

        if ($this->validation->checkFileProperties($image, 12345)) {
            $this->service->uploadImage($image);
        }

        $link = $_SERVER['HTTP_ORIGIN'] . '/user/' . $vars['id'];
        header('Location:' . $link);
    }

}
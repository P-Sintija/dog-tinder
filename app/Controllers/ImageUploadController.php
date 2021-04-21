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

        if (isset($_POST['upload'])) {

            $fileExtension = explode('.', $_FILES['image']['name']);
            $fileExtensionLowercase = strtolower(end($fileExtension));
            $allowedExtensions = [
                'jpg',
                'png'
            ];

            // if($this->validation->checkFileProperties($vars,$_POST,$_FILES)){}

            if ($this->validation->checkFileType($allowedExtensions, $fileExtensionLowercase) &&
                $this->validation->checkUploadError($_FILES['image']['error'])/* &&
                $this->validation->checkFileSize($_FILES['image']['size'], 6000000)*/) {

                $this->service->uploadImage(new ImageRequest(
                    $_FILES['image']['name'],
                    $fileExtensionLowercase,
                    $_FILES['image']['tmp_name'],
                    (int)$vars['id'],
                    $_POST['upload']
                ));
            };

        }

        $link = $_SERVER['HTTP_ORIGIN'] . '/user/' . $vars['id'];

        header('Location:' . $link);

    }


}
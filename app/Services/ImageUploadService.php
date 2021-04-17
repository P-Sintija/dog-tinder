<?php

namespace App\Services;

use App\Models\ImagePaths;
use App\Repositories\UserImageRepository;

class ImageUploadService
{
    private UserImageRepository $imageRepository;

    public function __construct(UserImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function uploadImage(ImagePaths $path): void
    {
        //mkdir('/storage/files/pictures/JAUNS_FOLDERIS/');

        $fileName = uniqid('', true) . "." . $path->getFileExtension();
        $location = 'Images/' . $fileName;
        move_uploaded_file($path->getTemporaryLocation(), $location);
        $this->imageRepository->edit($path, $location);
    }


}
<?php

namespace App\Services;

use App\Requests\ImageRequest;
use App\Repositories\UserImageRepository;
use \Gumlet\ImageResize;

class ImageUploadService
{
    private UserImageRepository $imageRepository;

    public function __construct(UserImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function uploadImage(ImageRequest $path): void
    {

//////// original file //////////////
        $originalFileName = substr(
            $path->getOriginalName(), 0, strpos($path->getOriginalName(), strtolower($path->getFileExtension())) - 1);

        if (!is_dir(__DIR__ . '/../../storage/original-pictures/' . $path->getId())) {
            mkdir(__DIR__ . '/../../storage/original-pictures/' . $path->getId(), 0777, true);
        }
        $originalFileLocation = __DIR__ . '/../../storage/original-pictures/' . $path->getId() . '/' . $originalFileName . '.' . $path->getFileExtension();
        move_uploaded_file($path->getTemporaryLocation(), $originalFileLocation);


///////// preview file //////////////
        $previewFileName = uniqid('', true) . "." . $path->getFileExtension();

        if (!is_dir(__DIR__ . '/../../storage/preview-pictures/' . $path->getId())) {
            mkdir(__DIR__ . '/../../storage/preview-pictures/' . $path->getId(), 0777, true);
        }

        $previewFileLocation = __DIR__ . '/../../storage/preview-pictures/' . $path->getId() . '/' . $previewFileName;
        // copy($originalFileLocation,  $previewFileLocation);

        $image = new ImageResize($originalFileLocation);
        $image->resizeToWidth(400);
        $image->save($previewFileLocation);

//////// save in directorie ///////////

        $this->imageRepository->edit($path, '/pictures/' . $path->getId() . '/' . $previewFileLocation,'');
        $this->imageRepository->edit($path, '/storage/preview-pictures/' . $path->getId() . '/' . $previewFileName, '_preview');
        $this->imageRepository->edit($path, '/storage/original-pictures/' . $path->getId() . '/' . $originalFileName . '.' . $path->getFileExtension(), '_original');
    }


}
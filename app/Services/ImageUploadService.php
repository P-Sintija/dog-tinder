<?php

namespace App\Services;

use App\Requests\ImageRequest;
use App\Repositories\UserImageRepository;
use \Gumlet\ImageResize;

class ImageUploadService
{
    const ORIGINAL_FILES = '/../../storage/original-pictures/';
    const PREVIEW_FILES = '/../../storage/preview-pictures/';
    private UserImageRepository $imageRepository;

    public function __construct(UserImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function uploadImage(ImageRequest $path): void
    {
        $originalFileLocation = $this->uploadOriginalFile($path);
        $previewFileName = $this->uploadPreviewFile($path, $originalFileLocation);
        $this->saveUploadedFiles($path, $previewFileName);
    }


    private function uploadOriginalFile(ImageRequest $path): string
    {
        $originalFileName = substr(
            $path->getOriginalName(), 0, strpos($path->getOriginalName(),
                strtolower($path->getFileExtension())) - 1);

        if (!is_dir(__DIR__ . self::ORIGINAL_FILES . $path->getId())) {
            mkdir(__DIR__ .  self::ORIGINAL_FILES . $path->getId(), 0777, true);
        }
        $originalFileLocation = __DIR__ .  self::ORIGINAL_FILES . $path->getId() . '/' .
            $originalFileName . '.' . $path->getFileExtension();
        move_uploaded_file($path->getTemporaryLocation(), $originalFileLocation);

        return $originalFileLocation;
    }

    private function uploadPreviewFile(ImageRequest $path, string $originalFileLocation): string
    {
        $previewFileName = uniqid('', true) . "." . $path->getFileExtension();

        if (!is_dir(__DIR__ . self::PREVIEW_FILES . $path->getId())) {
            mkdir(__DIR__ . self::PREVIEW_FILES . $path->getId(), 0777, true);
        }

        $previewFileLocation = __DIR__ . self::PREVIEW_FILES . $path->getId() . '/' . $previewFileName;

        $image = new ImageResize($originalFileLocation);
        $image->resizeToWidth(400);
        $image->save($previewFileLocation);

        return $previewFileName;
    }

    private function saveUploadedFiles(ImageRequest $path, string $previewFileName): void
    {

        $previewFileLocation = __DIR__ . self::PREVIEW_FILES . $path->getId() . '/' . $previewFileName;
        $originalFileName = substr(
            $path->getOriginalName(), 0,
            strpos($path->getOriginalName(), strtolower($path->getFileExtension())) - 1);

        $this->imageRepository->edit(
            $path, '/pictures/' . $path->getId() . '/' . $previewFileLocation, '');
        $this->imageRepository->edit(
            $path, self::PREVIEW_FILES . $path->getId() . '/' . $previewFileName, '_preview');
        $this->imageRepository->edit(
            $path,  self::ORIGINAL_FILES . $path->getId() . '/' . $originalFileName . '.' .
            $path->getFileExtension(), '_original');
    }

}
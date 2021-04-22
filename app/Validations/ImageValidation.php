<?php

namespace App\Validations;

use App\Requests\ImageRequest;

class ImageValidation
{
    const MAX_SIZE = 959595;
    const TYPE = [
        'jpg',
        'png'
    ];


    public function checkFileProperties(ImageRequest $request, int $size): bool
    {
        return $this->checkFileType(self::TYPE, $request->getFileExtension()) &&
            // $this->checkFileSize($size, self::MAX_SIZE) &&
            $this->checkUploadError($request->getError());
    }

    private function checkFileType(array $allowedExtensions, string $fileExtensionLowercase): bool
    {
        return in_array($fileExtensionLowercase, $allowedExtensions);
    }

    private function checkUploadError(int $bool): bool
    {
        return $bool === 0;
    }

    private function checkFileSize(int $size, int $maxSize): bool
    {
        return $size <= $maxSize;
    }
}
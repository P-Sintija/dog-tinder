<?php

namespace App\Validations;

use App\Requests\ImageRequest;
use League\MimeTypeDetection\FinfoMimeTypeDetector;

class ImageValidation
{
    const FILE_MAX_SIZE = 1105000;
    const ALLOWED_FILE_TYPES = [
        'image/png',
        'image/jpeg'
    ];
    private FinfoMimeTypeDetector $detector;
    private ImageValidationErrors $errors;

    public function __construct(FinfoMimeTypeDetector $detector, ImageValidationErrors $errors)
    {
        $this->detector = $detector;
        $this->errors = $errors;
    }

    public function getTypeError(): string
    {
        return $this->errors->getTypeError();
    }

    public function getSizeError(): string
    {
        return $this->errors->getSizedError();
    }

    public function getStatusError(): string
    {
        return $this->errors->getStatusError();
    }


    public function checkFileProperties(ImageRequest $request): bool
    {
        return $this->checkFileType($request->getTemporaryLocation()) &&
            $this->checkFileSize($request->getSize(), self::FILE_MAX_SIZE) &&
            $this->checkUploadError($request->getError());
    }

    private function checkFileType(string $path): bool
    {
        $mimeType = $this->detector->detectMimeTypeFromFile($path);
        if (!in_array($mimeType, self::ALLOWED_FILE_TYPES)) {
            $this->errors->setTypeError('Invalid file type');
        }

        return in_array($mimeType, self::ALLOWED_FILE_TYPES);
    }

    private function checkUploadError(int $bool): bool
    {
        if ($bool === 1) {
            $this->errors->setStatusError('Something went wrong');
        }
        return $bool === 0;
    }

    private function checkFileSize(int $size, int $maxSize): bool
    {
        if ($size > $maxSize) {
            $this->errors->setSizeError('File too big');
        }
        return $size <= $maxSize;
    }
}
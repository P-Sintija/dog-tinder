<?php

namespace App\Services;

use App\Repositories\UserImageRepository;

class DeleteImageService
{
    const PREVIEW_FILE_PATH = '/storage/preview-pictures/';
    private UserImageRepository $imageRepository;

    public function __construct(UserImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function delete(string $id, string $fileName): void
    {
        $images = $this->imageRepository->searchUserImages('id', $id);

        $keys = [
            'first_',
            'second_',
            'third_'
        ];

        foreach ($keys as $key) {
            if ($this->imageRepository->has(
                $key . 'preview',
                self::PREVIEW_FILE_PATH . $id . '/' . $fileName)) {
                unlink(__DIR__ . '/../..' . self::PREVIEW_FILE_PATH . $id . '/' . $fileName);
                unlink(__DIR__ . '/../..' . $this->imageRepository->searchOriginalFile($id, $key . 'original'));
                $this->imageRepository->delete($images, $key . 'original');
                $this->imageRepository->delete($images, $key . 'preview');
            }
        }
    }


}
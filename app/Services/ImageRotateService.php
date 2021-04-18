<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserImages;
use App\Repositories\UserImageRepository;
use App\Repositories\UserRepository;

class ImageRotateService
{
    private UserImageRepository $imageRepository;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, UserImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->userRepository = $userRepository;
    }

    public function getUser(string $key, string $value): User
    {
        return $this->userRepository->searchUser($key, $value);
    }

    public function getInterestsImages(string $key, string $value): UserImages
    {
        return $this->imageRepository->searchUserImages($key, $value);
    }
}
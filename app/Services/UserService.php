<?php
namespace App\Services;

use App\Models\User;
use App\Models\UserImages;
use App\Repositories\UserImageRepository;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;
    private UserImageRepository $imageRepository;

    public function __construct(UserRepository $userRepository, UserImageRepository $imageRepository)
    {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
    }


    public function findUser(string $key, string $value): User
    {
        return $this->userRepository->searchUser($key, $value);
    }

    public function findImages(string $key, string $value): UserImages
    {
        return $this->imageRepository->searchUserImages($key, $value);
    }
}
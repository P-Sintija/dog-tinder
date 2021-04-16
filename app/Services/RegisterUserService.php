<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserImageRepository;
use App\Repositories\UserRepository;

class RegisterUserService
{
    private UserRepository $userRepository;
    private UserImageRepository $imageRepository;

    public function __construct(UserRepository $userRepository, UserImageRepository $imageRepository)
    {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
    }

    public function getRegistrationLink(User $user): string
    {
        return $_SERVER['HTTP_ORIGIN'] .
            '/auth?token=' .
            $user->getHash();
    }

    public function saveNewUser(User $user): void
    {
        $this->userRepository->save($user);
        $user = $this->userRepository->searchUser('name', $user->getName());
        $this->imageRepository->save($user);
    }

}
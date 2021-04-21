<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserImageRepository;
use App\Repositories\UserLikingRepository;
use App\Repositories\UserRepository;

class RegisterUserService
{
    private UserRepository $userRepository;
    private UserImageRepository $imageRepository;
    private UserLikingRepository $likingRepository;

    public function __construct(
        UserRepository $userRepository,
        UserImageRepository $imageRepository,
        UserLikingRepository $likingRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
        $this->likingRepository = $likingRepository;
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
        $this->likingRepository->save($user);
    }

}
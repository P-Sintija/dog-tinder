<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserCollection;
use App\Models\UserImages;
use App\Repositories\UserImageRepository;
use App\Repositories\UserRepository;


class LookService
{
    private UserRepository $userRepository;
    private UserImageRepository $imageRepository;

    public function __construct(UserRepository $userRepository, UserImageRepository $imageRepository)
    {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
    }

    public function getUser(string $key, string $value): User
    {
        return $this->userRepository->searchUser($key, $value);
    }

    public function getInterestUser(User $user): ?User
    {
        $interests = new UserCollection();
        foreach ($this->getInterestsUsers($user)->getUsers() as $interest) {
            if ($interest->getId() !== $user->getId()) {
                $interests->add($interest);
            }
        }
        return $interests->getUsers()[rand(0, count($interests->getUsers()) - 1)];
    }

    public function getInterestsImage(string $key, string $value): ?string
    {
        $images = [
            $this->getInterestsImages($key,$value)->getFirstImage(),
            $this->getInterestsImages($key,$value)->getSecondImage(),
            $this->getInterestsImages($key,$value)->getThirdImage()
        ];

        return $images[rand(0, count($images)-1)];

    }


    private function getInterestsImages(string $key, string $value): UserImages
    {
        return $this->imageRepository->searchUserImages($key,$value);
    }

    private function getInterestsUsers(User $user): UserCollection
    {
        if ($user->getLookingFor() === 'Both') {
            return $this->userRepository->getAllUsers();
        } else {
            return $this->userRepository->searchUsers('gender', $user->getLookingFor());
        }

    }



}
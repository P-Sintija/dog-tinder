<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserCollection;
use App\Models\UserImages;
use App\Repositories\UserImageRepository;
use App\Repositories\UserLikingRepository;
use App\Repositories\UserRepository;


class LookingForService
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

    public function getUser(string $key, string $value): User
    {
        return $this->userRepository->searchUser($key, $value);
    }

    public function getInterestUser(User $user): ?User
    {
        $interests = new UserCollection();
        foreach ($this->getInterestsUsers($user)->getUsers() as $interest) {
            if ($interest->getId() !== $user->getId()
                && !in_array((string)$interest->getId(),
                    explode(',', $this->likingRepository->search($user)->getLike()))
                && !in_array((string)$interest->getId(),
                    explode(',', $this->likingRepository->search($user)->getDislike()))
            ) {
                $interests->add($interest);
            }
        }

        if(count($interests->getUsers())>0){
            return $interests->getUsers()[rand(0, count($interests->getUsers()) - 1)];
        } else {
            return null;
        }
    }

    public function getInterestsImages(string $key, string $value): UserImages
    {
        return $this->imageRepository->searchUserImages($key, $value);
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
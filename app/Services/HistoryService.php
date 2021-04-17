<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserCollection;
use App\Repositories\UserImageRepository;
use App\Repositories\UserLikingRepository;
use App\Repositories\UserRepository;

class HistoryService
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

    public function searchLikes(User $user): UserCollection
    {
        $likedUsers = new UserCollection();
        $likes = $this->likingRepository->search($user);
        $likedIds = explode(',', $likes->getLike());
        foreach ($likedIds as $id) {
            if (is_numeric($id)) {
                $likedUsers->add($this->userRepository->searchUser('id', $id));
            }
        }
        return $likedUsers;
    }

    public function searchDislikes(User $user): UserCollection
    {
        $likedUsers = new UserCollection();
        $likes = $this->likingRepository->search($user);
        $likedIds = explode(',', $likes->getDislike());
        foreach ($likedIds as $id) {
            if (is_numeric($id)) {
                $likedUsers->add($this->userRepository->searchUser('id', $id));
            }
        }
        return $likedUsers;
    }

}
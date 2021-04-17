<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserLikingRepository;
use App\Repositories\UserRepository;

class LikingService
{
    private UserRepository $userRepository;
    private UserLikingRepository $likingRepository;

    public function __construct(UserRepository $userRepository, UserLikingRepository $likingRepository)
    {
        $this->userRepository = $userRepository;
        $this->likingRepository = $likingRepository;
    }

    public function getUser(string $key, string $value): User
    {
        return $this->userRepository->searchUser($key, $value);
    }

    public function saveLike(User $user, string $value): void
    {
        $this->likingRepository->edit($user, 'likes', $value);
    }

    public function saveDislike(User $user, string $value): void
    {
        $this->likingRepository->edit($user, 'dislikes', $value);
    }

}
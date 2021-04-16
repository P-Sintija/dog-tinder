<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class AuthorizationService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function userExists(string $username, string $password): bool
    {
        return $this->userRepository->has($username) && $this->validatePassword($username, $password);
    }

    public function findUser(string $key, string $value): User
    {
        return $this->userRepository->searchUser($key, $value);
    }

    public function loginUser(User $user): void
    {
        $this->userRepository->edit($user, 'loggedIn','1');
    }

    private function validatePassword(string $username, string $password): bool
    {
       return password_verify($password, $this->userRepository->searchUser('name', $username)->getHash());
    }

}
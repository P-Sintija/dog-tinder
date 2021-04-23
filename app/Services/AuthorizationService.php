<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Requests\AuthorizationRequest;

class AuthorizationService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findUser(string $key, string $value): User
    {
        return $this->userRepository->searchUser($key, $value);
    }

    public function userExists(AuthorizationRequest $request): bool
    {
        return $this->userRepository->has($request->getUsername()) &&
            $this->verifyPassword($request->getUsername(), $request->getPassword());
    }

    private function verifyPassword(string $username, string $password): bool
    {
        return password_verify($password, $this->userRepository->searchUser('name', $username)->getHash());
    }

}
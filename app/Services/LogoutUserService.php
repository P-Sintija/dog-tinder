<?php
namespace App\Services;

use App\Repositories\UserRepository;

class LogoutUserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function logoutUser(string $id): void
    {
        $user = $this->userRepository->searchUser('id', $id);
        $this->userRepository->edit($user, 'loggedIn', '0');
    }



}
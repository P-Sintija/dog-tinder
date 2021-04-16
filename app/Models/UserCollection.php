<?php

namespace App\Models;

class UserCollection
{
    private array $userList=[];

    public function add(User $user): void
    {
        $this->userList[] = $user;
    }

    public function getUsers(): array
    {
        return $this->userList;
    }

}
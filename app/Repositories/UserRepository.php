<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserCollection;

interface UserRepository
{
    public function save(User $user): void;

    public function has(string $username): bool;

    public function searchUser(string $key, string $value): User;

    public function edit(User $user, string $key, string $value): void;

    public function searchUsers(string $key, string $value): UserCollection;

    public function getAllUsers(): UserCollection;
}
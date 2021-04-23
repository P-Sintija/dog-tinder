<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserLiking;

interface UserLikingRepository
{
    public function save(User $user): void;

    public function edit(User $user, string $key, string $value): void;

    public function search(User $user): UserLiking;
}
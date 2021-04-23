<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserImages;
use App\Requests\ImageRequest;

interface UserImageRepository
{
    public function save(User $user): void;

    public function searchUserImages(string $key, string $value): UserImages;

    public function edit(ImageRequest $path, string $file, ?string $key = null): void;

    public function has(string $key, string $value): bool;

    public function searchOriginalFile(string $id, string $key): string;

    public function delete(UserImages $images, $key): void;

}
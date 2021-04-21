<?php

namespace App\Repositories;

use App\Requests\ImageRequest;
use App\Models\User;
use App\Models\UserImages;
use Medoo\Medoo;

class MySQLImageRepository implements UserImageRepository
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'codelex',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
        ]);
    }

    public function save(User $user): void
    {
        $this->database->insert('images', [
            'id' => $user->getId(),
        ]);
    }

    public function searchUserImages(string $key, string $value): UserImages
    {
        $images = $this->database->select('images', '*', [$key => $value])[0];
        $firstImage = explode('/', $images['first_preview']);
        $secondImage = explode('/', $images['second_preview']);
        $thirdImage = explode('/', $images['third_preview']);
        return new UserImages(
            $images['id'],
            end($firstImage),
            end($secondImage),
            end($thirdImage)
        );
    }

    public function edit(ImageRequest $path, string $file, ?string $key = null): void
    {
        $where = ['id' => $path->getId()];
        $this->database->update('images', [
            $path->getKey().$key => $file
        ], $where);
    }


}
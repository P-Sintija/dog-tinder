<?php

namespace App\Repositories;

use App\Models\ImagePaths;
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
        return new UserImages(
            $images['id'],
            $images['first'],
            $images['second'],
            $images['third']
        );
    }

    public function edit(ImagePaths $path, string $file): void
    {
        $where = ['id' => $path->getId()];
        $this->database->update('images', [
            $path->getKey() => $file
        ], $where);
    }


}
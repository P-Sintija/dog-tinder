<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserLiking;
use Medoo\Medoo;

class MySQLLikingRepository implements UserLikingRepository
{
    private Medoo $database;
    const TABLE_NAME = 'likes_dislikes';

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
        $this->database->insert(self::TABLE_NAME, [
            'id' => $user->getId(),
        ]);
    }

    public function edit(User $user, string $key, string $value): void
    {
        $where = [
            'id' => $user->getId()];

        if ($this->database->select(self::TABLE_NAME, $key, $where)[0] !== null) {
            $newValue = $this->database->select(self::TABLE_NAME, $key, $where)[0] . ',' . $value;
        } else {
            $newValue = $value;
        }

        $this->database->update(self::TABLE_NAME, [
            $key => $newValue
        ], $where);
    }

    public function search(User $user): UserLiking
    {
        $data = $this->database->select(self::TABLE_NAME, '*', ['id' => $user->getId()])[0];
        return new UserLiking(
            $data['id'],
            $data['likes'],
            $data['dislikes']
        );
    }

}
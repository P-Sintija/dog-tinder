<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserCollection;
use Medoo\Medoo;

class MySQLUserRepository implements UserRepository
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
        $this->database->insert('users', [
            'name' => $user->getName(),
            'hash' => $user->getHash(),
            'gender' => $user->getGender(),
            'lookingFor' => $user->getLookingFor(),
            'personality' => $user->getPersonality(),
        ]);
    }

    public function has(string $username): bool
    {
        $where = ['name' => $username];
        return $this->database->has('users', $where);
    }

    public function searchUser(string $key, string $value): User
    {
      $user = $this->database->select('users','*',[$key => $value])[0];
        return new User(
            $user['name'],
            $user['hash'],
            $user['personality'],
            $user['gender'],
            $user['lookingFor'],
            $user['id']
        );
    }

    public function edit(User $user, string $key, string $value): void
    {
        $where = [
            'id' => $user->getId()];

        $this->database->update('users', [
            $key => $value
        ], $where);
    }

    public function searchUsers(string $key, string $value): UserCollection
    {
        $searched = new UserCollection();

        $data = $this->database->select('users', '*', [$key => $value]);
        foreach ($data as $user) {
            $searched->add(
                new User(
                    $user['name'],
                    $user['hash'],
                    $user['personality'],
                    $user['gender'],
                    $user['lookingFor'],
                    $user['id']
                ));
        }
        return $searched;
    }

    public function getAllUsers(): UserCollection
    {
        $searched = new UserCollection();

        $data = $this->database->select('users', '*');
        foreach ($data as $user) {
            $searched->add(
                new User(
                    $user['name'],
                    $user['hash'],
                    $user['personality'],
                    $user['gender'],
                    $user['lookingFor'],
                    $user['id']
                ));
        }
        return $searched;
    }


}
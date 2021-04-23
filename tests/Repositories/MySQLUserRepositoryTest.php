<?php

namespace Tests\Repositories;

use App\Models\User;
use App\Models\UserCollection;
use App\Repositories\MySQLUserRepository;
use PHPUnit\Framework\TestCase;

class MySQLUserRepositoryTest extends TestCase
{
    public function testSearchUser(): void
    {
        $database = new MySQLUserRepository();
        $this->assertInstanceOf(User::class, $database->searchUser('id', '1'));
    }

    public function testSearchUsers(): void
    {
        $database = new MySQLUserRepository();
        $this->assertInstanceOf(UserCollection::class, $database->searchUsers('id', '1'));
    }

    public function testGetAll(): void
    {
        $database = new MySQLUserRepository();
        $this->assertInstanceOf(UserCollection::class, $database->getAllUsers());
    }
}
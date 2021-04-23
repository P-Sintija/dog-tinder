<?php
namespace Tests\Repositories;

use App\Models\User;
use App\Models\UserLiking;
use App\Repositories\MySQLLikingRepository;
use PHPUnit\Framework\TestCase;

class MySQLLikingRepositoryTest extends TestCase
{
    public function testSearch(): void
    {
        $database = new MySQLLikingRepository();
        $user = new User('Lilly','12345','lovely','Female','Male',1);
        $this->assertInstanceOf(UserLiking::class, $database->search($user));
    }
}
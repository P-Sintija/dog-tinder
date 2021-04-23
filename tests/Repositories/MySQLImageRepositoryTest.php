<?php
namespace Tests\Repositories;

use App\Models\UserImages;
use App\Repositories\MySQLImageRepository;
use PHPUnit\Framework\TestCase;

class MySQLImageRepositoryTest extends TestCase
{
    public function testImagesSearch(): void
    {
        $database = new MySQLImageRepository();
        $this->assertInstanceOf(UserImages::class, $database->searchUserImages('id', '1'));
    }
}
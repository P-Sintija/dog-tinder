<?php

namespace Tests\User;

use App\Models\UserImages;
use PHPUnit\Framework\TestCase;

class UserImagesTest extends TestCase
{
    public function testExistingImage(): void
    {
        $images = new UserImages(1, 'first image', null, 'third image');
        $this->assertIsString($images->getFirstImage());
        $this->assertEquals('first image', $images->getFirstImage());
        $this->assertIsString($images->getThirdImage());
        $this->assertEquals('third image', $images->getThirdImage());
    }

    public function testEmptyImage(): void
    {
        $images = new UserImages(1, 'first image', null, 'third image');
        $this->assertTrue(null === $images->getSecondImage());
    }
}
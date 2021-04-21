<?php

namespace Tests\User;

use App\Models\UserLiking;
use PHPUnit\Framework\TestCase;

class UserLikingTest extends TestCase
{
    public function testId(): void
    {
        $likes = new UserLiking(1);
        $this->assertIsInt($likes->getId());
        $this->assertEquals(1, $likes->getId());
    }

    public function testLikes(): void
    {
        $userLikes = new UserLiking(1, '1,2,3');
        $this->assertIsString($userLikes->getLike());
        $likes = explode(',', $userLikes->getLike());

        foreach ($likes as $like) {
            $this->assertIsNumeric($like);
        }
    }

    public function testDislikes(): void
    {
        $userDislikes = new UserLiking(1, null, '6,7,8');
        $this->assertIsString($userDislikes->getDislike());
        $dislikes = explode(',', $userDislikes->getDislike());

        foreach ($dislikes as $dislike) {
            $this->assertIsNumeric($dislike);
        }
    }
}
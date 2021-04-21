<?php

namespace Tests\User;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testName(): void
    {
        $user = new User('Lilly', '12345678', 'lovely', 'Male', 'Both');
        $this->assertIsString($user->getName());
        $this->assertEquals('Lilly', $user->getName());
    }

    public function testPassword(): void
    {
        $password = '12345678';
        $user = new User(
            'Lilly',
            password_hash($password, PASSWORD_BCRYPT),
            'lovely',
            'Male',
            'Both');

        $this->assertEquals(60, strlen($user->getHash()));
        $this->assertTrue(password_verify($password, $user->getHash()));
    }

    public function testPersonality(): void
    {
        $user = new User('Lilly', '12345678', 'lovely', 'Male', 'Both');
        $this->assertIsString($user->getPersonality());
        $this->assertEquals('lovely', $user->getPersonality());
    }

    public function testGender(): void
    {
        $user = new User('Lilly', '12345678', 'lovely', 'Male', 'Both');
        $this->assertIsString($user->getGender());
        $this->assertEquals('Male', $user->getGender());
    }

    public function testLookingFor(): void
    {
        $user = new User('Lilly', '12345678', 'lovely', 'Male', 'Both');
        $this->assertIsString($user->getLookingFor());
        $this->assertEquals('Both', $user->getLookingFor());
    }
}
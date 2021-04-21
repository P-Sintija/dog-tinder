<?php

namespace Tests\Requests;

use App\Requests\SubmissionRequest;
use PHPUnit\Framework\TestCase;

class SubmissionRequestTest extends TestCase
{
    public function testName(): void
    {
        $user = new SubmissionRequest('Lilly', '12345678', 'lovely');
        $this->assertIsString($user->getName());
        $this->assertEquals('Lilly', $user->getName());
    }

    public function testPassword(): void
    {
        $user = new SubmissionRequest('Lilly', '12345678', 'lovely');
        $this->assertIsString($user->getPassword());
        $this->assertEquals('12345678', $user->getPassword());
    }

    public function testPersonality(): void
    {
        $user = new SubmissionRequest('Lilly', '12345678', 'lovely');
        $this->assertIsString($user->getPersonality());
        $this->assertEquals('lovely', $user->getPersonality());
    }
}
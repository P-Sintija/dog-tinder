<?php

namespace Tests\Requests;

use App\Requests\AuthorizationRequest;
use PHPUnit\Framework\TestCase;

class AuthorizationRequestTest extends TestCase
{
    public function testName(): void
    {
        $request = new AuthorizationRequest('Lilly', 'lilly');
        $this->assertIsString($request->getUsername());
        $this->assertEquals('Lilly', $request->getUsername());
    }

    public function testPassword(): void
    {
        $request = new AuthorizationRequest('Lilly', 'lilly');
        $this->assertIsString($request->getPassword());
        $this->assertEquals('lilly', $request->getPassword());
        $this->assertTrue(strtolower($request->getUsername()) === $request->getPassword());
    }
}
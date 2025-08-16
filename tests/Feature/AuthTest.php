<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login(): void
    {
        $r = $this->postJson('/api/v1/auth/register', [
            'name'=>'Test','email'=>'t@example.com','password'=>'secret1234','password_confirmation'=>'secret1234'
        ])->assertOk();

        $this->postJson('/api/v1/auth/login', [
            'email'=>'t@example.com','password'=>'secret1234'
        ])->assertOk()->assertJsonPath('success', true);
    }
}

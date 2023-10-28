<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Teste para validar login se esta ok
     */
    public function test_auth_login_success(): void
    {
        $user = User::factory(1)->create()->first();

        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Teste para validar login se esta negando caso tente acessar com senha invalida
     */
    public function test_auth_login_fail(): void
    {
        $user = User::factory(1)->create()->first();

        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'password@1',
        ]);

        $response->assertUnauthorized();
    }
}

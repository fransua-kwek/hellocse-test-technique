<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Domain\Administrator\Infrastructure\Database\factories\AdministratorFactory;
use Src\Domain\Administrator\Infrastructure\Model\Administrator;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private Administrator $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = Administrator::create(AdministratorFactory::definition([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]));
    }

    public function test_can_retrieve_jwt_token_on_valid_credentials()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => $this->user->password,
        ]);

        $response->assertStatus(200);

        $this->assertNotEmpty($response->json('token'));
        $this->assertEquals('bearer', $response->json('token_type'));
        $this->assertEquals(config('jwt.ttl'), $response->json('expires_in'));
    }

    public function test_can_not_retrieve_jwt_token_on_invalid_credentials()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => '<EMAIL>',
            'password' => '',
        ]);

        $response->assertStatus(422);

        $response = $this->postJson('/api/auth/login', [
            'email' => '<EMAIL>',
            'password' => '<PASSWORD>',
        ]);

        $response->assertStatus(401);
    }

    public function test_can_refresh_jwt_token_with_valid_credentials()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => $this->user->password,
        ]);
        $token = $response->json('token');

        $response = $this->postJson('/api/auth/refresh', [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200);

        $this->assertNotEmpty($response->json('token'));
        $this->assertEquals('bearer', $response->json('token_type'));
        $this->assertEquals(config('jwt.ttl'), $response->json('expires_in'));
    }

    public function test_can_not_refresh_jwt_token_with_invalid_credentials()
    {
        $response = $this->postJson('/api/auth/refresh', [
            'Authorization' => "Bearer 1NC0RR3CT_T0K3N",
        ]);

        $response->assertStatus(401);
    }
}

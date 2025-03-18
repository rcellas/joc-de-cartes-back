<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function testUserCanLogin(){
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);
        $response->assertStatus(200)
                    ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    public function testUserCanNotLoginWithInvalidCredentials(){
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'invalid-password',
        ]);

        $response->assertStatus(401)
                    ->assertJson(['error' => 'Unauthorized']);
    }

    public function testRegister(){
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'se@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertStatus(201)
                    ->assertJsonStructure(['id', 'name', 'email', 'created_at', 'updated_at']);
    }

    public function testRegisterValidationError(){
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(400)
                 ->assertJson(['email' => ['The email field is required.']]);
    }
}

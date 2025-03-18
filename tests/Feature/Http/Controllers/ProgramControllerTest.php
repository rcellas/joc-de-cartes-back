<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProgramControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $program = Program::factory()->count(3)->create();
        $response = $this->getJson('/api/programs');
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function testShow()
    {
        $program = Program::factory()->create();
        $response = $this->getJson("/api/programs/{$program->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $program->name]);
    }

    public function testShowNotFound()
    {
        $admin = User::factory()->createOne(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->getJson('/api/programs/999999');
        $response->assertStatus(404);
        $response->assertJsonFragment(['message' => 'El programa no exiteix a les bases de dades']);
    }

    public function testStore()
    {
        $admin = User::factory()->createOne(['role' => 'admin']);
        $this->actingAs($admin);

        $data=[
            'name'=>'Test Program',
            'description'=>'Test Description',
            'year'=>2025,
            'season'=>4,
        ];

        $response = $this->postJson('/api/programs', $data);
        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => 'Test Program']);
    }

    public function testStoreValidationError()
    {
        $data = [
            'name' => 'Test Program',
            'description' => 'Test description',
            'season' => 4,
        ];

        $response = $this->postJson('/api/programs', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('year');
    }

    public function testUpdate()
    {
        $admin = User::factory()->createOne(['role' => 'admin']);
        $this->actingAs($admin);

        $program = Program::factory()->create();
        $data = ['name' => 'New Name'];
        $response = $this->putJson("/api/programs/{$program->id}", $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'New Name']);
    }

    public function testUpdateNotFound()
    {
        $admin = User::factory()->createOne(['role' => 'admin']);
        $this->actingAs($admin);

        $data = ['name' => 'New Name'];
        $response = $this->putJson('/api/programs/999999', $data);
        $response->assertStatus(404);
        $response->assertJsonFragment(['message' => 'El programa no exiteix a les bases de dades']);
    }

    public function testDestroy()
    {
        $admin = User::factory()->createOne(['role' => 'admin']);
        $this->actingAs($admin);

        $program = Program::factory()->create();
        $response = $this->deleteJson("/api/programs/{$program->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $program->id]);
    }

    public function testDestroyNotFound()
    {
        $admin = User::factory()->createOne(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->deleteJson('/api/programs/999999');
        $response->assertStatus(404);
        $response->assertJsonFragment(['message' => 'El programa no exiteix a les bases de dades']);
    }

}

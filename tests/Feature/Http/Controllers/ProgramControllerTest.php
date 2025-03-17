<?php

namespace Tests\Feature;

use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProgramControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $program = Program::factory()->count(3)->create();
        $response = $this->getJson('/programs');
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function testShow()
    {
        $program = Program::factory()->create();
        $response = $this->getJson("/programs/{$program->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $program->name]);
    }

    public function testShowNotFound()
    {
        $response = $this->getJson('/programs/999999');
        $response->assertStatus(404);
        $response->assertJsonFragment(['message' => 'El programa no exiteix a les bases de dades']);
    }

    public function testStore()
    {
        $data=[
            'name'=>'Test Program',
            'description'=>'Test Description',
            'year'=>2025,
            'season'=>4,
        ];

        $response = $this->postJson('/programs', $data);
        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => 'Test Program']);
    }

    public function testStoreValidationError()
    {
        $data = [
            'name' => 'Test Program',
            'description' => 'Test description',
            // 'year' no está presente, lo que debería causar un error de validación
            'season' => 4,
        ];

        $response = $this->postJson('/programs', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('year');
    }

    public function testUpdate()
    {
        $program = Program::factory()->create();
        $data = ['name' => 'New Name'];
        $response = $this->putJson("/programs/{$program->id}", $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'New Name']);
    }

    public function testUpdateNotFound()
    {
        $data = ['name' => 'New Name'];
        $response = $this->putJson('/programs/999999', $data);
        $response->assertStatus(404);
        $response->assertJsonFragment(['message' => 'El programa no exiteix a les bases de dades']);
    }

    public function testDestroy()
    {
        $program = Program::factory()->create();
        $response = $this->deleteJson("/programs/{$program->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $program->id]);
    }

}

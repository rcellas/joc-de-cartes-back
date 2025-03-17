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
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestaurantControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        Restaurant::factory()->count(2)->create();
        $response = $this->getJson('/restaurants');
        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    public function testShowFound()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->getJson("/restaurants/{$restaurant->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $restaurant->id]);
    }

    public function testShowNotFound()
    {
        $response = $this->getJson('/restaurants/999999');
        $response->assertStatus(404);
    }

    public function testStore()
    {
        $data = [
            'name' => 'Test Restaurant',
            'address' => '123 Main Street',
            'city' => 'Barcelona',
            'province' => 'Cataluña',
            'postal_code' => '08001',
        ];
        $response = $this
            ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
            ->postJson('/restaurants', $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Test Restaurant']);
    }


    public function testUpdate()
    {
        $restaurant = Restaurant::factory()->create();
        $data = ['name' => 'New Name'];
        $response = $this->putJson("/restaurants/{$restaurant->id}", $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'New Name']);
    }
    public function testDestroy()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this
            ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
            ->deleteJson("/restaurants/{$restaurant->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Restaurant eliminat correctament']);
    }


}
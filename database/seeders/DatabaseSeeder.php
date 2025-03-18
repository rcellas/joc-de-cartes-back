<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Restaurant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);


        $restaurants = Restaurant::factory(10)->create();

        $programs= Program::factory(10)->create();

        // Asociar entre 1 y 5 restaurantes aleatorios a cada programa
        $programs->each(function ($program) use ($restaurants) {
            // Tomar entre 1 y 5 restaurantes aleatorios
            $randomRestaurants = $restaurants->random(rand(1, 5));

            // Asociar los restaurantes seleccionados al programa
            $program->restaurants()->attach($randomRestaurants->pluck('id')->toArray());
        });
    }
}

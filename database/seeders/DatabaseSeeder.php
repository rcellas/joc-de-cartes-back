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
            'name' => 'Admin que luego se eliminará',
            'email' => 'test2@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);


        $restaurants = Restaurant::factory(10)->create();

        $programs= Program::factory(10)->create();


        $programs->each(function ($program) use ($restaurants) {
            $randomRestaurants = $restaurants->random(rand(1, 5));
            $program->restaurants()->attach($randomRestaurants->pluck('id')->toArray());
        });
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\App>
 */
class AppFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $appName = fake()->unique()->company();
        return [
            'name' => $appName,
            'slug' => getUrl($appName),
            'description' => fake()->text(),
            'image' => fake()->imageUrl(),
            'admin_id' => User::all()->random()->id,
        ];
    }
}

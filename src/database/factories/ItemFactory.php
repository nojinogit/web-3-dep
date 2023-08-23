<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            return [
            'user_id' => 1,
            'name' => fake()->name(),
            'path' => 'storage/sample/ビール.jpg',
            'brand' => fake()->name(),
            'condition' => 'ok',
            'explanation' => 'ok',
            'price' => 10000,
            'created_at' => now(),
        ];
    }
}

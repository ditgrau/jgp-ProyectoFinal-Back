<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User_event>
 */
class User_eventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=> fake()->numberBetween($min = 3, $max = 13),
            'event_id'=> fake()->numberBetween($min = 1, $max = 30),
        ];
    }
}

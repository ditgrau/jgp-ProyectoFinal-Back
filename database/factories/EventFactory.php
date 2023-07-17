<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement($array = array ('Atzar','Mabel','Purpurina')),
            'start_date' => fake()->dateTimeThisYear($timezone = null),
            'end_date' => fake()->dateTimeThisYear($timezone = null),
            'location' => fake()->streetAddress(),
            'comment' =>fake()->text($maxNbChars = 600) 
        ];
    }
}

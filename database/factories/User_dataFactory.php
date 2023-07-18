<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User_data>
 */
class User_dataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'surname' => fake()->lastName() ,
            'contact_email'=> fake()->safeEmail(),
            'first_phone' => 6 . fake()->randomNumber(8, true),
            'second_phone' => 6 . fake()->randomNumber(8, true),
            'birth_date' => fake()->dateTimeBetween($startDate = '1998-01-01', $endDate = '2017-01-01'),
            'dni' => fake()->randomNumber(8, true).strtoupper(fake()->randomLetter()),
        ];
    }
}

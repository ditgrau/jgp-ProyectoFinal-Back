<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=> fake()->numberBetween($min = 3, $max = 13) ,
            'difficulty'=> fake()->randomFloat($nbMaxDecimals = 3, $min = 7.050, $max = 20.000),
            'artistic'=> fake()->randomFloat($nbMaxDecimals = 3, $min = 3, $max = 7.500),
            'execution'=> fake()->randomFloat($nbMaxDecimals = 3, $min = 3, $max = 7.500),
            'total'=> fake()->randomFloat($nbMaxDecimals = 3, $min = 19.000, $max = 28.500),
            'ranking' => fake()->numberBetween($min = 1, $max = 35) 
        ];
    }
}

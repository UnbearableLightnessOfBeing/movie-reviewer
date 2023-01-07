<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movies>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ages = ['0+', '6+', '12+', '16+', '18+'];

        return [
            'title' => fake()->userName(), 
            'duration' => random_int(60, 180), 
            'description' => fake()->text(500), 
            'release_date' => fake()->date(), 
            'production' => fake()->company(), 
            'restriction' => $ages[random_int(0, 4)], 
        ];
    }
}

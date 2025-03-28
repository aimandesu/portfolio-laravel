<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'location' => $this->faker->city(),
            'level' => $this->faker->randomElement(['High School', 'Bachelor', 'Master', 'PhD']),
            'achievement' => $this->faker->sentence(),
        ];
    }
}

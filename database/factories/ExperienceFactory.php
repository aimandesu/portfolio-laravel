<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
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
            'title' => $this->faker->jobTitle(),
            'location' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use ProjectType;

class ProjectFactory extends Factory
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
            'type' => $this->faker->randomElement(ProjectType::cases())->value,
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
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
            'level' => $this->faker->numberBetween(1,5),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}

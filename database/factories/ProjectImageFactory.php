<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => \App\Models\Project::inRandomOrder()->first()->id,
            // \App\Models\Project::factory()->first()->project_id,
            'image' => $this->faker->imageUrl(),
        ];
    }
}

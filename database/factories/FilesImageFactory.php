<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FilesImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'files_id' => \App\Models\Files::factory(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}

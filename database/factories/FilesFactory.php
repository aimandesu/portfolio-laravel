<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FilesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'education_id' => \App\Models\Education::inRandomOrder()->first()->education_id,
            'description' => $this->faker->sentence(),
//            'image' => $this->faker->imageUrl(),
            'image_id' => \App\Models\FilesImage::factory(),
            'file' => $this->faker->filePath(),
        ];
    }
}

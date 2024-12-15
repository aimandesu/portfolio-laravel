<?php

namespace Database\Seeders;

use App\Models\FilesImage;
use Illuminate\Database\Seeder;

class FilesImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FilesImage::factory()
            ->count(20) // Generate 20 file images
            ->create();
    }
}

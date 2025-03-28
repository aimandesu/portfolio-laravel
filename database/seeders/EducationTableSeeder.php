<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;

class EducationTableSeeder extends Seeder
{
    public function run()
    {
        Education::factory()->count(100)->create();
    }
}

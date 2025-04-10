<?php

namespace Database\Seeders;

use App\Models\Journey;
use Illuminate\Database\Seeder;

class JourneysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Journey::factory()->count(100)->create();
    }
}

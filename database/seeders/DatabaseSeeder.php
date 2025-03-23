<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            EducationTableSeeder::class,
            FilesTableSeeder::class,
            ExperienceTableSeeder::class,
            ProjectsTableSeeder::class,
            SkillsTableSeeder::class,
            ProjectImageSeeder::class,
        ]);
    }

}

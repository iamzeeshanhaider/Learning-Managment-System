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
        $this->call(SettingsTableSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(RoleAndPermissionSeeder::class);

        $this->call(BatchSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(CourseMasterSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(LessonFolderSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);

        $this->call(SliderSeeder::class);
        $this->call(EventSeeder::class);

        // $this->call(AddSignatoryToSettngsSeeder::class);

    }
}





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
        $this->call(SettingsTableSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(RoleAndPermissionSeeder::class);

        $this->call(BatchSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(CourseMasterSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(LessonFolderSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);

        $this->call(SliderSeeder::class);
        $this->call(EventSeeder::class);

        // $this->call(AddSignatoryToSettngsSeeder::class);

    }
}

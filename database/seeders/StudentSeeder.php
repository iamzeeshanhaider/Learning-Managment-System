<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);
        $student = User::factory()->createQuietly([
            'email' => 'student@guardian.uk',
            'slug' => $faker->slug,
        ])->assignRole('Student');
        $student->assignRole('Student');

        User::factory()->createQuietly(['slug' => $faker->slug . 1,])->assignRole('Student');
        User::factory()->createQuietly(['slug' => $faker->slug . 2,])->assignRole('Student');
        User::factory()->createQuietly(['slug' => $faker->slug . 3,])->assignRole('Student');
        User::factory()->createQuietly(['slug' => $faker->slug . 4,])->assignRole('Student');
        User::factory()->createQuietly(['slug' => $faker->slug . 5,])->assignRole('Student');
        User::factory()->createQuietly(['slug' => $faker->slug . 6,])->assignRole('Student');
    }
}






namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);
        $student = User::factory()->createQuietly([
            'email' => 'student@guardian.uk',
            'slug' => $faker->slug,
        ])->assignRole('Student');
        $student->assignRole('Student');

        User::factory()->createQuietly(['slug' => $faker->slug . 1,])->assignRole('Student');
        User::factory()->createQuietly(['slug' => $faker->slug . 2,])->assignRole('Student');
        User::factory()->createQuietly(['slug' => $faker->slug . 3,])->assignRole('Student');
        User::factory()->createQuietly(['slug' => $faker->slug . 4,])->assignRole('Student');
        User::factory()->createQuietly(['slug' => $faker->slug . 5,])->assignRole('Student');
        User::factory()->createQuietly(['slug' => $faker->slug . 6,])->assignRole('Student');
    }
}

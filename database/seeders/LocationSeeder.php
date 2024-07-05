<?php

namespace Database\Seeders;

use App\Enums\GeneralStatus;
use App\Models\Location;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        Location::factory()->create([
            'name' => 'Online',
            'description' => '',
            'status' => GeneralStatus::Enabled,
            'seat_capacity' => '0',
        ]);
        Location::factory()->create([
            'name' => 'Physical',
            'description' => '',
            'status' => GeneralStatus::Enabled,
            'seat_capacity' => $faker->numberBetween(1, 500),
        ]);
    }
}



namespace Database\Seeders;

use App\Enums\GeneralStatus;
use App\Models\Location;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        Location::factory()->create([
            'name' => 'Online',
            'description' => '',
            'status' => GeneralStatus::Enabled,
            'seat_capacity' => '0',
        ]);
        Location::factory()->create([
            'name' => 'Physical',
            'description' => '',
            'status' => GeneralStatus::Enabled,
            'seat_capacity' => $faker->numberBetween(1, 500),
        ]);
    }
}

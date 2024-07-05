<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::factory()->count(2)->create();
    }
}



namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvent;
use Illuminate\Database\Seeder;


class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::factory()->count(2)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::factory()->createQuietly([
            'email' => 'admin@guardian.uk',
            'slug' => \Str::slug('student@guardian.uk'),
        ]);
        $admin->assignRole('Admin');
    }
}





namespace Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { {
            $admin = User::factory()->createQuietly([
                'email' => 'admin@guardian.uk',
                'slug' => \Str::slug('student@guardian.uk'),
            ]);
            $admin->assignRole('Admin');
        }
    }
}


namespace Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::factory()->createQuietly([
            'email' => 'admin@guardian.uk',
            'slug' => \Str::slug('student@guardian.uk'),
        ]);
        $admin->assignRole('Admin');
    }
}

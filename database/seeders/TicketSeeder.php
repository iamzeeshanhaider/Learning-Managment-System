<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ticket::factory()
            ->count(5)
            ->hasParents(1)
            ->create();
    }
}





namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *  @return void
     */
    public function run()
    {
        Ticket::factory()
            ->count(5)
            ->hasParent(1)
            ->create();
    }
}



namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithModelEvents;
use Illuminate\Database\Seeders;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ticket::factory()
            ->count(5)
            ->hasParent(1)
            ->create();
    }
}

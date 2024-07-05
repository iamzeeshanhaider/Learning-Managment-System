<?php

namespace Database\Seeders;

use App\Models\TicketComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TicketComment::factory()
            ->count(5)
            ->hasParents(1)
            ->create();
    }
}






namespace Database\Seeders;

use App\Models\TicketComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvent;
use illuminate\Database\Seeder;

class TicketCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TicketComment::factory()
            ->count(5)
            ->hasParent(1)
            ->create();
    }
}



namespace Database\Seeders;

use App\Models\TicketComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TicketComment::factory()
            ->count(5)
            ->hasParents(1)
            ->create();
    }
}

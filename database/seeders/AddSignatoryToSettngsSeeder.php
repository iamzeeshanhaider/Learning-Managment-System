<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddSignatoryToSettngsSeeder extends Seeder
{
    /**
     * The settings to add.
     */
    protected $settings = [
        [
            'key'         => 'signatory',
            'name'        => 'Signatory',
            'description' => 'Signatory for Certificate',
            'value'       => 'Guardians Training',
            'field'       => '{"name":"signatory","label":"Signatory","type":"text"}',
            'active'      => 1,
        ],
    ];

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $index => $setting) {
            // dd($setting);
            $result = DB::table('settings')->insert($setting);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        $this->command->info('Inserted ' . count($this->settings) . ' records.');
    }
}





namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddSignatoryToSettngsSeeder extends Seeder
{

    /**
     * The settings to add.
     */
    protected $settings = [
        [
            'key'         => 'signatory',
            'name'        => 'Signatory',
            'description' => 'Signatory for Certificate',
            'value'       => 'Guardians Training',
            'field'       => '{"name":"signatory","label":"Signatory","type":"text"}',
            'active'      => 1,
        ],
    ];

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $index => $setting) {
            // dd($setting);
            $result = DB::table('settings')->insert($setting);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        $this->command->info('Inserted ' . count($this->settings) . ' records.');
    }
}

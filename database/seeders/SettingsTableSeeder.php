<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * The settings to add.
     */
    protected $settings = [
        [
            'key'         => 'name',
            'name'        => 'Name',
            'description' => 'Name used for platform',
            'value'       => 'LMS',
            'field'       => '{"name":"name","label":"Name","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'phone',
            'name'        => 'Phone',
            'description' => 'Phone used for platform.',
            'value'       => '+62 081280348080',
            'field'       => '{"name":"phone","label":"Phone","type":"number"}',
            'active'      => 1,
        ],

        [
            'key'         => 'contact_email',
            'name'        => 'Contact form email address',
            'description' => 'The email address that all emails from the contact form will go to.',
            'value'       => 'jambasangsang@gmail.com',
            'field'       => '{"name":"contact_email","label":"Email","type":"email"}',
            'active'      => 1,
        ],
        [
            'key'         => 'address',
            'name'        => 'Contact form email address',
            'description' => 'The address used for platform.',
            'value'       => 'Latrikunda Sabiji Bailo Kanteh street, Banjul-The Gambia',
            'field'       => '{"name":"address","label":"Address","type":"text"}',
            'active'      => 1,
        ],

        [
            'key'         => 'description',
            'name'        => 'Description',
            'description' => 'Description used for platform',
            'value'       => 'LMS',
            'field'       => '{"name":"description","label":"Description","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'logo',
            'name'        => 'Logo',
            'description' => 'Logo used for platform',
            'value'       => 'https://www.guardians-training.co.uk/wp-content/uploads/2023/04/Guardians_Training_Logo-1.png',
            'field'       => '{"name":"logo","label":"Logo","type":"file"}',
            'active'      => 1,
        ],
        [
            'key'         => 'currency',
            'name'        => 'Currency',
            'description' => 'Currency used for platform',
            'value'       => 'British Pound (GBP)',
            'field'       => '{"name":"currency","label":"Currency","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'symbol',
            'name'        => 'Symbol',
            'description' => 'Symbol used for platform',
            'value'       => '£',
            'field'       => '{"name":"symbol","label":"Symbol","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'decimal',
            'name'        => 'Decimal',
            'description' => 'Decimal used for platform',
            'value'       => '£',
            'field'       => '{"name":"decimal","label":"Decimal","type":"number"}',
            'active'      => 1,
        ],

        [
            'key'         => 'language',
            'name'        => 'Language',
            'description' => 'Language used for platform',
            'value'       => 'english',
            'field'       => '{"name":"language","label":"Language","type":"text"}',
            'active'      => 1,
        ],

        [
            'key'         => 'paypal_key',
            'name'        => 'Paypal Key',
            'description' => 'Paypal key for the platform',
            'value'       => '',
            'field'       => '{"name":"paypal_key","label":"Paypal Key","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'paypal_secret',
            'name'        => 'Paypal Secret',
            'description' => 'Paypal Secret for the platform',
            'value'       => '',
            'field'       => '{"name":"paypal_secret","label":"Paypal Secret","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'stripe_key',
            'name'        => 'Stripe Key',
            'description' => 'Stripe key for the platform',
            'value'       => '',
            'field'       => '{"name":"stripe_key","label":"Stripe Key","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'stripe_secret',
            'name'        => 'Stripe Secret',
            'description' => 'Stripe Secret for the platform',
            'value'       => '',
            'field'       => '{"name":"stripe_secret","label":"Stripe Secret","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'facebook',
            'name'        => 'Facebook URl',
            'description' => 'Link to Facebook page',
            'value'       => 'https://facebook.com',
            'field'       => '{"name":"facebook","label":"Facebook URl","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'twitter',
            'name'        => 'Twitter URl',
            'description' => 'Link to Twitter page',
            'value'       => 'https://twitter.com',
            'field'       => '{"name":"twitter","label":"Twitter URl","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'instagram',
            'name'        => 'Instagram URl',
            'description' => 'Link to Instagram page',
            'value'       => 'https://instagram.com',
            'field'       => '{"name":"instagram","label":"Instagram URl","type":"text"}',
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

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * The settings to add.
     */
    protected $settings = [
        [
            'key'         => 'name',
            'name'        => 'Name',
            'description' => 'Name used for platform',
            'value'       => 'LMS',
            'field'       => '{"name":"name","label":"Name","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'phone',
            'name'        => 'Phone',
            'description' => 'Phone used for platform.',
            'value'       => '+62 081280348080',
            'field'       => '{"name":"phone","label":"Phone","type":"number"}',
            'active'      => 1,
        ],

        [
            'key'         => 'contact_email',
            'name'        => 'Contact form email address',
            'description' => 'The email address that all emails from the contact form will go to.',
            'value'       => 'jambasangsang@gmail.com',
            'field'       => '{"name":"contact_email","label":"Email","type":"email"}',
            'active'      => 1,
        ],
        [
            'key'         => 'address',
            'name'        => 'Contact form email address',
            'description' => 'The address used for platform.',
            'value'       => 'Latrikunda Sabiji Bailo Kanteh street, Banjul-The Gambia',
            'field'       => '{"name":"address","label":"Address","type":"text"}',
            'active'      => 1,
        ],

        [
            'key'         => 'description',
            'name'        => 'Description',
            'description' => 'Description used for platform',
            'value'       => 'LMS',
            'field'       => '{"name":"description","label":"Description","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'logo',
            'name'        => 'Logo',
            'description' => 'Logo used for platform',
            'value'       => 'https://www.guardians-training.co.uk/wp-content/uploads/2023/04/Guardians_Training_Logo-1.png',
            'field'       => '{"name":"logo","label":"Logo","type":"file"}',
            'active'      => 1,
        ],
        [
            'key'         => 'currency',
            'name'        => 'Currency',
            'description' => 'Currency used for platform',
            'value'       => 'British Pound (GBP)',
            'field'       => '{"name":"currency","label":"Currency","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'symbol',
            'name'        => 'Symbol',
            'description' => 'Symbol used for platform',
            'value'       => '£',
            'field'       => '{"name":"symbol","label":"Symbol","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'decimal',
            'name'        => 'Decimal',
            'description' => 'Decimal used for platform',
            'value'       => '£',
            'field'       => '{"name":"decimal","label":"Decimal","type":"number"}',
            'active'      => 1,
        ],

        [
            'key'         => 'language',
            'name'        => 'Language',
            'description' => 'Language used for platform',
            'value'       => 'english',
            'field'       => '{"name":"language","label":"Language","type":"text"}',
            'active'      => 1,
        ],

        [
            'key'         => 'paypal_key',
            'name'        => 'Paypal Key',
            'description' => 'Paypal key for the platform',
            'value'       => '',
            'field'       => '{"name":"paypal_key","label":"Paypal Key","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'paypal_secret',
            'name'        => 'Paypal Secret',
            'description' => 'Paypal Secret for the platform',
            'value'       => '',
            'field'       => '{"name":"paypal_secret","label":"Paypal Secret","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'stripe_key',
            'name'        => 'Stripe Key',
            'description' => 'Stripe key for the platform',
            'value'       => '',
            'field'       => '{"name":"stripe_key","label":"Stripe Key","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'stripe_secret',
            'name'        => 'Stripe Secret',
            'description' => 'Stripe Secret for the platform',
            'value'       => '',
            'field'       => '{"name":"stripe_secret","label":"Stripe Secret","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'facebook',
            'name'        => 'Facebook URl',
            'description' => 'Link to Facebook page',
            'value'       => 'https://facebook.com',
            'field'       => '{"name":"facebook","label":"Facebook URl","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'twitter',
            'name'        => 'Twitter URl',
            'description' => 'Link to Twitter page',
            'value'       => 'https://twitter.com',
            'field'       => '{"name":"twitter","label":"Twitter URl","type":"text"}',
            'active'      => 1,
        ],
        [
            'key'         => 'instagram',
            'name'        => 'Instagram URl',
            'description' => 'Link to Instagram page',
            'value'       => 'https://instagram.com',
            'field'       => '{"name":"instagram","label":"Instagram URl","type":"text"}',
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

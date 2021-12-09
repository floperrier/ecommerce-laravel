<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_methods')->truncate();

        DB::table('shipping_methods')->insert([
            'name' => 'standard',
            'label' => 'Standard Shipping',
            'price' => 10
        ]);
        DB::table('shipping_methods')->insert([
            'name' => 'express',
            'label' => 'Express Shipping',
            'price' => 15
        ]);
    }
}

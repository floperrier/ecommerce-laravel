<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('categories')->truncate();

        DB::table('categories')->insert([
            'name' => 'Category 1'
        ]);
        DB::table('categories')->insert([
            'name' => 'Category 2'
        ]);
        DB::table('categories')->insert([
            'name' => 'Category 3'
        ]);
        DB::table('categories')->insert([
            'name' => 'Category 4'
        ]);
    }
}

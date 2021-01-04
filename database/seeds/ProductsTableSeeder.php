<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'XXX',
            'download_speed' => '125',
            'upload_speed' => '80',
            'is_fibre' => 1
         
        ]);
        DB::table('products')->insert([
            'name' => 'YYY',
            'download_speed' => '80',
            'upload_speed' => '80',
            'is_fibre' => 1
         
        ]);
        DB::table('products')->insert([
            'name' => 'ZZZ',
            'download_speed' => '80',
            'upload_speed' => '80',
            'is_fibre' => 0
         
        ]);
    }
}

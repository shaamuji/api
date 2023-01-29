<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // dummy products include and do not include vat
        $products = [
            [
                'title' => 'product 10 icluded',
                'price' => 10,
            ], [
                'title' => 'product 5',
                'price' => 5,
            ], [
                'title' => 'product 20 include vat',
                'price' => 20,
            ]
        ];
        foreach ($products as $product) {

            DB::table('products')->insert([
                'title' => $product["title"],
                'price' => $product["price"],
            ]);
        }


    }
}

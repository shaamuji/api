<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('order_states')->insert([
            [ 'state_title' => 'created'],
            [ 'state_title' => 'in shipping'],
            [ 'state_title' => 'received']
         ]);
    }
}

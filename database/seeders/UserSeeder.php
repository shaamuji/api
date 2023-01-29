<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // dummy users for merchent and client
        $users=[[
            'name'=>'admin account',
            'email'=>'admin@store.com',
            'password'=>Hash::make('123456'),
            'role_id'=>1,
        ],[
            'name'=>'client account',
            'email'=>'client@store.com',
            'password'=>Hash::make('123456'),
            'role_id'=>2,
        ]];
        foreach($users as $user){

            DB::table('users')->insert([
                'name' => $user['name'],
                'email' =>  $user['email'],
                'password' => $user['password'],
                'role_id'=> $user['role_id']
            ]);
        }
        


    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Kawsar',
            'role_id'=>'1',
            'username'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('password'),
            'image'=>'',
            'about'=>'I am admin'
        ]);

        DB::table('users')->insert([
            'name'=>'Kalam',
            'role_id'=>'2',
            'username'=>'author',
            'email'=>'author@gmail.com',
            'password'=>Hash::make('password'),
            'image'=>'',
            'about'=>'I am author man!'
        ]);
    }
}

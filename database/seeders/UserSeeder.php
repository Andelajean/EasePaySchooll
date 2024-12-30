<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //ADMIN
        DB::table('users')->insert([
            'name' => 'omd34',
            'email' =>'danielotomo34@gmail.com',
            'password' => Hash::make('123456'),
            'role'=>1
        ]);

         //APPRENANT
         DB::table('users')->insert([
            'name' => 'apprenant1',
            'email' =>'apprenant1@gmail.com',
            'password' => Hash::make('123456'),
            'role'=>3
        ]);

    }
}

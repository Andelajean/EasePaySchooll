<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         //role administrateur
         DB::table('roles')->insert([
            'id' => 1,
            'designation' =>'administrateur',
            'code' => 'admin',
            
        ]);

         //role ecole
         DB::table('roles')->insert([
            'id' => 2,
            'designation' =>'ecole',
            'code' => 'ecole',
            
        ]);

        //role etudiant ou apprenant
        DB::table('roles')->insert([
            'id' => 3,
            'designation' =>'apprenant',
            'code' => 'apprenant',
            
        ]);

       
    }
}

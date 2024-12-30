<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BanqueSeeder extends Seeder
{
    public function run()
    {
        $banques = [
            [
                'nom' => 'Afriland First Bank',
                'role' => Hash::make('afriland33458'),
                'codesecret1' => '01234567891',
                'email' => 'contact@afrilandfirstbank.com'
            ],
            [
                'nom' => 'Commercial Bank',
                'role' => Hash::make('commercial2004'),
                'codesecret1' => '01234567891',
                'email' => 'contact@commercialbank.com'
            ],
            [
                'nom' => 'UBA',
                'role' => Hash::make('ubabank3306'),
                'codesecret1' => '01234567891',
                'email' => 'contact@ubabank.com'
            ],
            [
                'nom' => 'SCB',
                'role' => Hash::make('scbbank44015'),
                'codesecret1' => '01234567891',
                'email' => 'contact@scbbank.com'
            ],
            [
                'nom' => 'SGBC',
                'role' => Hash::make('sgbcafrik2004'),
                'codesecret1' => '01234567891',
                'email' => 'contact@sgbc.com'
            ],
            [
                'nom' => 'EcoBank',
                'role' => Hash::make('panafricain2031'),
                'codesecret1' => '01234567891',
                'email' => 'contact@ecobank.com'
            ],
            [
                'nom' => 'BANGE BANK',
                'role' => Hash::make('bange2000'),
                'codesecret1' => '123456789',
                'email' => 'contact@bangebank.com'
            ],
            [
                'nom' => 'BGFI Bank',
                'role' => Hash::make('bgfi02004'),
                'codesecret1' => '123456789',
                'email' => 'contact@bgfibank.com'
            ],
            [
                'nom' => 'CCA Bank',
                'role' => Hash::make('cca03306'),
                'codesecret1' => '123456789',
                'email' => 'contact@ccabank.com'
            ],
            [
                'nom' => 'Express Union',
                'role' => Hash::make('union1044015'),
                'codesecret1' => '123456789',
                'email' => 'contact@expressunion.com'
            ],
            [
                'nom' => 'BICEC',
                'role' => Hash::make('bicec1022004'),
                'codesecret1' => '01234567891',
                'email' => 'contact@bicec.com'
            ],
            [
                'nom' => 'Vision Finance',
                'role' => Hash::make('finance025012'),
                'codesecret1' => '123456789',
                'email' => 'contact@visionfinance.com'
            ],
            [
                'nom' => 'Atlantik Bank',
                'role' => Hash::make('atlantik125012'),
                'codesecret1' => '123456789',
                'email' => 'contact@atlantikbank.com'
            ]
        ];

        $i=0;
        foreach ($banques as $banque) {
            $i++;
            DB::table('banques')->insert([
                'nom' => $banque['nom'],
                'role' => $banque['role'],
                'prenom' => '', 
                'email' => $banque['email'], 
                'telephone' =>''.$i,
                'bank' => $banque['nom'],
                'pwd' => $banque['codesecret1'], 
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}

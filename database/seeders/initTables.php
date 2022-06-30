<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class initTables extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('access_levels')->insert([
            'nivel' => 'administrador'
        ]);

        DB::table('users')->insert([
            [
                'name' => 'TI',
                'email' => 'ti@ceqnep.com.br',
                'password' => Hash::make('Ler@1439!@#'),
                'access_level' => 1
            ],
            [
                'name' => 'QUALIDADE',
                'email' => 'qualidade@ceqnep.com.br',
                'password' => Hash::make('Qualidade@2022'),
                'access_level' => 1
            ]
        ]);

        DB::table('tarefa_periodos')->insert([
            [
                'periodo' => '1 week',
            ],
            [
                'periodo' => '1 month',
            ],
            [
                'periodo' => '3 month',
            ],
            [
                'periodo' => '6 month',
            ],
            [
                'periodo' => '1 year',
            ],
        ]);
    }
}

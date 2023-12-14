<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nombre' => 'adminAna',
            'apellido1' => 'Rodríguez',
            'apellido2' => 'Pérez',
            'email' => 'anarodpe8@gmail.com',
            'es_admin' => true,
            'validado' => true,
            'password' => Hash::make('Administradora.1'),
    ]);
    }
}

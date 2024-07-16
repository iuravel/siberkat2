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
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Robbi Nugraha',
            'username' => 'iuraveldev',
            'email' => 'iuraveldev@gmail.com',
            'phone' => fake()->e164PhoneNumber,
            'password' => hash::make('112233')],
            ['name' => 'Hardic Tadasky',
            'username' => 'hardictadasky',
            'email' => 'hardictadasky@gmail.com',
            'phone' => fake()->e164PhoneNumber,
            'password' => hash::make('112233')],

        ]);
    }
}

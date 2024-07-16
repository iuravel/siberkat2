<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKelaminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_kelamin')->insert([
            ['nama' => 'Laki-laki', 'singkatan'=> 'L'],
            ['nama' => 'Perempuan', 'singkatan'=> 'P'],
        ]);
    }
}

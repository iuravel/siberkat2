<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('golongan')->insert([
            ['nama' => 'I/a', 'uraian'=> 'Juru Muda', 'grup_id'=> 2],
            ['nama' => 'I/b', 'uraian'=> 'Juru Muda Tingkat I', 'grup_id'=> 2],
            ['nama' => 'I/c', 'uraian'=> 'Juru', 'grup_id'=> 2],
            ['nama' => 'I/d', 'uraian'=> 'Juru Tingkat I', 'grup_id'=> 2],
            ['nama' => 'II/a', 'uraian'=> 'Pengatur Muda', 'grup_id'=> 2],
            ['nama' => 'II/b', 'uraian'=> 'Pengatur Muda Tingkat I', 'grup_id'=> 2],
            ['nama' => 'II/c', 'uraian'=> 'Pengatur', 'grup_id'=> 2],
            ['nama' => 'II/d', 'uraian'=> 'Pengatur Tingkat I', 'grup_id'=> 2],
            ['nama' => 'III/a', 'uraian'=> 'Penata Muda', 'grup_id'=> 2],
            ['nama' => 'III/b', 'uraian'=> 'Penata Muda Tingkat I', 'grup_id'=> 2],
            ['nama' => 'III/c', 'uraian'=> 'Penata', 'grup_id'=> 2],
            ['nama' => 'III/d', 'uraian'=> 'Penata Tingkat I', 'grup_id'=> 2],
            ['nama' => 'IV/a', 'uraian'=> 'Pembina', 'grup_id'=> 2],
            ['nama' => 'IV/b', 'uraian'=> 'Pembina Tingkat I', 'grup_id'=> 2],
            ['nama' => 'IV/c', 'uraian'=> 'Pembina Muda', 'grup_id'=> 2],
            ['nama' => 'IV/d', 'uraian'=> 'Pembina Madya', 'grup_id'=> 2],
            ['nama' => 'IV/e', 'uraian'=> 'Pembina Utama', 'grup_id'=> 2],
        ]);
    }
}

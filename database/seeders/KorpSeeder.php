<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KorpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('korp')->insert([
            ['nama' => 'INF'],
            ['nama' => 'KAV'],
            ['nama' => 'ARH'],
            ['nama' => 'ARM'],
            ['nama' => 'CZI'],
            ['nama' => 'CPL'],
            ['nama' => 'CHB'],
            ['nama' => 'CBA'],
            ['nama' => 'CKM'],
            ['nama' => 'CAJ'],
            ['nama' => 'CKU'],
            ['nama' => 'CTP'],
            ['nama' => 'CPM'],
            ['nama' => 'CPN'],
            ['nama' => 'CHK'],
        ]);
    }
}








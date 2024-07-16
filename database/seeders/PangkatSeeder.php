<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pangkat')->insert([
            ['nama' => 'Prada','grup_id'=> 1],
            ['nama' => 'Pratu','grup_id'=> 1],
            ['nama' => 'Praka','grup_id'=> 1],
            ['nama' => 'Kopda','grup_id'=> 1],
            ['nama' => 'Koptu','grup_id'=> 1],
            ['nama' => 'Kopka','grup_id'=> 1],
            ['nama' => 'Serda','grup_id'=> 1],
            ['nama' => 'Sertu','grup_id'=> 1],
            ['nama' => 'Serka','grup_id'=> 1],
            ['nama' => 'Serma','grup_id'=> 1],
            ['nama' => 'Pelda','grup_id'=> 1],
            ['nama' => 'Peltu','grup_id'=> 1],
            ['nama' => 'Letda','grup_id'=> 1],
            ['nama' => 'Lettu','grup_id'=> 1],
            ['nama' => 'Kapten','grup_id'=> 1],
            ['nama' => 'Mayor','grup_id'=> 1],
            ['nama' => 'Letkol','grup_id'=> 1],
            ['nama' => 'Kolonel','grup_id'=> 1],
            ['nama' => 'Brigjen','grup_id'=> 1],
            ['nama' => 'Mayjen','grup_id'=> 1],
            ['nama' => 'Letjen','grup_id'=> 1],
            ['nama' => 'Jenderal','grup_id'=> 1],
        ]);
    }
}







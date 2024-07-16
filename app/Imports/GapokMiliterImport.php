<?php

namespace App\Imports;

use App\Models\GapokMiliter;
use App\Models\Pangkat;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GapokMiliterImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new GapokMiliter([
            //'pangkat_id'     => $row['pangkat'] ?? $row['pangkat_id'] ?? $row[0] ?? null,
            'pangkat_id' => self::getPangkatId($row['pangkat'] ?? $row['pkt'] ?? null),
            'masa_kerja' => $row['masa kerja'] ?? $row['masa kerja gaji'] ?? $row['mkg'] ?? null,
            'gaji' => $row['gaji pokok'] ?? $row['gaji_pokok'] ?? $row['gaji'] ?? null,
        ]);
    }
    public static function getPangkatId(string $pangkat){
        return Pangkat::where('nama', $pangkat)->first()->id;
    }
    public function batchSize(): int
    {
        return 100;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
    
}

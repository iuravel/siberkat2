<?php

namespace App\Imports;

use App\Models\GapokAsn;
use App\Models\Golongan;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GapokAsnImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new GapokAsn([
            'golongan_id' => self::getGolonganId($row['golongan'] ?? $row['gol'] ?? null),
            'masa_kerja' => $row['masa kerja'] ?? $row['masa kerja gaji'] ?? $row['mkg'] ?? null,
            'gaji' => $row['gaji pokok'] ?? $row['gaji_pokok'] ?? $row['gaji'] ?? null,
        ]);
    }
    public static function getGolonganId(string $golongan){
        return Golongan::where('nama', $golongan)->first()->id;
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

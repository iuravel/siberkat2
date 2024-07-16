<?php

namespace App\Imports;

use App\Models\GajiBerkalaAsn;
use App\Models\Golongan;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GajiBerkalaAsnImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new GajiBerkalaAsn([
            'nama' => $row['NAMA'] ?? null,
            'nip' => $row['NIP'] ?? null,
            'karpeg'=> $row['KARPEG'] ?? null,
            'jenis_kelamin_id'=> $row['JK'] ?? null,
            'tempat_lahir'=> $row['TMP LAHIR'] ?? null,
            'tanggal_lahir'=> $row['TGL LAHIR'] ?? null,
            'tmt_cpns'=> $row['TMT CPNS'] ?? null,
            'tmt_golongan'=> $row['TMT GOL'] ?? null,
            'jabatan'=> $row['JABATAN'] ?? null,
            'kesatuan'=> $row['KESATUAN'] ?? null,

            'golongan_lama_id'=> $row['GOL TERAKHIR'] ?? null,
            'skep_lama'=> $row['SKEP TERAKHIR'] ?? null,
            'tmt_skep_lama'=> $row['TMT SKEP'] ?? null,
            'tahun_mks_lama'=> $row['MKS (THN)'] ?? null,
            'bulan_mks_lama'=> $row['MKS (BLN)'] ?? null,
            'tahun_mkg_lama'=> $row['MKG (THN)'] ?? null,
            'bulan_mkg_lama'=> $row['MKG (BLN)'] ?? null,
            'gaji_pokok_lama'=> $row['GAJI POKOK'] ?? null,
            'tmt_kgb_lama'=> $row['TMT KGB TERAKHIR'] ?? null,
            'tmt_kgb_yad_lama'=> $row['TMT KGB YAD'] ?? null,

            'golongan_baru_id'=> $row['GOL BARU'] ?? null,
            'skep_baru'=> $row['SKEP TERAKHIR'] ?? null,
            'tmt_skep_baru'=> $row['TMT SKEP'] ?? null,
            'tahun_mks_baru'=> $row['MKS (THN)'] ?? null,
            'bulan_mks_baru'=> $row['MKS (BLN)'] ?? null,
            'tahun_mkg_baru'=> $row['MKG (THN)'] ?? null,
            'bulan_mkg_baru'=> $row['MKG (BLN)'] ?? null,
            'gaji_pokok_baru'=> $row['GAJI POKOK'] ?? null,
            'tmt_kgb_baru'=> $row['TMT KGB BARU'] ?? null,
            'tmt_kgb_yad_baru'=> $row['TMT KGB YAD'] ?? null,

            'keterangan'=> $row['KETERANGAN'] ?? null,
            'tanggal_terbit'=> $row['TANGGAL SURAT'] ?? null,

        ]);
    }
    public static function getGolonganId(string $golongan){
        return Golongan::where('nama', $golongan)->first()->id;
    }
    public function batchSize(): int
    {
        return 50;
    }
    public function chunkSize(): int
    {
        return 500;
    }
}

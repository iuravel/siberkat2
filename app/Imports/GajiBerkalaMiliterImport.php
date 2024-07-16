<?php

namespace App\Imports;

use App\Models\GajiBerkalaMiliter;
use App\Models\JenisKelamin;
use App\Models\Korp;
use App\Models\Pangkat;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GajiBerkalaMiliterImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new GajiBerkalaMiliter([
            'nama' => $row['nama'] ?? null,
            'nrp' => $row['nrp'] ?? null,
            'jenis_kelamin_id'=> self::getKelaminId($row['jk'])->id ?? null,
            'tanggal_lahir'=> self::excelToDate($row['tgl_lahir']) ?? null,
            'tmt_tni'=> self::excelToDate($row['tmt_tni']) ?? null,
            'tmt_pangkat'=> self::excelToDate($row['tmt_pkt']) ?? null,
            'korp_id'=> self::getKorpId($row['korp'])->id ?? null,
            'jabatan'=> $row['jabatan'] ?? null,
            'kesatuan'=> $row['kesatuan'] ?? null,
            'pangkat_lama_id'=> self::getPangkatId($row['pkt_terakhir'])->id ?? null,
            'tahun_mks_lama'=> $row['mks_terakhir_thn'] ?? null,
            'bulan_mks_lama'=> $row['mks_terakhir_bln'] ?? null,
            'tahun_mkg_lama'=> $row['mkg_terakhir_thn'] ?? null,
            'bulan_mkg_lama'=> $row['mkg_terakhir_bln'] ?? null,
            'gaji_pokok_lama'=> $row['gaji_pokok_terakhir'] ?? null,
            'tmt_kgb_lama'=> self::excelToDate($row['tmt_kgb_terakhir']) ?? null,
            'tmt_kgb_yad_lama'=> self::excelToDate($row['tmt_yad_terakhir']) ?? null,
            'pangkat_baru_id'=> self::getPangkatId($row['pkt_baru'])->id ?? null,
            'tahun_mks_baru'=> $row['mks_baru_thn'] ?? null,
            'bulan_mks_baru'=> $row['mks_baru_bln'] ?? null,
            'tahun_mkg_baru'=> $row['mkg_baru_thn'] ?? null,
            'bulan_mkg_baru'=> $row['mkg_baru_bln'] ?? null,
            'gaji_pokok_baru'=> $row['gaji_pokok_baru'] ?? null,
            'tmt_kgb_baru'=> self::excelToDate($row['tmt_kgb_baru']) ?? null,
            'tmt_kgb_yad_baru'=> self::excelToDate($row['tmt_yad_baru']) ?? null,
            'keterangan'=> $row['keterangan'] ?? null,
            'tanggal_terbit'=> self::excelToDate($row['tanggal_surat']) ?? null,
        ]);
    }
    public function excelToDate($data)
    {
        return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data));
    }
    public static function getPangkatId($data)
    {
        $array = explode(' ', $data);
        $first = Arr::first($array, function ($value, $key) {
            return strlen($value) > 1;
        }, $data);
        return Pangkat::where('nama', $first)->first();
    }
    public static function getKorpId($data)
    {
        return Korp::where('nama', $data)->first();
    }
    public static function getKelaminId($record)
    {
        return JenisKelamin::where('singkatan', $record)->first();
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

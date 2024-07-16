<?php

namespace App\Exports;

use App\Models\GajiBerkalaMiliter;
use App\Models\JenisKelamin;
use App\Models\Korp;
use Illuminate\Contracts\Support\Responsable;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GajiBerkalaMiliterExport implements FromQuery, Responsable, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;
    

    private $fileName = 'gaji-berkala-militer.xlsx';
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;
    
    public function query()
    {
        return GajiBerkalaMiliter::query();
    }
    
    public function headings(): array
    {
        return [
            'nama','nrp','jk','tgl_lahir','tmt_tni','tmt_pkt','korp','jabatan','kesatuan',
            'pkt_terakhir','mks_terakhir_thn','mks_terakhir_bln','mkg_terakhir_thn','mkg_terakhir_bln','gaji_pokok_terakhir','tmt_kgb_terakhir', 'tmt_yad_terakhir',
            'pkt_baru','mks_baru_thn','mks_baru_bln','mkg_baru_thn','mkg_baru_bln','gaji_pokok_baru','tmt_kgb_baru', 'tmt_yad_baru',
            'keterangan','tanggal_surat',
        ];
    }
    public function map($record): array
    {
        return [
            $record->nama,
            strval($record->nrp), 
            $this->getJenisKelamin($record->jenis_kelamin_id),
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($record->tanggal_lahir),
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($record->tmt_tni),
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($record->tmt_pangkat),
            $this->getKorp($record->korp_id),
            $record->jabatan,
            $record->kesatuan,
            $this->getPangkatLama($record->pangkat_lama_id),
            $record->tahun_mks_lama,
            $record->bulan_mks_lama,
            $record->tahun_mkg_lama,
            $record->bulan_mkg_lama,
            $record->gaji_pokok_lama,
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($record->tmt_kgb_lama),
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($record->tmt_kgb_yad_lama),
            $this->getPangkatBaru($record->pangkat_baru_id),
            $record->tahun_mks_baru,
            $record->bulan_mks_baru,
            $record->tahun_mkg_baru,
            $record->bulan_mkg_baru,
            $record->gaji_pokok_baru,
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($record->tmt_kgb_baru),
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($record->tmt_kgb_yad_baru),
            $record->keterangan,
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($record->tanggal_terbit),
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => "@",
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => 'dd/mm/yyyy',
            'E' => 'dd/mm/yyyy',
            'F' => 'dd/mm/yyyy',
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT, //pkt lama
            'K' => NumberFormat::FORMAT_GENERAL, //M,KS
            'L' => NumberFormat::FORMAT_GENERAL,
            'M' => NumberFormat::FORMAT_GENERAL,
            'N' => NumberFormat::FORMAT_GENERAL,
            'O' => '#,##0', //gaji lama
            'P' => 'dd/mm/yyyy', //tmt kgb lama
            'Q' => 'dd/mm/yyyy', //tmt kgb yad lam
            'R' => NumberFormat::FORMAT_TEXT, //PKT BARU
            'S' => NumberFormat::FORMAT_GENERAL, //M,KS
            'T' => NumberFormat::FORMAT_GENERAL,
            'U' => NumberFormat::FORMAT_GENERAL,
            'V' => NumberFormat::FORMAT_GENERAL,
            'W' => '#,##0', //gaji baru
            'X' => 'dd/mm/yyyy',
            'Y' => 'dd/mm/yyyy',
            'Z' => NumberFormat::FORMAT_GENERAL,
            'AA' => 'dd/mm/yyyy', //tgl terbit
        ];
    }
    public function dateFormat($dateString): string
    {
        if (isset($dateString)) 
        {
            return Carbon::createFromFormat('Y-m-d', $dateString)->format('d-m-Y');
        } 
        return '';       
    }
    public function getKorp($korp_id)
    {
        return isset($korp_id) ? Korp::find($korp_id)->nama : '';
        
    }
    public function getJenisKelamin($jenis_kelamin_id)
    {
        return isset($jenis_kelamin_id) ? JenisKelamin::find($jenis_kelamin_id)->singkatan : '';
        
    }
    public function getPangkatLama($record)
    {
        if (isset($record)) 
        {
            $query = GajiBerkalaMiliter::where('pangkat_lama_id', $record)->first();
            if ($query->jenis_kelamin_id == 2) {
                return $query->pangkatLama->nama. ' (K)';
            } else {
                return $query->pangkatLama->nama;
            }
        } 
        return '';
        
    }
    public function getPangkatBaru($record)
    {
        if (isset($record)) 
        {
            $query = GajiBerkalaMiliter::where('pangkat_baru_id', $record)->first();
            if ($query->jenis_kelamin_id == 2) {
                return $query->pangkatBaru->nama. ' (K)';
            } else {
                return $query->pangkatBaru->nama;
            }
        } 
        return '';
    }

    
}

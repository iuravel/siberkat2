<?php

namespace App\Exports;

use App\Models\GapokMiliter;
use App\Models\Pangkat;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class GapokMiliterExport implements FromQuery, Responsable, WithHeadings, WithMapping, WithColumnFormatting
{
    use Exportable;
    private $fileName = 'table-gaji-militer.xlsx';
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;
    
    public function query()
    {
        return GapokMiliter::query();
    }
    public function headings(): array
    {
        return [
            'PANGKAT',
            'MKG',
            'GAJI POKOK',
        ];
    }
    public function map($gapokMiliter): array
    {
        $pangkat = self::getNamaPangkat($gapokMiliter->pangkat_id);
        return [
            $pangkat,
            strval($gapokMiliter->masa_kerja),
            $gapokMiliter->gaji,
        ];
    }
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => '#,##0'
        ];
    }
    public static function getNamaPangkat(string $pangkat_id){
        return Pangkat::where('id', $pangkat_id)->first()->nama;
    }
}

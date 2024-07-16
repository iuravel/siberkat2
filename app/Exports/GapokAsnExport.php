<?php

namespace App\Exports;

use App\Models\GapokAsn;
use App\Models\Golongan;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class GapokAsnExport implements FromQuery, Responsable, WithHeadings, WithMapping, WithColumnFormatting
{
    use Exportable;
    const FORMAT_CURRENCY_IDR_SIMPLE = '#.##0';
    private $fileName = 'table-gaji-asn.xlsx';
    private $writerType = \Maatwebsite\Excel\Excel::XLSX;
    public function query()
    {
        return GapokAsn::query();
    }
    public function headings(): array
    {
        return [
            'GOLONGAN',
            'MKG',
            'GAJI POKOK',
        ];
    }
    public function map($gapokAsn): array
    {
        $golongan = self::getNamaGolongan($gapokAsn->golongan_id);
        return [
            $golongan,
            strval($gapokAsn->masa_kerja),
            $gapokAsn->gaji,
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
    public static function getNamaGolongan(string $golongan_id){
        return Golongan::where('id', $golongan_id)->first()->nama;
    }
}

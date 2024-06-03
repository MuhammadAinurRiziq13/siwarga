<?php
namespace App\Exports;

use App\Models\FamilyModel;
use App\Models\Keluarga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FamiliesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return FamilyModel::select('noKK', 'alamat', 'kelurahan_desa', 'kecamatan', 'kabupaten_kota', 'provinsi')->get();
    }

    public function headings(): array
    {
        return [
            'no_kk',
            'alamat',
            'kelurahan_desa',
            'kecamatan',
            'kabupaten_kota',
            'provinsi'
        ];
    }

    public function map($keluarga): array
    {
        return [
            "'" . $keluarga->noKK,
            $keluarga->alamat,
            $keluarga->kelurahan_desa,
            $keluarga->kecamatan,
            $keluarga->kabupaten_kota,
            $keluarga->provinsi
        ];
    }
}
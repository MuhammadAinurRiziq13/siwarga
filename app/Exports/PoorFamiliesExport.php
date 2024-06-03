<?php

namespace App\Exports;

use App\Models\PoorFamilyModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PoorFamiliesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return PoorFamilyModel::select('noKK', 'C1', 'C2', 'C3', 'C4', 'C5')->get();
    }

    public function headings(): array
    {
        return [
            'no_kk',
            'jumlah_tanggungan',
            'pendapatan',
            'aset_kendaraan',
            'luas_tanah',
            'kondisi_rumah'
        ];
    }

    public function map($family): array
    {
        return [
            "'" . $family->noKK,
            $family->C1,
            $family->C2,
            $family->C3,
            $family->C4,
            $family->C5,
        ];
    }
}

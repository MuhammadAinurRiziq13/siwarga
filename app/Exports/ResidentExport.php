<?php

namespace App\Exports;

use App\Models\ResidentModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResidentExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ResidentModel::select('NIK', 'noKK', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'status_pernikahan', 'status_keluarga', 'status_kerja')->get();
    }

    public function headings(): array
    {
        return [
            'nik',
            'no_kk',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'agama',
            'status_pernikahan',
            'status_keluarga',
            'status_kerja'
        ];
    }

    public function map($resident): array
    {
        return [
            "'" . $resident->NIK,
            "'" . $resident->noKK,
            $resident->nama,
            $resident->tempat_lahir,
            $resident->tanggal_lahir,
            $resident->jenis_kelamin,
            $resident->agama,
            $resident->status_pernikahan,
            $resident->status_keluarga,
            $resident->status_kerja,
        ];
    }
}

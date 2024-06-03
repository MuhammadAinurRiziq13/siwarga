<?php

namespace App\Imports;

use App\Models\ResidentModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResidentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ResidentModel([
            'NIK' => $row['nik'],
            'noKK' => $row['no_kk'],
            'nama' => $row['nama'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'agama' => $row['agama'],
            'status_pernikahan' => $row['status_pernikahan'],
            'status_keluarga' => $row['status_keluarga'],
            'status_kerja' => $row['status_kerja'],
        ]);
    }
}

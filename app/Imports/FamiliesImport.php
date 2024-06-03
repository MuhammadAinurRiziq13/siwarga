<?php

namespace App\Imports;

use App\Models\FamilyModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FamiliesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new FamilyModel([
            'noKK' => $row['no_kk'],
            'alamat' => $row['alamat'],
            'kelurahan_desa' => $row['kelurahan_desa'],
            'kecamatan' => $row['kecamatan'],
            'kabupaten_kota' => $row['kabupaten_kota'],
            'provinsi' => $row['provinsi'],
        ]);
    }
}


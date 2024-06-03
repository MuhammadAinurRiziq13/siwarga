<?php

namespace App\Imports;

use App\Models\KeluargaKurangMampu;
use App\Models\PoorFamilyModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PoorFamiliesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new PoorFamilyModel([
            'noKK' => $row['no_kk'],
            'C1' => $row['jumlah_tanggungan'],
            'C2' => $row['pendapatan'],
            'C3' => $row['aset_kendaraan'],
            'C4' => $row['luas_tanah'],
            'C5' => $row['kondisi_rumah'],
        ]);
    }
}

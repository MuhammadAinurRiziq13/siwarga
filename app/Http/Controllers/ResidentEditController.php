<?php

namespace App\Http\Controllers;

use App\Models\FamilyModel;
use App\Models\ResidentModel;
use Illuminate\Http\Request;

class ResidentEditController extends Controller
{
    public function index(string $nik)
    {
        $resident = ResidentModel::where('NIK', $nik)
            ->leftJoin('wargasementara', 'warga.NIK', '=', 'wargasementara.NIK_warga_sementara')
            ->first();
        $breadcrumb = (object)[
            'title' => 'Data Warga',
            'list' => ['Home', 'Warga', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Warga'
        ];
        return view('submission-changes.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'resident' => $resident,
        ]);
    }

    public function edit(string $nik)
    {
        $resident = ResidentModel::where('NIK', $nik)
            ->leftJoin('wargasementara', 'warga.NIK', '=', 'wargasementara.NIK_warga_sementara')
            ->first();
        $family = FamilyModel::all();
        $anggota = ResidentModel::where('noKK', $resident->noKK)->get();
        $breadcrumb = (object)[
            'title' => 'Edit Warga',
            'list' => ['Home', 'Warga', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Warga'
        ];
        return view('submission-changes.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'resident' => $resident,
            'family' => $family,
            'anggota' => $anggota,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Charts\AgeChart;
use App\Charts\GenderChart;
use App\Charts\PoorChart;
use App\Models\FamilyModel;
use App\Models\PoorFamilyModel;
use App\Models\ResidentModel;
use App\Models\TemporaryResident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(AgeChart $chart, GenderChart $chart1, PoorChart $chart2)
    {
        $totalResident = ResidentModel::count();
        $totalFamily = FamilyModel::count();
        $totalPoorFamily = PoorFamilyModel::count();
        $totalTemporaryResident = TemporaryResident::count();

        $chart = $chart->build();
        $chart1 = $chart1->build();
        $chart2 = $chart2->build();

        $breadcrumb = (object)[
            'title' => 'Selamat Datang, ' . Auth::user()->nama,
            'list' => ['Home', 'Dashboard']
        ];
        return view(
            'dashboard.index',
            [
                'breadcrumb' => $breadcrumb,
                'totalResident' => $totalResident,
                'totalFamily' => $totalFamily,
                'totalPoorFamily' => $totalPoorFamily,
                'totalTemporaryResident' => $totalTemporaryResident,
                'chart' => $chart,
                'chart1' => $chart1,
                'chart2' => $chart2,
            ]
        );
    }

    // public function show(string $id)
    // {
    //     $family = FamilyModel::select('keluarga.*', 'warga.NIK', 'warga.nama', 'warga.tempat_lahir', 'warga.tanggal_lahir', 'warga.jenis_kelamin', 'warga.status_keluarga')
    //         ->selectSub(function ($query) {
    //             $query->from('warga')
    //                 ->selectRaw('COUNT(warga.nama)')
    //                 ->whereColumn('warga.noKK', 'keluarga.noKK');
    //         }, 'jumlah_anggota')
    //         ->leftJoin('warga', 'keluarga.noKK', '=', 'warga.noKK')
    //         ->where('keluarga.noKK', $id)
    //         ->orderByRaw(
    //             "CASE 
    //             WHEN warga.status_keluarga = 'kepala keluarga' THEN 1 
    //             WHEN warga.status_keluarga = 'istri' THEN 2 
    //             WHEN warga.status_keluarga = 'anak' THEN 3 
    //             ELSE 4 
    //         END"
    //         )
    //         ->get();

    //     $breadcrumb = (object)[
    //         'title' => 'Selamat Datang ' . Auth::user()->nama,
    //         'list' => ['Home', 'Dashboard']
    //     ];

    //     $page = (object)[
    //         'title' => 'Detail Keluarga'
    //     ];
    //     return view('dashboard.index', [
    //         'breadcrumb' => $breadcrumb,
    //         'page' => $page,
    //         'family' => $family,
    //     ]);
    // }

    public function getFamilyData(string $id)
    {
        $nokk = ResidentModel::where('NIK', $id)->pluck('noKK')->first();

        // Ambil data keluarga dari database berdasarkan nomor KK
        $family = FamilyModel::leftJoin('warga', 'keluarga.noKK', '=', 'warga.noKK')
            ->where('keluarga.noKK', $nokk)
            ->where('warga.status_keluarga', 'kepala keluarga')
            ->select('keluarga.*', 'warga.nama')
            ->first();

        return response()->json($family);
    }
}
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
        $presentacePoorFamily = ($totalPoorFamily / $totalFamily) * 100;

        $chart = $chart->build();
        $chart1 = $chart1->build();
        $chart2 = $chart2->build();

        $breadcrumb = (object)[
            'title' => 'Selamat Datang ' . Auth::user()->nama,
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
                'presentacePoorFamily' => $presentacePoorFamily,
                'chart' => $chart,
                'chart1' => $chart1,
                'chart2' => $chart2,
            ]
        );
    }
}

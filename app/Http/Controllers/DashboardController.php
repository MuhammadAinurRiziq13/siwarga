<?php

namespace App\Http\Controllers;

use App\Models\FamilyModel;
use App\Models\PoorFamilyModel;
use App\Models\ResidentModel;
use App\Models\TemporaryResident;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalResident = ResidentModel::count();
        $totalFamily = FamilyModel::count();
        $totalPoorFamily = PoorFamilyModel::count();
        $totalTemporaryResident = TemporaryResident::count();

        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
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
            ]
        );
    }
}

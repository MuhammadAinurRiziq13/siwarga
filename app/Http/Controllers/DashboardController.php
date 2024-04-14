<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Dashboard']
        ];
        return view(
            'dashboard.index',
            [
                'breadcrumb' => $breadcrumb
            ]
        );
    }
}
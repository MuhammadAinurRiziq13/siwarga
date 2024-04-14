<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Resident']
        ];
        return view(
            'resident.index',
            [
                'breadcrumb' => $breadcrumb
            ]
        );
    }
}
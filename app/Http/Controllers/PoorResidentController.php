<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoorResidentController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Poor-Resident']
        ];
        return view(
            'poor-resident.index',
            [
                'breadcrumb' => $breadcrumb
            ]
        );
    }
}
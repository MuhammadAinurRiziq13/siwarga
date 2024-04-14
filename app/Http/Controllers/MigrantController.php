<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MigrantController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Migrant']
        ];
        return view(
            'migrant.index',
            [
                'breadcrumb' => $breadcrumb
            ]
        );
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Galery',
            'list' => ['Home', 'Gallery']
        ];
        return view(
            'gallery.index',
            [
                'breadcrumb' => $breadcrumb
            ]
        );
    }
}

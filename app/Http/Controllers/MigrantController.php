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

        $page = (object)[
            'title' => 'Daftar Warga yang terdaftar dalam sistem'
        ];

        return view(
            'migrant.index',
            [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
            ]
        );
    }

    // // Ambil data Barang dalam bentuk json untuk datatables 
    // public function list(Request $request)
    // {
    //     $Stocs = StokModel::select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
    //         ->with('barang')->with('user');
    //     //filter data Barang berdasarkan kategori_id
    //     if ($request->user_id) {
    //         $Stocs->where('user_id', $request->user_id);
    //     }

    //     return DataTables::of($Stocs)
    //         ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
    //         ->addColumn('aksi', function ($stok) { // menambahkan kolom aksi
    //             $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    //             $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">'
    //                 . csrf_field() . method_field('DELETE') .
    //                 '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
    //             return $btn;
    //         })
    //         ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
    //         ->make(true);
    // }
}
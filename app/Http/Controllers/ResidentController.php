<?php

namespace App\Http\Controllers;

use App\Models\ResidentModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ResidentController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Warga',
            'list' => ['Home', 'Resident']
        ];

        $page = (object)[
            'title' => 'Daftar Warga yang terdaftar dalam sistem'
        ];

        return view(
            'resident.index',
            [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
            ]
        );
    }

    // Ambil data Barang dalam bentuk json untuk datatables 
    public function list(Request $request)
    {
        $Residents = ResidentModel::select('NIK', 'noKK', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin');
        return DataTables::of($Residents)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($resident) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/resident/' . $resident->NIK) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';
                $btn .= '<a href="' . url('/resident/' . $resident->NIK . '/edit') . '" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/resident/' . $resident->NIK) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');"><i class="fas fa-trash-alt"></i></button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
}

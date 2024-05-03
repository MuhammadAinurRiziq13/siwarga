<?php

namespace App\Http\Controllers;

use App\Models\FamilyModel;
use App\Models\PoorFamilyModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PoorFamilyController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Keluarga Kurang Mampu',
            'list' => ['Home', 'Poor-Resident']
        ];
        return view(
            'poor-family.index',
            [
                'breadcrumb' => $breadcrumb
            ]
        );
    }

    public function list(Request $request)
    {
        $Family = PoorFamilyModel::select('keluargakurangmampu.noKK', 'warga.nama')
            ->join('warga', function ($join) {
                $join->on('keluargakurangmampu.noKK', '=', 'warga.noKK')
                    ->where('warga.kepala_keluarga', true);
            })
            ->selectSub(function ($query) {
                $query->from('warga')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('warga.noKK', 'keluargakurangmampu.noKK')
                    ->limit(1);
            }, 'jumlah_anggota');


        return DataTables::of($Family)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($family) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/poor-family/' . $family->noKK) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';
                $btn .= '<a href="' . url('/poor-family/' . $family->noKK . '/edit') . '" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/poor-family/' . $family->noKK) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');"><i class="fas fa-trash-alt"></i></button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function show(string $id)
    {
        $poorFamily = PoorFamilyModel::where('noKK', $id)->first();
        $breadcrumb = (object)[
            'title' => 'Data Keluarga Kurang Mampu',
            'list' => ['Home', 'Keluarga Kurang Mampu', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Keluarga Kurang Mampu'
        ];
        return view('poor-family.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'poorFamily' => $poorFamily,
        ]);
    }

    public function create()
    {
        $family = FamilyModel::all();
        $breadcrumb = (object)[
            'title' => 'Tambah Keluarga Kurang Mampu',
            'list' => ['Home', 'Keluarga Kurang Mampu', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Keluarga Kurang Mampu Baru'
        ];

        return view('poor-family.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'family' => $family,
        ]);
    }
}

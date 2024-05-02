<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\FamilyModel;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Keluarga',
            'list' => ['Home', 'Family']
        ];

        $page = (object)[
            'title' => 'Daftar Keluarga yang terdaftar dalam sistem'
        ];

        return view(
            'family.index',
            [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
            ]
        );
    }

    // // Ambil data Barang dalam bentuk json untuk datatables 
    public function list(Request $request)
    {
        $Family = FamilyModel::select('keluarga.noKK', 'keluarga.alamat')
            ->leftJoin('warga', 'keluarga.noKK', '=', 'warga.noKK')
            ->selectSub(function ($query) {
                $query->from('warga')
                    ->selectRaw('COALESCE(COUNT(*), 0)')
                    ->whereColumn('warga.noKK', 'keluarga.noKK')
                    ->groupBy('warga.noKK');
            }, 'jumlah_anggota')
            ->groupBy('keluarga.noKK', 'keluarga.alamat');

        return DataTables::of($Family)
            ->addIndexColumn()
            ->addColumn('aksi', function ($family) {
                $btn = '<a href="' . url('/family/' . $family->noKK) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';
                $btn .= '<a href="' . url('/family/' . $family->noKK . '/edit') . '" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/family/' . $family->noKK) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');"><i class="fas fa-trash-alt"></i></button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function show(string $id)
    {
        // $family = FamilyModel::where('noKK', $id)->first();
        $family = FamilyModel::select('keluarga.*', 'warga.NIK', 'warga.nama', 'warga.tempat_lahir', 'warga.tanggal_lahir', 'warga.jenis_kelamin',)
            ->selectSub(function ($query) {
                $query->from('warga')
                    ->selectRaw('COUNT(warga.nama)')
                    ->whereColumn('warga.noKK', 'keluarga.noKK');
            }, 'jumlah_anggota')
            ->leftJoin('warga', 'keluarga.noKK', '=', 'warga.noKK')
            ->where('keluarga.noKK', $id)
            ->get();


        $breadcrumb = (object)[
            'title' => 'Data Keluarga',
            'list' => ['Home', 'Keluarga', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Keluarga'
        ];
        return view('family.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'family' => $family,
        ]);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Keluarga',
            'list' => ['Home', 'Keluarga', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Keluarga Baru'
        ];

        return view('family.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'noKK' => 'required|string|min:16|unique:keluarga,noKK',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'provinsi' => 'required|string',
        ]);


        // Fungsi eloquent untuk menambah data
        FamilyModel::create([
            'noKK' => $request->noKK,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
        ]);

        return redirect('/family')->with('success', 'Data keluarga berhasil disimpan');
    }

    public function edit(string $id)
    {
        $family = FamilyModel::where('noKK', $id)->first();
        $breadcrumb = (object)[
            'title' => 'Edit Keluarga',
            'list' => ['Home', 'Keluarga', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Keluarga'
        ];
        return view('family.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'family' => $family,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'noKK' => 'required|string|min:16|unique:keluarga,noKK,' . $id . ',noKK',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'provinsi' => 'required|string',
        ]);

        // Update data warga
        FamilyModel::find($id)->update([
            'noKK' => $request->noKK,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
        ]);

        // Jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect('/family')->with('success', 'Data Keluarga Berhasil Diubah');
    }

    public function destroy(string $id)
    {
        $check = FamilyModel::find($id);
        if (!$check) {
            redirect('/family')->with('error', 'Data Keluarga tidak ditemukan');
        }

        try {
            FamilyModel::destroy($id);
            return redirect('/family')->with('success', 'Data Keluarga berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi eror ketika menghapus data, redirect kembali ke halaman dengan membawa pesan eror
            return redirect('/family')->with('error', 'Data Keluarga gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
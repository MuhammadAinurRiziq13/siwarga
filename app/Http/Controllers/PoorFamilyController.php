<?php

namespace App\Http\Controllers;

use App\Models\FamilyModel;
use App\Models\PoorFamilyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PoorFamilyController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera']
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
                    ->where('warga.status_keluarga', 'kepala keluarga');
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
                if (Auth::user()->level == 'admin') {
                    $btn .= '<a href="' . url('/poor-family/' . $family->noKK . '/edit') . '" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . url('/poor-family/' . $family->noKK) . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');"><i class="fas fa-trash-alt"></i></button></form>';
                }
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function show(string $id)
    {
        $poorFamily = PoorFamilyModel::where('noKK', $id)->first();
        $breadcrumb = (object)[
            'title' => 'Data Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Keluarga Pra-Sejahtera'
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
            'title' => 'Tambah Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Keluarga Pra-Sejahtera Baru'
        ];

        return view('poor-family.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'family' => $family,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'noKK' => 'required',
            'jumlah_tanggungan' => 'required',
            'pendapatan' => 'required',
            'jumlah_kendaraan' => 'required',
            'luas_tanah' => 'required',
            'kondisi_rumah' => 'required',
        ]);


        // Fungsi eloquent untuk menambah data
        PoorFamilyModel::create([
            'noKK' => $request->noKK,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
            'pendapatan' => $request->pendapatan,
            'jumlah_kendaraan' => $request->jumlah_kendaraan,
            'luas_tanah' => $request->luas_tanah,
            'kondisi_rumah' => $request->kondisi_rumah,
        ]);

        return redirect('/poor-family')->with('success', 'Data Keluarga Pra-Sejahtera berhasil disimpan');
    }

    public function edit(string $id)
    {
        $poorFamily = PoorFamilyModel::where('noKK', $id)->first();
        $family = FamilyModel::all();
        $breadcrumb = (object)[
            'title' => 'Edit Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Keluarga Pra-Sejahtera'
        ];
        return view('poor-family.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'poorFamily' => $poorFamily,
            'family' => $family,
        ]);
    }

    public function update(Request $request, string $noKK)
    {
        $request->validate([
            'noKK' => 'required',
            'jumlah_tanggungan' => 'required',
            'pendapatan' => 'required',
            'jumlah_kendaraan' => 'required',
            'luas_tanah' => 'required',
            'kondisi_rumah' => 'required',
        ]);

        // Update data Keluarga Pra-Sejahtera
        PoorFamilyModel::where('noKK', $noKK)->update([
            'noKK' => $request->noKK,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
            'pendapatan' => $request->pendapatan,
            'jumlah_kendaraan' => $request->jumlah_kendaraan,
            'luas_tanah' => $request->luas_tanah,
            'kondisi_rumah' => $request->kondisi_rumah,
        ]);

        // Jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect('/poor-family')->with('success', 'Data Keluarga Pra-Sejahtera Berhasil Diubah');
    }

    public function destroy(string $noKK)
    {
        $check = PoorFamilyModel::where('noKK', $noKK)->first();
        if (!$check) {
            return redirect('/poor-family')->with('error', 'Data Keluarga Pra-Sejahtera tidak ditemukan');
        }

        try {
            // Hapus data dari tabel anak (keluargaKurangMampu)
            PoorFamilyModel::where('noKK', $noKK)->delete();

            return redirect('/poor-family')->with('success', 'Data Keluarga Pra-Sejahtera berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/poor-family')->with('error', 'Data Keluarga Pra-Sejahtera gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}

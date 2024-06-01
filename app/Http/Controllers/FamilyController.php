<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\FamilyModel;
use App\Models\ResidentModel;
use App\Models\TemporaryResident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                if (Auth::user()->level == 'admin') {
                    $btn .= '<a href="' . url('/family/' . $family->noKK . '/edit') . '" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . url('/family/' . $family->noKK) . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');"><i class="fas fa-trash-alt"></i></button></form>';
                }
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function show(string $id)
    {
        $family = FamilyModel::select('keluarga.*', 'warga.NIK', 'warga.nama', 'warga.tempat_lahir', 'warga.tanggal_lahir', 'warga.jenis_kelamin', 'warga.status_keluarga')
            ->selectSub(function ($query) {
                $query->from('warga')
                    ->selectRaw('COUNT(warga.nama)')
                    ->whereColumn('warga.noKK', 'keluarga.noKK');
            }, 'jumlah_anggota')
            ->leftJoin('warga', 'keluarga.noKK', '=', 'warga.noKK')
            ->where('keluarga.noKK', $id)
            ->orderByRaw(
                "CASE 
                    WHEN warga.status_keluarga = 'kepala keluarga' THEN 1 
                    WHEN warga.status_keluarga = 'istri' THEN 2 
                    WHEN warga.status_keluarga = 'anak' THEN 3 
                    ELSE 4 
                END"
            )
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

    public function create1(string $id)
    {
        $data = FamilyModel::where('noKK', $id)->get();
        $jml = ResidentModel::where('noKK', $id)->get();
        $count = $jml->count();
        $breadcrumb = (object)[
            'title' => '',
            'list' => ['Home', 'Warga', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah Data Warga Baru'
        ];

        return view('family.create1', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'data' => $data,
            'count' => $count,
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'noKK' => 'required|string|min:16|unique:keluarga,noKK',
            'alamat' => 'required|string',
            'kelurahan_desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'provinsi' => 'required|string',
        ]);


        // Fungsi eloquent untuk menambah data
        FamilyModel::create([
            'noKK' => $request->noKK,
            'alamat' => $request->alamat,
            'kelurahan_desa' => $request->kelurahan_desa,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
        ]);

        return redirect('/family/' . $request->noKK . '/create')->with('success', 'Apakah anda ingin input data warga??');
    }

    public function store1(Request $request)
    {
        $request->validate([
            'NIK' => 'required|string|min:16|unique:warga,NIK',
            'noKK' => 'required',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status_pernikahan' => 'required',
            'status_kerja' => 'required',
            'alamat_asal' => 'required_if:alamat_asal_checkbox,on', // Jika checkbox di-check, alamat_asal harus diisi
            'status_keluarga' => [
                function ($fail) use ($request) {
                    // Mengecek apakah ada kepala keluarga dengan nomor KK yang sama
                    $count = ResidentModel::where('noKK', $request->noKK)
                        ->where('status_keluarga', 'kepala keluarga')
                        ->count();

                    // Jika ada kepala keluarga lain dengan nomor KK yang sama
                    if ($count > 0 && $request->status_keluarga == 'kepala keluarga') {
                        $fail('Nomor KK ini sudah memiliki kepala keluarga.');
                    }
                },
            ],
        ]);


        // Fungsi eloquent untuk menambah data
        ResidentModel::create([
            'NIK' => $request->NIK,
            'noKK' => $request->noKK,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'status_keluarga' => $request->status_keluarga,
            'status_kerja' => $request->status_kerja,
        ]);

        // Jika checkbox di-check, tambahkan data ke tabel warga sementara
        if ($request->has('alamat_asal_checkbox')) {
            TemporaryResident::create([
                'NIK_warga_sementara' => $request->NIK,
                'alamat_asal' => $request->alamat_asal
            ]);
        }

        if ($request->status_keluarga == 'kepala keluarga') {
            User::create([
                'username' => $request->NIK,
                'password' =>  Hash::make($request->NIK),
                'nama' => $request->nama,
                'level' => 'warga',
            ]);
        }

        return redirect('/family/' . $request->noKK . '/create')->with('success', 'Apakah anda ingin input data warga lagi??');
    }

    public function edit(string $id)
    {
        $family = FamilyModel::where('noKK', $id)->first();
        $breadcrumb = (object)[
            'title' => 'Edit Keluarga',
            'list' => ['Home', 'Keluarga', 'Edit']
        ];
        $page = (object)[
            'title' => 'Form Edit Keluarga'
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
            'kelurahan_desa' => 'required|string',
            'provinsi' => 'required|string',
        ]);

        // Update data warga
        FamilyModel::find($id)->update([
            'noKK' => $request->noKK,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kelurahan_desa' => $request->kelurahan_desa,
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
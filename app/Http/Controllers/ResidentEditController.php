<?php

namespace App\Http\Controllers;

use App\Models\FamilyModel;
use App\Models\ResidentModel;
use App\Models\SubmissionChangesModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ResidentEditController extends Controller
{
    public function index(string $nik)
    {
        $nokk = ResidentModel::where('NIK', $nik)->pluck('noKK')->first();
        $family = FamilyModel::select('keluarga.*', 'warga.NIK', 'warga.nama', 'warga.tempat_lahir', 'warga.tanggal_lahir', 'warga.jenis_kelamin', 'warga.status_keluarga')
            ->selectSub(function ($query) {
                $query->from('warga')
                    ->selectRaw('COUNT(warga.nama)')
                    ->whereColumn('warga.noKK', 'keluarga.noKK');
            }, 'jumlah_anggota')
            ->leftJoin('warga', 'keluarga.noKK', '=', 'warga.noKK')
            ->where('keluarga.noKK', $nokk)
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
            'title' => 'Data Anggota Keluarga',
            'list' => ['Home', 'Warga']
        ];
        $page = (object)[
            'title' => 'Data Keluarga'
        ];
        return view('warga.submission-changes.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'family' => $family,
        ]);
    }

    public function edit(string $nik)
    {
        $resident = ResidentModel::where('NIK', $nik)
            ->leftJoin('wargasementara', 'warga.NIK', '=', 'wargasementara.NIK_warga_sementara')
            ->first();
        $family = FamilyModel::all();
        $anggota = ResidentModel::where('noKK', $resident->noKK)->get();
        $breadcrumb = (object)[
            'title' => 'Edit Warga',
            'list' => ['Home', 'Warga', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Warga'
        ];
        return view('warga.submission-changes.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'resident' => $resident,
            'family' => $family,
            'anggota' => $anggota,
        ]);
    }

    public function list(Request $request)
    {
        $nokk = $request->nokk; // Terima nomor KK dari request

        $Submissions = SubmissionChangesModel::select('pengajuanEditDataWarga.NIK_pengajuan', 'warga.nama', 'pengajuanEditDataWarga.created_at', 'pengajuanEditDataWarga.status')
            ->join('warga', 'pengajuanEditDataWarga.NIK_pengajuan', '=', 'warga.NIK')
            ->where('warga.noKK', $nokk) // Menambahkan kondisi untuk nomor KK tertentu
            ->orderByRaw(
                "CASE 
            WHEN pengajuanEditDataWarga.status = 'proses' THEN 1 
            WHEN pengajuanEditDataWarga.status = 'selesai' THEN 2 
            WHEN pengajuanEditDataWarga.status = 'ditolak' THEN 3 
            ELSE 4 
        END"
            )
            ->get();

        return DataTables::of($Submissions)
            ->addIndexColumn()
            ->addColumn('waktu_pengajuan', function ($submission) {
                return date('Y-m-d H:i:s', strtotime($submission->created_at));
            })
            ->addColumn('aksi', function ($submission) {
                return '<a href="' . url('/resident-edit/' . $submission->NIK) . '" class="btn btn-info btn-sm">Detail</a>';
            })
            ->addColumn('status', function ($submission) {
                if ($submission->status == 'proses') {
                    return '<p class="text-primary">Proses</p>';
                } else if ($submission->status == 'selesai') {
                    return '<p class="text-success">Selesai</p>';
                } else if ($submission->status == 'ditolak') {
                    return '<p class="text-danger">Ditolak</p>';
                }
            })
            ->rawColumns(['status', 'aksi'])
            ->make(true);
    }

    public function show(string $nik)
    {
        // $resident = ResidentModel::where('NIK', $nik)->first();
        $resident = ResidentModel::where('NIK', $nik)
            ->leftJoin('wargasementara', 'warga.NIK', '=', 'wargasementara.NIK_warga_sementara')
            ->first();
        $breadcrumb = (object)[
            'title' => 'Data Warga',
            'list' => ['Home', 'Warga', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Warga'
        ];
        return view('warga.submission-changes.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'resident' => $resident,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'NIK_pengajuan' => 'required|string|min:16|unique:warga,NIK',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status_pernikahan' => 'required',
            'alamat_asal' => 'required_if:alamat_asal_checkbox,on', // Jika checkbox di-check, alamat_asal harus diisi
            'status_keluarga' => [
                function ($attribute, $value, $fail) use ($request) {
                    // Mengecek apakah ada kepala keluarga dengan nomor KK yang sama
                    $count = ResidentModel::where('noKK', $request->noKK)
                        ->where('status_keluarga', 'kepala keluarga')
                        ->count();

                    // Jika ada kepala keluarga lain dengan nomor KK yang sama
                    if ($count > 0 && $value) {
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

        return redirect('/resident')->with('success', 'Data warga berhasil disimpan');
    }
}
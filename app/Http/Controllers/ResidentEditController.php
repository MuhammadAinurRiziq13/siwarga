<?php

namespace App\Http\Controllers;

use App\Models\BuktiEditModel;
use App\Models\FamilyModel;
use App\Models\ResidentModel;
use App\Models\SubmissionAddModel;
use App\Models\SubmissionChangesModel;
use App\Models\TemporaryResident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'title' => 'Form Pengajuan Edit Data Warga'
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

        $Submissions = SubmissionChangesModel::select('pengajuanEditDataWarga.id', 'pengajuanEditDataWarga.NIK', 'warga.nama', 'pengajuanEditDataWarga.created_at', 'pengajuanEditDataWarga.status')
            ->join('warga', 'pengajuanEditDataWarga.NIK', '=', 'warga.NIK')
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
                return date('d-m-Y H:i:s', strtotime($submission->created_at));
            })
            ->addColumn('aksi', function ($submission) {
                $btn = '<a href="' . url('/resident-edit/' . $submission->id . '/show1') . '" class="btn btn-info btn-sm mr-2"><i class="fas fa-eye"></i></a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/resident-edit/' . $submission->id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');"><i class="fas fa-trash-alt"></i></button></form>';
                return $btn;
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
            'NIK' => 'required|string|min:16|',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status_pernikahan' => 'required',
            'no_hp' => 'required',
            'keterangan' => 'required',
            'nama_bukti.*' => 'image',
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

        // Menyimpan data pengajuan edit data
        $submission = SubmissionChangesModel::create([
            'NIK' => $request->NIK,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'status_keluarga' => $request->status_keluarga,
            'status_kerja' => $request->status_kerja,
            'keterangan' => $request->keterangan,
            'no_hp' => $request->no_hp,
            'status' => 'proses',
            'alamat_asal' => $request->alamat_asal,
            'family_member' => $request->family_member
        ]);

        // Menyimpan data bukti edit data dengan menghubungkannya dengan id dari data pengajuan edit data yang baru saja dimasukkan
        if ($request->hasFile('nama_bukti')) {
            foreach ($request->file('nama_bukti') as $image) {
                $imageName = $image->store('gallery'); // Menyimpan gambar dan mendapatkan nama file

                // Menyimpan nama file gambar sebagai bukti edit
                BuktiEditModel::create([
                    'edit' => $submission->id,
                    'nama_bukti' => $imageName,
                ]);
            }
        }

        return redirect('/resident-edit/' . Auth::user()->username)->with('success', 'Pengajuan Edit Data Derhasil Disimpan');
    }

    public function show1(string $id)
    {
        $changes = SubmissionChangesModel::find($id);
        $bukti = BuktiEditModel::where('edit', $id)->get();
        $pengganti = ResidentModel::find($changes->family_member);

        $breadcrumb = (object)[
            'title' => 'Detail Pengajuan Edit Data Warga',
            'list' => ['Home', 'Pengajuan', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Pengajuan Edit Data Warga'
        ];
        return view('warga.submission-changes.show1', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'changes' => $changes,
            'bukti' => $bukti,
            'pengganti' => $pengganti,
        ]);
    }


    public function destroy(string $id)
    {
        $check = SubmissionChangesModel::find($id);
        $bukti = BuktiEditModel::where('edit', $id)->pluck('nama_bukti');

        if (!$check) {
            redirect('/resident-edit/' . Auth::user()->username)->with('error', 'Data warga tidak ditemukan');
        }

        try {
            foreach ($bukti as $namaBukti) {
                // Hapus file dari storage dengan menggunakan nama file
                Storage::delete($namaBukti);
            }
            SubmissionChangesModel::destroy($id);

            return redirect('/resident-edit/' . Auth::user()->username)->with('success', 'Data Pengajuan Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi eror ketika menghapus data, redirect kembali ke halaman dengan membawa pesan eror
            return redirect('/resident-edit/' . Auth::user()->username)->with('error', 'Data Pengajuan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
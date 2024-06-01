<?php

namespace App\Http\Controllers;

use App\Models\BuktiAddModel;
use App\Models\FamilyModel;
use App\Models\PoorFamilyModel;
use App\Models\ResidentModel;
use App\Models\SubmissionAddModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SubmissionPrasejahteraController extends Controller
{
    public function index(string $nik)
    {
        $nokk = ResidentModel::where('NIK', $nik)->pluck('noKK')->first();
        $poorFamily = PoorFamilyModel::where('noKK', $nokk)->first();

        $breadcrumb = (object)[
            'title' => 'Data Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera']
        ];
        $page = (object)[
            'title' => 'Detail Keluarga Pra-Sejahtera'
        ];
        return view('warga.submission-add.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'poorFamily' => $poorFamily,
            'nokk' => $nokk,
        ]);
    }

    public function list(Request $request)
    {
        $nokk = $request->nokk; // Terima nomor KK dari request

        $Submissions = SubmissionAddModel::select('pengajuanprasejahtera.id', 'pengajuanprasejahtera.noKK', 'warga.nama', 'pengajuanprasejahtera.created_at', 'pengajuanprasejahtera.status')
            ->join('warga', function ($join) {
                $join->on('pengajuanprasejahtera.noKK', '=', 'warga.noKK')
                    ->where('warga.status_keluarga', 'kepala keluarga');
            })
            ->where('pengajuanprasejahtera.noKK', $nokk) // Menambahkan kondisi untuk nomor KK tertentu
            ->orderByRaw(
                "CASE 
                WHEN pengajuanprasejahtera.status = 'proses' THEN 1 
                WHEN pengajuanprasejahtera.status = 'selesai' THEN 2 
                WHEN pengajuanprasejahtera.status = 'ditolak' THEN 3 
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
                $btn = '<a href="' . url('/submission-prasejahtera/' . $submission->id . '/show') . '" class="btn btn-info btn-sm mr-2"><i class="fas fa-eye"></i></a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/submission-prasejahtera/' . $submission->id) . '">'
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

    public function create(string $id)
    {
        $nokk = ResidentModel::where('NIK', $id)->pluck('noKK')->first();
        $family = FamilyModel::all();

        $breadcrumb = (object)[
            'title' => 'Pengajuan Keluarga Pra Sejahtera',
            'list' => ['Home', 'Warga', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Pengajuan Keluarga Pra Sejahtera'
        ];

        return view('warga.submission-add.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'nokk' => $nokk,
            'family' => $family,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'noKK' => 'required',
            'jumlah_tanggungan' => 'required',
            'pendapatan' => 'required',
            'aset_kendaraan' => 'required',
            'luas_tanah' => 'required',
            'kondisi_rumah' => 'required',
            'no_hp' => 'required',
            'nama_bukti.*' => 'image',
        ]);

        // Fungsi eloquent untuk menambah data
        $submission = SubmissionAddModel::create([
            'noKK' => $request->noKK,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
            'pendapatan' => $request->pendapatan,
            'aset_kendaraan' => $request->aset_kendaraan,
            'luas_tanah' => $request->luas_tanah,
            'kondisi_rumah' => $request->kondisi_rumah,
            'no_hp' => $request->no_hp,
            'status' => 'proses',
        ]);

        if ($request->hasFile('nama_bukti')) {
            foreach ($request->file('nama_bukti') as $image) {
                $imageName = $image->store('gallery'); // Menyimpan gambar dan mendapatkan nama file

                // Menyimpan nama file gambar sebagai bukti edit
                BuktiAddModel::create([
                    'add' => $submission->id,
                    'nama_bukti' => $imageName,
                ]);
            }
        }

        return redirect('/submission-prasejahtera/' . Auth::user()->username)->with('success', 'Pengajuan Keluarga Pra-Sejahtera berhasil disimpan');
    }

    public function show(string $id)
    {
        $add = SubmissionAddModel::find($id);
        $nama = SubmissionAddModel::select('warga.nama as kepala_keluarga')
            ->where('pengajuanprasejahtera.noKK', $add->noKK)
            ->leftJoin('keluarga', 'keluarga.noKK', '=', 'pengajuanprasejahtera.noKK')
            ->leftJoin('warga', function ($join) {
                $join->on('keluarga.noKK', '=', 'warga.noKK')
                    ->where('warga.status_keluarga', '=', 'kepala keluarga');
            })
            ->first();
        $bukti = BuktiAddModel::where('add', $id)->get();

        $breadcrumb = (object)[
            'title' => 'Detail Pengajuan Keluarga Pra Sejahtera',
            'list' => ['Home', 'Pengajuan', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Pengajuan Keluarga Pra Sejahtera'
        ];
        return view('warga.submission-add.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'add' => $add,
            'nama' => $nama,
            'bukti' => $bukti,
        ]);
    }

    public function destroy(string $id)
    {
        $check = SubmissionAddModel::find($id);
        $bukti = BuktiAddModel::where('add', $id)->pluck('nama_bukti');
        if (!$check) {
            redirect('/submission-prasejahtera/' . Auth::user()->username)->with('error', 'Data Pengajuan tidak ditemukan');
        }

        try {
            foreach ($bukti as $namaBukti) {
                // Hapus file dari storage dengan menggunakan nama file
                Storage::delete($namaBukti);
            }
            SubmissionAddModel::destroy($id);
            return redirect('/submission-prasejahtera/' . Auth::user()->username)->with('success', 'Data Pengajuan Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi eror ketika menghapus data, redirect kembali ke halaman dengan membawa pesan eror
            return redirect('/submission-prasejahtera/' . Auth::user()->username)->with('error', 'Data Pengajuan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
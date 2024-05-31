<?php

namespace App\Http\Controllers;

use App\Models\FamilyModel;
use App\Models\PoorFamilyModel;
use App\Models\ResidentModel;
use App\Models\SubmissionAddModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                return date('Y-m-d H:i:s', strtotime($submission->created_at));
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
            'title' => 'Tambah Warga',
            'list' => ['Home', 'Warga', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Warga Baru'
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
        ]);

        // Fungsi eloquent untuk menambah data
        SubmissionAddModel::create([
            'noKK' => $request->noKK,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
            'pendapatan' => $request->pendapatan,
            'aset_kendaraan' => $request->aset_kendaraan,
            'luas_tanah' => $request->luas_tanah,
            'kondisi_rumah' => $request->kondisi_rumah,
            'no_hp' => $request->no_hp,
            'status' => 'proses',
        ]);

        return redirect('/submission-prasejahtera/' . Auth::user()->username)->with('success', 'Pengajuan Keluarga Pra-Sejahtera berhasil disimpan');
    }

    public function show(string $id)
    {
        $add = SubmissionAddModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Show Pengajuan Edit Data Warga',
            'list' => ['Home', 'Pengajuan', 'Show']
        ];
        $page = (object)[
            'title' => 'Show Pengajuan Edit Data Warga'
        ];
        return view('warga.submission-add.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'add' => $add,
        ]);
    }
}
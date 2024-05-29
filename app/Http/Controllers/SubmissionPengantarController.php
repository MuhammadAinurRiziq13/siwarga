<?php

namespace App\Http\Controllers;

use App\Models\ResidentModel;
use App\Models\SubmissionLetterModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubmissionPengantarController extends Controller
{
    public function index(string $nik)
    {
        $nokk = ResidentModel::where('NIK', $nik)->pluck('noKK')->first();

        $breadcrumb = (object)[
            'title' => 'Pengajuan Surat pengantar',
            'list' => ['Home', 'Surat Pengantar']
        ];
        $page = (object)[
            'title' => 'Pengajuan Surat pengantar'
        ];
        return view('warga.submission-letter.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'nokk' => $nokk,
        ]);
    }

    public function list(Request $request)
    {
        $nokk = $request->nokk; // Terima nomor KK dari request

        $Submissions = SubmissionLetterModel::select('pengajuansuratpengantar.NIK', 'warga.nama', 'pengajuansuratpengantar.created_at', 'pengajuansuratpengantar.status')
            ->join('warga', 'pengajuansuratpengantar.NIK', '=', 'warga.NIK')
            ->where('warga.noKK', $nokk) // Menambahkan kondisi untuk nomor KK tertentu
            ->orderByRaw(
                "CASE 
            WHEN pengajuansuratpengantar.status = 'proses' THEN 1 
            WHEN pengajuansuratpengantar.status = 'selesai' THEN 2 
            WHEN pengajuansuratpengantar.status = 'ditolak' THEN 3 
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
                return '<a href="' . url('/submission-pengantar/' . $submission->NIK) . '" class="btn btn-info btn-sm">Detail</a>';
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
}

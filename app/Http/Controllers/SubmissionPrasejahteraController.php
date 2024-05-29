<?php

namespace App\Http\Controllers;

use App\Models\PoorFamilyModel;
use App\Models\ResidentModel;
use App\Models\SubmissionAddModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubmissionPrasejahteraController extends Controller
{
    public function index(string $nik)
    {
        $nokk = ResidentModel::where('NIK', $nik)->pluck('noKK')->first();
        $poorFamily = SubmissionAddModel::where('noKK', $nokk)->first();

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

        $Submissions = SubmissionAddModel::select('pengajuanprasejahtera.noKK', 'warga.nama', 'pengajuanprasejahtera.created_at', 'pengajuanprasejahtera.status')
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

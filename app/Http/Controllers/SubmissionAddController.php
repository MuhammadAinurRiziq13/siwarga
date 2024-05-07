<?php

namespace App\Http\Controllers;

use App\Models\SubmissionAddModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubmissionAddController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Pengajuan Tambah Keluarga Kurang Mampu',
            'list' => ['Home', 'Pengajuan Tambah Keluarga Kurang Mampu']
        ];
        return view(
            'poor-family.submission-add.index',
            [
                'breadcrumb' => $breadcrumb
            ]
        );
    }

    public function list(Request $request)
    {
        $Submission = SubmissionAddModel::select('pengajuankeluargakurangmampu.noKK_pengajuan', 'warga.nama', 'pengajuankeluargakurangmampu.created_at')
            ->join('warga', function ($join) {
                $join->on('pengajuankeluargakurangmampu.noKK_pengajuan', '=', 'warga.noKK')
                    ->where('warga.kepala_keluarga', true);
            })
            ->get();

        return DataTables::of($Submission)
            ->addIndexColumn()
            ->addColumn('waktu_pengajuan', function ($submission) {
                return date('Y-m-d H:i:s', strtotime($submission->created_at));
            })
            ->addColumn('aksi', function ($submission) {
                $btn = '<a href="' . url('/pengajuan-edit/' . $submission->NIK_pengajuan . '/proses') . '" class="btn btn-primary btn-sm">Proses</a> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
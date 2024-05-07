<?php

namespace App\Http\Controllers;

use App\Models\SubmissionChangesModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubmissionChangesController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Pengajuan Edit Data Warga',
            'list' => ['Home', 'Pengajuan Edit']
        ];
        return view(
            'resident.submission-changes.index',
            [
                'breadcrumb' => $breadcrumb
            ]
        );
    }

    public function list(Request $request)
    {
        $Submission = SubmissionChangesModel::select(['NIK_pengajuan', 'nama', 'created_at', 'keterangan']);

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
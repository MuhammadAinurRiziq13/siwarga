<?php

namespace App\Http\Controllers;

use App\Models\SubmissionLetterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\Facades\DataTables;

class SubmissionLetterController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => '',
            'list' => ['Home', 'Pengajuan Surat Pengantar']
        ];
        $page = (object)[
            'title' => 'Daftar Pengajuan Surat Pengantar'
        ];
        return view(
            'submission-letter.index',
            [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
            ]
        );
    }

    public function list(Request $request)
    {
        $Submissions = SubmissionLetterModel::select('pengajuansuratpengantar.id', 'pengajuansuratpengantar.NIK', 'warga.nama', 'pengajuansuratpengantar.created_at', 'pengajuansuratpengantar.status')
            ->join('warga', 'pengajuansuratpengantar.NIK', '=', 'warga.NIK')
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
                return date('d-m-Y H:i:s', strtotime($submission->created_at));
            })
            ->addColumn('aksi', function ($submission) {
                return '<a href="' . url('/submission-letter/' . $submission->id) . '" class="btn btn-info btn-sm">Detail</a>';
            })
            ->addColumn('status', function ($submission) {
                if ($submission->status == 'proses' && Auth::user()->level == 'admin') {
                    return '<a href="' . url('/submission-letter/' . $submission->id . '/proses') . '" class="btn btn-primary btn-sm">Proses</a>';
                } else if ($submission->status == 'proses' && Auth::user()->level == 'superadmin') {
                    return '<p class="text-primary">Proses</p>';
                } else if ($submission->status == 'selesai') {
                    return '<p class="text-success">Selesai</p>';
                } else if ($submission->status == 'ditolak') {
                    return '<p class="text-danger">Ditolak</p>';
                }
            })
            ->addColumn('download', function ($submission) {
                if ($submission->status == 'selesai') {
                    return '<a href="' . url('/submission-letter/' . 'download-word/'. $submission->id) . '" class="btn btn-success btn-sm">Download</a>';
                }
                return '';
            })
            ->rawColumns(['aksi', 'status', 'download'])
            ->make(true);
    }

    public function proses(string $id)
    {
        $letter = SubmissionLetterModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Proses Pengajuan Surat Pengantar',
            'list' => ['Home', 'Pengajuan', 'Proses']
        ];
        $page = (object)[
            'title' => 'Proses Pengajuan Surat Pengantar'
        ];
        return view('submission-letter.proses', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'letter' => $letter,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'NIK' => 'required|string|min:16',
            'pekerjaan' => 'required|string',
            'pendidikan' => 'required|string',
            'agama' => 'required|string',
            'keperluan' => 'required|string',
            'no_hp' => 'required|string',
            'status' => 'required|string',
        ]);

        SubmissionLetterModel::where('id', $id)->update([
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'NIK' => $request->NIK,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan' => $request->pendidikan,
            'agama' => $request->agama,
            'keperluan' => $request->keperluan,
            'no_hp' => $request->no_hp,
            'status' => $request->status,
        ]);

        $submission = SubmissionLetterModel::where('pengajuansuratpengantar.NIK', $request->NIK)
            ->leftJoin('warga', 'warga.NIK', '=', 'pengajuansuratpengantar.NIK')
            ->first();

        $message = '';
        if ($submission->status == 'selesai') {
            $message = 'Pengajuan edit data atas nama ' . $submission->nama . ' telah diterima.';
        } else {
            $message = 'Pengajuan edit data atas nama ' . $submission->nama . ' ditolak.';
        }

        return redirect('/submission-letter')->with('success', 'Data Surat Berhasil Diubah dan Pesan WhatsApp berhasil dikirim');
    }

    public function show(string $id)
    {
        $letter = SubmissionLetterModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Pengajuan Surat Pengantar',
            'list' => ['Home', 'Pengajuan', 'Proses']
        ];
        $page = (object)[
            'title' => 'Detail Pengajuan Surat Pengantar'
        ];
        return view('submission-letter.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'letter' => $letter,
        ]);
    }

    public function downloadWord($id)
    {
        $pengajuan = SubmissionLetterModel::findOrFail($id);

        $templateProcessor = new TemplateProcessor(storage_path('app/Templates/Pengantar.docx'));

        // Set data dari database ke dalam template
        $templateProcessor->setValue('nama', $pengajuan->nama);
        $templateProcessor->setValue('tempat_lahir', $pengajuan->tempat_lahir);
        $templateProcessor->setValue('tanggal_lahir', $pengajuan->tanggal_lahir);
        $templateProcessor->setValue('alamat', $pengajuan->alamat);
        $templateProcessor->setValue('NIK', $pengajuan->NIK);
        $templateProcessor->setValue('pekerjaan', $pengajuan->pekerjaan);
        $templateProcessor->setValue('pendidikan', $pengajuan->pendidikan);
        $templateProcessor->setValue('agama', $pengajuan->agama);
        $templateProcessor->setValue('keperluan', $pengajuan->keperluan);

        $fileName = 'surat_pengantar_' . $pengajuan->nama . '.docx';
        $templateProcessor->saveAs($fileName);

        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
// GRSNEK6ZNVNJRKQGRN2WNN7Y

<?php

namespace App\Http\Controllers;

use App\Models\SubmissionAddModel;
use App\Models\SubmissionLetterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SubmissionLetterController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Pengajuan Surat Pengantar',
            'list' => ['Home', 'Pengajuan Surat Pengantar']
        ];
        return view(
            'submission-letter.index',
            [
                'breadcrumb' => $breadcrumb
            ]
        );
    }

    public function list(Request $request)
    {
        $Submissions = SubmissionLetterModel::select('pengajuansuratpengantar.NIK', 'warga.nama', 'pengajuansuratpengantar.created_at', 'pengajuansuratpengantar.status')
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
                return date('Y-m-d H:i:s', strtotime($submission->created_at));
            })
            ->addColumn('aksi', function ($submission) {
                return '<a href="' . url('/submission-letter/' . $submission->NIK) . '" class="btn btn-info btn-sm">Detail</a>';
            })
            ->addColumn('status', function ($submission) {
                if ($submission->status == 'proses' && Auth::user()->level == 'admin') {
                    return '<a href="' . url('/submission-letter/' . $submission->NIK . '/proses') . '" class="btn btn-primary btn-sm">Proses</a> ';
                } else if ($submission->status == 'proses' && Auth::user()->level == 'superadmin') {
                    return '<p class="text-primary">Proses</p>';
                } else if ($submission->status == 'selesai') {
                    return '<p class="text-success">Selesai</p>';
                } else if ($submission->status == 'ditolak') {
                    return '<p class="text-danger">Ditolak</p>';
                }
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function proses(string $nik)
    {
        $letter = SubmissionLetterModel::where('pengajuansuratpengantar.NIK', $nik)
            ->leftJoin('warga', 'warga.NIK', '=', 'pengajuansuratpengantar.NIK')
            ->first();

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

    public function update(Request $request, string $NIK)
    {
        $request->validate([
            'NIK' => 'required|string|min:16|unique:warga,NIK,' . $NIK . ',NIK',
            'pekerjaan' => 'required|string',
            'pendidikan' => 'required|string',
            'keperluan' => 'required|string',
            'no_hp' => 'required|string',
            'status' => 'required|string',
        ]);

        SubmissionLetterModel::where('NIK', $NIK)->update([
            'pekerjaan' => $request->pekerjaan,
            'pendidikan' => $request->pendidikan,
            'keperluan' => $request->keperluan,
            'no_hp' => $request->no_hp,
            'status' => $request->status,
        ]);

        $submission = SubmissionLetterModel::where('pengajuansuratpengantar.NIK', $NIK)
            ->leftJoin('warga', 'warga.NIK', '=', 'pengajuansuratpengantar.NIK')
            ->first();

        $message = '';
        if ($submission->status == 'selesai') {
            $message = 'Pengajuan edit data atas nama ' . $submission->nama . ' telah diterima.';
        } else {
            $message = 'Pengajuan edit data atas nama ' . $submission->nama . ' ditolak.';
        }

        // Jika data berhasil diupdate, akan kembali ke halaman utama
        if ($submission) {
            // Kirim pesan ke WhatsApp menggunakan API dari Fonte
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => '+62 851-5653-0441',
                    // 'target' => $submission->no_hp,
                    'message' => $message,
                    'countryCode' => '62', // Ubah sesuai kode negara Anda
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: u6hZ_-54X2!u14_41aN9', // Ganti YOUR_API_TOKEN dengan token API Anda
                ),
            ));

            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
            }
            curl_close($curl);

            if (isset($error_msg)) {
                return redirect('/submission-letter')->with('error', 'Gagal mengirim pesan WhatsApp: ' . $error_msg);
            } else {
                return redirect('/submission-letter')->with('success', 'Data Surat Berhasil Diubah dan Pesan WhatsApp berhasil dikirim');
            }
        } else {
            return redirect('/submission-letter')->with('error', 'Gagal memperbarui data surat');
        }
    }



    public function show(string $nik)
    {
        $letter = SubmissionLetterModel::where('pengajuansuratpengantar.NIK', $nik)
            ->leftJoin('warga', 'warga.NIK', '=', 'pengajuansuratpengantar.NIK')
            ->first();

        $breadcrumb = (object)[
            'title' => 'Proses Pengajuan Surat Pengantar',
            'list' => ['Home', 'Pengajuan', 'Proses']
        ];
        $page = (object)[
            'title' => 'Proses Pengajuan Surat Pengantar'
        ];
        return view('submission-letter.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'letter' => $letter,
        ]);
    }
}

// GRSNEK6ZNVNJRKQGRN2WNN7Y
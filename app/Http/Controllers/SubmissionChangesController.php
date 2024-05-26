<?php

namespace App\Http\Controllers;

use App\Models\SubmissionChangesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $Submissions = SubmissionChangesModel::select('pengajuanEditDataWarga.NIK_pengajuan', 'warga.nama', 'pengajuanEditDataWarga.created_at', 'pengajuanEditDataWarga.status')
            ->join('warga', 'pengajuanEditDataWarga.NIK_pengajuan', '=', 'warga.NIK')
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
                return '<a href="' . url('/submission-changes/' . $submission->NIK_pengajuan) . '" class="btn btn-info btn-sm">Detail</a>';
            })
            ->addColumn('status', function ($submission) {
                if ($submission->status == 'proses' && Auth::user()->level == 'admin') {
                    return '<a href="' . url('/submission-changes/' . $submission->NIK_pengajuan . '/proses') . '" class="btn btn-primary btn-sm">Proses</a> ';
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
        $changes = SubmissionChangesModel::where('pengajuanEditDataWarga.NIK_pengajuan', $nik)
            ->leftJoin('warga', 'warga.NIK', '=', 'pengajuanEditDataWarga.NIK_pengajuan')
            ->first();

        $breadcrumb = (object)[
            'title' => 'Proses Pengajuan Edit Data Warga',
            'list' => ['Home', 'Pengajuan', 'Proses']
        ];
        $page = (object)[
            'title' => 'Proses Pengajuan Edit Data Warga'
        ];
        return view('resident.submission-changes.proses', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'changes' => $changes,
        ]);
    }

    public function update(Request $request, string $NIK)
    {
        $request->validate([
            'NIK_pengajuan' => 'required|string|min:16|unique:warga,NIK,' . $NIK . ',NIK',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required|string',
            'agama' => 'required|string',
            'status_pernikahan' => 'required|string',
            'keterangan' => 'required|string',
            'status' => 'required|string',
            'no_hp' => 'required|string',
        ]);

        SubmissionChangesModel::where('NIK_pengajuan', $NIK)->update([
            'NIK_pengajuan' => $request->NIK_pengajuan,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'no_hp' => $request->no_hp,
        ]);

        $submission = SubmissionChangesModel::where('pengajuanEditDataWarga.NIK_pengajuan', $NIK)
            ->leftJoin('warga', 'warga.NIK', '=', 'pengajuanEditDataWarga.NIK_pengajuan')
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
                    'target' => '+62 812-3360-5196',
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
                return redirect('/submission-changes')->with('error', 'Gagal mengirim pesan WhatsApp: ' . $error_msg);
            } else {
                return redirect('/submission-changes')->with('success', 'Data Pengajuan Berhasil Diubah dan Pesan WhatsApp berhasil dikirim');
            }
        } else {
            return redirect('/submission-changes')->with('error', 'Gagal memperbarui data Pengajuan');
        }
    }

    public function show(string $nik)
    {
        $changes = SubmissionChangesModel::where('pengajuanEditDataWarga.NIK_pengajuan', $nik)
            ->leftJoin('warga', 'warga.NIK', '=', 'pengajuanEditDataWarga.NIK_pengajuan')
            ->first();

        $breadcrumb = (object)[
            'title' => 'Show Pengajuan Edit Data Warga',
            'list' => ['Home', 'Pengajuan', 'Show']
        ];
        $page = (object)[
            'title' => 'Show Pengajuan Edit Data Warga'
        ];
        return view('resident.submission-changes.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'changes' => $changes,
        ]);
    }
}
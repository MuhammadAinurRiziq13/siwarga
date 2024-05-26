<?php

namespace App\Http\Controllers;

use App\Models\SubmissionAddModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SubmissionAddController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Pengajuan Keluarga Prasejahtera',
            'list' => ['Home', 'Pengajuan Prasejahtera']
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
        $Submissions = SubmissionAddModel::select('pengajuanprasejahtera.noKK', 'pengajuanprasejahtera.created_at', 'pengajuanprasejahtera.status', 'warga.nama as kepala_keluarga')
            ->leftJoin('keluarga', 'pengajuanprasejahtera.noKK', '=', 'keluarga.noKK')
            ->leftJoin('warga', function ($join) {
                $join->on('keluarga.noKK', '=', 'warga.noKK')
                    ->where('warga.status_keluarga', '=', 'kepala keluarga');
            })
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
                return '<a href="' . url('/submission-add/' . $submission->noKK) . '" class="btn btn-info btn-sm">Detail</a>';
            })
            ->addColumn('status', function ($submission) {
                if ($submission->status == 'proses' && Auth::user()->level == 'admin') {
                    return '<a href="' . url('/submission-add/' . $submission->noKK . '/proses') . '" class="btn btn-primary btn-sm">Proses</a> ';
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

    public function proses(string $noKK)
    {
        $add = SubmissionAddModel::select('pengajuanprasejahtera.*', 'warga.nama as kepala_keluarga')
            ->where('pengajuanprasejahtera.noKK', $noKK)
            ->leftJoin('keluarga', 'keluarga.noKK', '=', 'pengajuanprasejahtera.noKK')
            ->leftJoin('warga', function ($join) {
                $join->on('keluarga.noKK', '=', 'warga.noKK')
                    ->where('warga.status_keluarga', '=', 'kepala keluarga');
            })
            ->first();

        $breadcrumb = (object)[
            'title' => 'Proses Pengajuan Prasejahtera',
            'list' => ['Home', 'Pengajuan', 'Proses']
        ];
        $page = (object)[
            'title' => 'Proses Pengajuan Prasejahtera'
        ];
        return view('poor-family.submission-add.proses', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'add' => $add,
        ]);
    }

    public function update(Request $request, string $noKK)
    {
        $request->validate([
            'noKK' => 'required|string|min:16|unique:keluarga,noKK,' . $noKK . ',noKK',
            'jumlah_tanggungan' => 'required',
            'pendapatan' => 'required',
            'jumlah_kendaraan' => 'required',
            'luas_tanah' => 'required',
            'kondisi_rumah' => 'required',
            'status' => 'required',
            'no_hp' => 'required',
        ]);

        SubmissionAddModel::where('noKK', $noKK)->update([
            'noKK' => $request->noKK,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
            'pendapatan' => $request->pendapatan,
            'jumlah_kendaraan' => $request->jumlah_kendaraan,
            'luas_tanah' => $request->luas_tanah,
            'kondisi_rumah' => $request->kondisi_rumah,
            'status' => $request->status,
            'no_hp' => $request->no_hp,
        ]);

        $submission = SubmissionAddModel::select('pengajuanprasejahtera.*', 'warga.nama as kepala_keluarga')
            ->where('pengajuanprasejahtera.noKK', $noKK)
            ->leftJoin('keluarga', 'keluarga.noKK', '=', 'pengajuanprasejahtera.noKK')
            ->leftJoin('warga', function ($join) {
                $join->on('keluarga.noKK', '=', 'warga.noKK')
                    ->where('warga.status_keluarga', '=', 'kepala keluarga');
            })
            ->first();

        // $submission = SubmissionAddModel::where('noKK', $noKK)->first();

        $message = '';
        if ($submission->status == 'selesai') {
            $message = 'Pengajuan keluarga prasejahtera atas nama ' . $submission->kepala_keluarga . ' telah diterima.';
        } else {
            $message = 'Pengajuan keluarga prasejahtera atas nama ' . $submission->kepala_keluarga . ' ditolak.';
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
                return redirect('/submission-add')->with('error', 'Gagal mengirim pesan WhatsApp: ' . $error_msg);
            } else {
                return redirect('/submission-add')->with('success', 'Data Pengajuan Berhasil Diubah dan Pesan WhatsApp berhasil dikirim');
            }
        } else {
            return redirect('/submission-add')->with('error', 'Gagal memperbarui data Pengajuan');
        }
    }

    public function show(string $nokk)
    {
        $add = SubmissionAddModel::select('pengajuanprasejahtera.*', 'warga.nama as kepala_keluarga')
            ->where('pengajuanprasejahtera.noKK', $nokk)
            ->leftJoin('keluarga', 'keluarga.noKK', '=', 'pengajuanprasejahtera.noKK')
            ->leftJoin('warga', function ($join) {
                $join->on('keluarga.noKK', '=', 'warga.noKK')
                    ->where('warga.status_keluarga', '=', 'kepala keluarga');
            })
            ->first();


        $breadcrumb = (object)[
            'title' => 'Show Pengajuan Keluarga Prasejahtera',
            'list' => ['Home', 'Pengajuan', 'Prasejahtera']
        ];
        $page = (object)[
            'title' => 'Show Pengajuan Keluarga Prasejahtera'
        ];
        return view('poor-family.submission-add.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'add' => $add,
        ]);
    }
}

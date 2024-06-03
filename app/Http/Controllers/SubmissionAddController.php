<?php

namespace App\Http\Controllers;

use App\Models\BuktiAddModel;
use App\Models\BuktiPrasejahtera;
use App\Models\CriteriaPraSejahteraModel;
use App\Models\PoorFamilyModel;
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
        $Submissions = SubmissionAddModel::select('pengajuanprasejahtera.id', 'pengajuanprasejahtera.noKK', 'pengajuanprasejahtera.created_at', 'pengajuanprasejahtera.status', 'warga.nama as kepala_keluarga')
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
                return date('d-m-Y H:i:s', strtotime($submission->created_at));
            })
            ->addColumn('aksi', function ($submission) {
                return '<a href="' . url('/submission-add/' . $submission->id) . '" class="btn btn-info btn-sm">Detail</a>';
            })
            ->addColumn('status', function ($submission) {
                if ($submission->status == 'proses' && Auth::user()->level == 'admin') {
                    return '<a href="' . url('/submission-add/' . $submission->id . '/proses') . '" class="btn btn-primary btn-sm">Proses</a> ';
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

    public function proses(string $id)
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
        $criteria = CriteriaPraSejahteraModel::all();
        $bukti = BuktiAddModel::where('add', $id)->get();

        $breadcrumb = (object)[
            'title' => 'Show Pengajuan Edit Data Warga',
            'list' => ['Home', 'Pengajuan', 'Show']
        ];
        $page = (object)[
            'title' => 'Show Pengajuan Edit Data Warga'
        ];
        return view('poor-family.submission-add.proses', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'add' => $add,
            'nama' => $nama,
            'bukti' => $bukti,
            'criteria' => $criteria,
        ]);
    }

    public function update(Request $request, string $id)
    {
        if ($request->status == 'selesai') {
            // Ambil semua kriteria
            $criteria = CriteriaPraSejahteraModel::all();

            // Buat array kosong untuk data yang akan dibuat
            $dataToCreate = [];

            // Tambahkan 'noKK' ke dalam array data
            $dataToCreate['noKK'] = $request->noKK;

            // Loop melalui setiap kriteria dan tambahkan ke array data yang akan dibuat
            foreach ($criteria as $criterion) {
                $dataToCreate[$criterion->kode] = $request[$criterion->kode];
            }

            // Buat entri baru dengan data yang telah dikumpulkan
            $prasejahtera = PoorFamilyModel::create($dataToCreate);

            $bukti = BuktiAddModel::where('add', $request->id)->get();

            if ($bukti->isNotEmpty()) {
                foreach ($bukti as $buktiItem) {
                    $imageName = $buktiItem->nama_bukti; // Menggunakan nama file gambar yang sudah ada dari entri BuktiPrasejahtera

                    // Menyimpan nama file gambar sebagai bukti edit
                    BuktiPrasejahtera::create([
                        'bukti' => $prasejahtera->id,
                        'nama_bukti' => $imageName,
                    ]);
                }
            }
        }

        SubmissionAddModel::where('id', $id)->update([
            'status' => $request->status,
        ]);

        $submission = SubmissionAddModel::select('pengajuanprasejahtera.*', 'warga.nama as kepala_keluarga')
            ->where('pengajuanprasejahtera.noKK', $request->noKK)
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

        return redirect('/submission-add')->with('success', 'Data Pengajuan Berhasil Diubah dan Pesan WhatsApp berhasil dikirim');

        // Jika data berhasil diupdate, akan kembali ke halaman utama
        // if ($submission) {
        //     // Kirim pesan ke WhatsApp menggunakan API dari Fonte
        //     $curl = curl_init();

        //     curl_setopt_array($curl, array(
        //         CURLOPT_URL => 'https://api.fonnte.com/send',
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => '',
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 0,
        //         CURLOPT_FOLLOWLOCATION => true,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => 'POST',
        //         CURLOPT_POSTFIELDS => array(
        //             // 'target' => '+62 812-3360-5196',
        //             'target' => $submission->no_hp,
        //             'message' => $message,
        //             'countryCode' => '62', // Ubah sesuai kode negara Anda
        //         ),
        //         CURLOPT_HTTPHEADER => array(
        //             'Authorization: u6hZ_-54X2!u14_41aN9', // Ganti YOUR_API_TOKEN dengan token API Anda
        //         ),
        //     ));

        //     $response = curl_exec($curl);
        //     if (curl_errno($curl)) {
        //         $error_msg = curl_error($curl);
        //     }
        //     curl_close($curl);

        //     if (isset($error_msg)) {
        //         return redirect('/submission-add')->with('error', 'Gagal mengirim pesan WhatsApp: ' . $error_msg);
        //     } else {
        //         return redirect('/submission-add')->with('success', 'Data Pengajuan Berhasil Diubah dan Pesan WhatsApp berhasil dikirim');
        //     }
        // } else {
        //     return redirect('/submission-add')->with('error', 'Gagal memperbarui data Pengajuan');
        // }
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
        $criteria = CriteriaPraSejahteraModel::all();
        $bukti = BuktiAddModel::where('add', $id)->get();

        $breadcrumb = (object)[
            'title' => 'Show Pengajuan Edit Data Warga',
            'list' => ['Home', 'Pengajuan', 'Show']
        ];
        $page = (object)[
            'title' => 'Show Pengajuan Edit Data Warga'
        ];
        return view('poor-family.submission-add.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'add' => $add,
            'nama' => $nama,
            'bukti' => $bukti,
            'criteria' => $criteria,
        ]);
    }
}
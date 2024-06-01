<?php

namespace App\Http\Controllers;

use App\Models\ResidentModel;
use App\Models\SubmissionLetterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $Submissions = SubmissionLetterModel::select('pengajuansuratpengantar.id', 'pengajuansuratpengantar.NIK', 'warga.nama', 'pengajuansuratpengantar.created_at', 'pengajuansuratpengantar.status')
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
                return date('d-m-Y H:i:s', strtotime($submission->created_at));
            })
            ->addColumn('aksi', function ($submission) {
                $btn = '<a href="' . url('/submission-pengantar/' . $submission->id . '/show') . '" class="btn btn-info btn-sm mr-2"><i class="fas fa-eye"></i></a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/submission-pengantar/' . $submission->id) . '">'
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
        // $nokk = ResidentModel::where('NIK', $id)->pluck('noKK')->first();

        // $warga = ResidentModel::where('noKK', $nokk)->get();

        $breadcrumb = (object)[
            'title' => 'Tambah Warga',
            'list' => ['Home', 'Warga', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Warga Baru'
        ];

        return view('warga.submission-letter.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            // 'warga' => $warga,
        ]);
    }

    public function getFamilyData(Request $request, string $id)
    {
        // Mengambil nomor KK berdasarkan NIK yang diberikan
        $nokk = ResidentModel::where('NIK', $id)->pluck('noKK')->first();

        // Ambil data dari database dengan memfilter berdasarkan noKK
        $wargas = ResidentModel::where('noKK', $nokk)
            ->where('NIK', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        $data = [];
        // Looping untuk menyiapkan data yang akan dikirimkan ke Select2
        foreach ($wargas as $warga) {
            // Tambahkan NIK ke dalam data yang akan dikirimkan
            $data[] = [
                'id' => $warga->NIK,
                'text' => $warga->NIK
            ];
        }

        // Kirim data dalam format JSON
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'NIK' => 'required|string|min:16',
            'pekerjaan' => 'required|string',
            'pendidikan' => 'required|string',
            'keperluan' => 'required|string',
            'no_hp' => 'required|string',
        ]);

        SubmissionLetterModel::create([
            'NIK' => $request->NIK,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan' => $request->pendidikan,
            'keperluan' => $request->keperluan,
            'no_hp' => $request->no_hp,
            'status' => 'proses',
        ]);

        return redirect('/submission-pengantar/' . Auth::user()->username)->with('success', 'Pengajuan Surat Pengantar Berhasil Disimpan');
    }

    public function show(string $id)
    {
        $letter = SubmissionLetterModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Show Pengajuan Edit Data Warga',
            'list' => ['Home', 'Pengajuan', 'Show']
        ];
        $page = (object)[
            'title' => 'Show Pengajuan Edit Data Warga'
        ];
        return view('warga.submission-letter.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'letter' => $letter,
        ]);
    }

    public function destroy(string $id)
    {
        $check = SubmissionLetterModel::find($id);
        if (!$check) {
            redirect('/submission-pengantar/' . Auth::user()->username)->with('error', 'Data Pengajuan tidak ditemukan');
        }

        try {
            SubmissionLetterModel::destroy($id);
            return redirect('/submission-pengantar/' . Auth::user()->username)->with('success', 'Data Pengajuan Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi eror ketika menghapus data, redirect kembali ke halaman dengan membawa pesan eror
            return redirect('/submission-pengantar/' . Auth::user()->username)->with('error', 'Data Pengajuan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}

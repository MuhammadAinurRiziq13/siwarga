<?php

namespace App\Http\Controllers;

use App\Models\CriteriaPraSejahteraModel;
use App\Models\FamilyModel;
use App\Models\PoorFamilyModel;
use App\Models\ResidentModel;
use App\Exports\PoorFamiliesExport;
use App\Imports\PoorFamiliesImport;
use App\Models\BuktiPrasejahtera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Topsis;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class PoorFamilyController extends Controller
{
    public function index()
    {
        // Call the list method to retrieve ranked families
        $rankedFamilies = $this->list()->getData()['rankedFamilies'];

        $breadcrumb = (object)[
            'title' => 'Data Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera']
        ];

        return view('poor-family.index', [
            'breadcrumb' => $breadcrumb,
            'rankedFamilies' => $rankedFamilies
        ]);
    }

    public function calculate()
    {
        // Ambil data keluarga miskin dari model PoorFamilyModel
        $anggota = PoorFamilyModel::select(
            'keluargakurangmampu.noKK',
            'warga.nama',
            DB::raw('COUNT(warga2.noKK) as jumlah_anggota')
        )
            ->join('warga', function ($join) {
                $join->on('keluargakurangmampu.noKK', '=', 'warga.noKK')
                    ->where('warga.status_keluarga', '=', 'kepala keluarga');
            })
            ->leftJoin('warga as warga2', 'keluargakurangmampu.noKK', '=', 'warga2.noKK')
            ->groupBy('keluargakurangmampu.noKK', 'warga.nama')
            ->get();

        // Ambil data keluarga miskin untuk peringkat
        $families = PoorFamilyModel::select()
            ->join('warga', function ($join) {
                $join->on('keluargakurangmampu.noKK', '=', 'warga.noKK')
                    ->where('warga.status_keluarga', 'kepala keluarga');
            })
            ->orderBy('keluargakurangmampu.noKK') // Menambahkan pengurutan berdasarkan noKK
            ->get();

        // Ambil data kriteria dari model CriteriaPraSejahteraModel
        $criteriaData = CriteriaPraSejahteraModel::all();
        // Ambil nama kriteria, bobot, dan jenis kriteria dari data yang diambil
        $criteria = $criteriaData->pluck('nama')->toArray();
        $weights = $criteriaData->pluck('bobot')->toArray();
        $criteriaType = $criteriaData->pluck('jenis')->toArray();

        // Siapkan data untuk analisis TOPSIS
        $alternatives = $families->pluck('noKK')->toArray();

        $kode = $criteriaData->pluck('kode')->toArray();
        $decisionMatrix = $families->map(function ($family) use ($kode) {
            $values = [];
            foreach ($kode as $k) {
                $values[] = $family->$k;
            }
            return $values;
        })->toArray();

        // Langkah 1: Normalisasi bobot
        // $totalWeight = array_sum($weights);
        // $normalizedWeights = [];
        // foreach ($weights as $weight) {
        //     $normalizedWeight = $weight / $totalWeight;
        //     $normalizedWeights[] = $normalizedWeight;
        // }

        // Buat objek TOPSIS dan jalankan metode run()
        $topsis = new Topsis($alternatives, $criteria, $weights, $decisionMatrix, $criteriaType);
        $rankings = $topsis->run();
        $steps = $topsis->getSteps();

        // Atur peringkat keluarga miskin berdasarkan skor yang dihasilkan
        $rankedFamilies = collect($rankings)->map(function ($ranking) use ($families, $anggota) {
            $family = $families->firstWhere('noKK', $ranking['alternative']);
            $jumlah_anggota = $anggota->where('noKK', $ranking['alternative'])->first()->jumlah_anggota;

            // Temukan atau buat instansi PoorFamilyModel
            $poorFamily = PoorFamilyModel::firstOrNew(['noKK' => $family->noKK]);
            // Perbarui skor
            $poorFamily->score = round($ranking['score'], 4);
            // Simpan perubahan
            $poorFamily->save();

            return [
                'noKK' => $family->noKK,
                'nama' => $family->nama,
                'jumlah_anggota' => $jumlah_anggota,
                'score' => $ranking['score'],
            ];
        });

        // Atur breadcrumb untuk navigasi
        $breadcrumb = (object)[
            'title' => 'Data Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera']
        ];

        // Kirim data ke view untuk ditampilkan kepada pengguna
        return view('poor-family.calculate', [
            'breadcrumb' => $breadcrumb,
            'rankedFamilies' => $rankedFamilies,
            'steps' => $steps,
            'criteria' => $criteria,
            'alternatives' => $alternatives,
            'weight' => $weights
        ]);
    }


    public function list()
    {
        $families = PoorFamilyModel::select(
            'keluargakurangmampu.noKK',
            'warga.nama',
            DB::raw('COUNT(warga2.noKK) as jumlah_anggota'),
            DB::raw('MAX(keluargakurangmampu.score) as max_score')
        )
            ->join('warga', function ($join) {
                $join->on('keluargakurangmampu.noKK', '=', 'warga.noKK')
                    ->where('warga.status_keluarga', '=', 'kepala keluarga');
            })
            ->leftJoin('warga as warga2', 'keluargakurangmampu.noKK', '=', 'warga2.noKK')
            ->groupBy('keluargakurangmampu.noKK', 'warga.nama')
            ->orderBy('max_score', 'DESC')
            ->get();


        $breadcrumb = (object)[
            'title' => 'Data Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera']
        ];

        // Pass the data to the view
        return view('poor-family.index', [
            'breadcrumb' => $breadcrumb,
            'rankedFamilies' => $families
        ]);
    }


    public function show(string $id)
    {
        $poorFamily = PoorFamilyModel::where('noKK', $id)->first();
        $criteria = CriteriaPraSejahteraModel::all();
        $bukti = BuktiPrasejahtera::where('bukti', $poorFamily->id)->get();

        $breadcrumb = (object)[
            'title' => 'Data Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Keluarga Pra-Sejahtera'
        ];
        return view('poor-family.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'poorFamily' => $poorFamily,
            'criteria' => $criteria,
            'bukti' => $bukti,
        ]);
    }

    //tambah keluarga prasejahtera
    public function create()
    {
        $family = FamilyModel::all();
        $criteria = CriteriaPraSejahteraModel::all();
        $breadcrumb = (object)[
            'title' => '',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah Keluarga Pra-Sejahtera'
        ];

        return view('poor-family.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'family' => $family,
            'criteria' => $criteria
        ]);
    }

    //tambah kriteria
    public function createCriteria()
    {
        $breadcrumb = (object)[
            'title' => '',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah Criteria'
        ];

        return view('poor-family.criteria.createCriteria', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
        ]);
    }
    public function criteria()
    {
        $criteria = CriteriaPraSejahteraModel::all();
        $breadcrumb = (object)[
            'title' => 'Jenis Criteria',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Criteria']
        ];

        $page = (object)[
            'title' => 'Jenis Criteria'
        ];

        return view('poor-family.criteria.criteria', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'criteria' => $criteria,
        ]);
    }
    public function showCriteria(string $id)
    {
        // $poorFamily = PoorFamilyModel::where('noKK', $id)->first();
        $criteria = CriteriaPraSejahteraModel::where('id', $id)->first();
        $breadcrumb = (object)[
            'title' => 'Jenis Criteria',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Criteria']
        ];

        $page = (object)[
            'title' => 'Jenis Criteria'
        ];

        return view('poor-family.criteria.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'criteria' => $criteria,
        ]);
    }

    public function store(Request $request)
    {
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

        if ($request->hasFile('nama_bukti')) {
            foreach ($request->file('nama_bukti') as $image) {
                $imageName = $image->store('gallery'); // Menyimpan gambar dan mendapatkan nama file

                // Menyimpan nama file gambar sebagai bukti edit
                BuktiPrasejahtera::create([
                    'bukti' => $prasejahtera->id,
                    'nama_bukti' => $imageName,
                ]);
            }
        }

        return redirect('/poor-family')->with('success', 'Data Keluarga Pra-Sejahtera berhasil disimpan');
    }

    public function storeCriteria(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|unique:criteriaprasejahtera,kode',
        ]);
        // Tambahkan kolom baru dengan nama yang diambil dari $request->kode
        Schema::table('keluargakurangmampu', function (Blueprint $table) use ($request) {
            $table->string($request->kode)->nullable();
        });

        Schema::table('pengajuanprasejahtera', function (Blueprint $table) use ($request) {
            $table->string($request->kode)->nullable();
        });

        // Tambahkan data ke CriteriaPraSejahteraModel
        CriteriaPraSejahteraModel::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'jenis' => $request->jenis,
        ]);

        return redirect('/poor-family/criteria')->with('success', 'Data Kriteria berhasil disimpan');
    }

    public function edit(string $id)
    {
        $poorFamily = PoorFamilyModel::where('noKK', $id)->first();
        $family = FamilyModel::all();
        $criteria = CriteriaPraSejahteraModel::all();
        $bukti = BuktiPrasejahtera::where('bukti', $poorFamily->id)->get();
        $breadcrumb = (object)[
            'title' => '',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Edit']
        ];
        $page = (object)[
            'title' => 'Form Edit Keluarga Pra-Sejahtera'
        ];
        return view('poor-family.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'poorFamily' => $poorFamily,
            'family' => $family,
            'criteria' => $criteria,
            'bukti' => $bukti,
        ]);
    }

    public function editCriteria(string $id)
    {
        $criteria = CriteriaPraSejahteraModel::where('id', $id)->first();
        $breadcrumb = (object)[
            'title' => 'Edit Kriteria',
            'list' => ['Home', 'Kriteria', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Kriteria'
        ];
        return view('poor-family.criteria.editCriteria', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'criteria' => $criteria
        ]);
    }

    public function updateCriteria(Request $request, string $id)
    {
        // $criteria = CriteriaPraSejahteraModel::where('id', $id)->first();

        // Ubah nama kolom pada tabel 'keluargakurangmampu' dari $criteria->kode menjadi $request->kode
        // Schema::table('keluargakurangmampu', function (Blueprint $table) use ($criteria, $request) {
        //     $table->renameColumn($criteria->kode, $request->kode);
        // });

        CriteriaPraSejahteraModel::find($id)->update([
            // 'kode' => $request->kode,
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'jenis' => $request->jenis,
        ]);

        // Jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect('/poor-family/criteria')->with('success', 'Data Kriteria Berhasil Diubah');
    }

    public function update(Request $request, string $noKK)
    {
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

        $prasejahtera = PoorFamilyModel::where('noKK', $noKK)->first();

        if ($prasejahtera) {
            $prasejahtera->update($dataToCreate);

            if ($request->hasFile('nama_bukti')) {
                foreach ($request->file('nama_bukti') as $image) {
                    $imageName = $image->store('gallery'); // Menyimpan gambar dan mendapatkan nama file

                    // Menghapus entri bukti prasejahtera yang terkait
                    $oldBukti = $prasejahtera->buktiPrasejahteras()->first();
                    if ($oldBukti) {
                        Storage::delete($oldBukti->nama_bukti);
                        $prasejahtera->buktiPrasejahteras()->delete();
                    }
                    // Menyimpan nama file gambar sebagai bukti prasejahtera baru
                    $prasejahtera->buktiPrasejahteras()->create([
                        'nama_bukti' => $imageName,
                    ]);
                }
            }
        }


        // Jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect('/poor-family')->with('success', 'Data Keluarga Pra-Sejahtera Berhasil Diubah');
    }

    public function destroy(string $noKK)
    {
        $check = PoorFamilyModel::where('noKK', $noKK)->first();
        if (!$check) {
            return redirect('/poor-family')->with('error', 'Data Keluarga Pra-Sejahtera tidak ditemukan');
        }

        try {
            // Hapus data dari tabel anak (keluargaKurangMampu)
            PoorFamilyModel::where('noKK', $noKK)->delete();

            return redirect('/poor-family')->with('success', 'Data Keluarga Pra-Sejahtera berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/poor-family')->with('error', 'Data Keluarga Pra-Sejahtera gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function destroyCriteria(string $id)
    {
        $check = CriteriaPraSejahteraModel::where('id', $id)->first();
        if (!$check) {
            return redirect('/poor-family/criteria')->with('error', 'Data Kriteria tidak ditemukan');
        }

        try {
            // Hapus kolom dari tabel 'keluargakurangmampu' dengan nama yang diambil dari $check->kode
            Schema::table('keluargakurangmampu', function (Blueprint $table) use ($check) {
                $table->dropColumn($check->kode);
            });
            // Hapus kolom dari tabel 'pengajuan' dengan nama yang diambil dari $check->kode
            Schema::table('pengajuanprasejahtera', function (Blueprint $table) use ($check) {
                $table->dropColumn($check->kode);
            });
            // Hapus data dari tabel anak (keluargaKurangMampu)
            CriteriaPraSejahteraModel::where('id', $id)->delete();

            return redirect('/poor-family/criteria')->with('success', 'Data Kriteria berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/poor-family/criteria')->with('error', 'Data Kriteria gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function getFamilyData(Request $request)
    {
        $families = FamilyModel::leftJoin('keluargakurangmampu', 'keluarga.noKK', '=', 'keluargakurangmampu.noKK')
            ->select('keluarga.noKK')
            ->where('keluarga.noKK', 'LIKE', '%' . $request->input('q') . '%')
            ->whereNull('keluargakurangmampu.noKK')
            ->paginate(10);

        $data = [];
        // Looping untuk menyiapkan data yang akan dikirimkan ke Select2
        foreach ($families as $family) {
            // Konversi nilai noKK menjadi string jika perlu
            $noKK = (string)$family->noKK;
            $data[] = [
                'id' => $noKK,
                'text' => $noKK
            ];
        }

        // Kirim data dalam format JSON
        return response()->json($data);
    }

    public function getStatusKerja(Request $request)
    {
        $noKK = $request->input('noKK');
        $count = ResidentModel::where('noKK', $noKK)->where('status_kerja', 'Tidak Kerja')->count();
        return response()->json(['count' => $count]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        Excel::import(new PoorFamiliesImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimpor.');
    }

    public function export()
    {
        return Excel::download(new PoorFamiliesExport, 'poor_families.xlsx');
    }
}
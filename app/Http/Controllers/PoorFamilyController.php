<?php

namespace App\Http\Controllers;

use App\Models\CriteriaPraSejahteraModel;
use App\Models\FamilyModel;
use App\Models\PoorFamilyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Topsis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
    // Fetch the data
    $families = PoorFamilyModel::select('*'
        // 'keluargakurangmampu.noKK',
        // 'warga.nama',
        // 'keluargakurangmampu.jumlah_tanggungan',
        // 'keluargakurangmampu.pendapatan',
        // 'keluargakurangmampu.aset_kendaraan',
        // 'keluargakurangmampu.luas_tanah',
        // 'keluargakurangmampu.kondisi_rumah'
    )
        ->join('warga', function ($join) {
            $join->on('keluargakurangmampu.noKK', '=', 'warga.noKK')
                ->where('warga.status_keluarga', 'kepala keluarga');
        })
        ->get();

    // Prepare data for TOPSIS
    $alternatives = $families->pluck('noKK')->toArray();
    $decisionMatrix = $families->map(function ($family) {
        return [
            $this->convertTanggunganToScore($family->jumlah_tanggungan),
            $this->convertPendapatanToScore($family->pendapatan),
            $this->convertAsetKendaraanToScore($family->aset_kendaraan),
            $this->convertLuasTanahToScore($family->luas_tanah),
            $family->kondisi_rumah
        ];
    })->toArray();

    $criteria = ['Jumlah Tanggungan', 'Pendapatan', 'Aset Kendaraan', 'Luas Tanah', 'Kondisi Rumah'];
    $criteriaType = ['benefit', 'cost', 'cost', 'cost', 'cost'];
    $weights = [0.3, 0.25, 0.15, 0.1, 0.2];
    // $weights = [4, 2, 4, 3, 2];

    // Langkah Normalisasi bobot
    $totalWeight = array_sum($weights);
    $normalizedWeights = [];
    foreach ($weights as $weight) {
        $normalizedWeight = $weight / $totalWeight;
        $normalizedWeights[] = $normalizedWeight;
    }
    $topsis = new Topsis($alternatives, $criteria, $weights, $decisionMatrix, $criteriaType);
    $rankings = $topsis->run();
    $steps = $topsis->getSteps();
    // $noKKtabel = $families->firstWhere('noKK');

    $rankedFamilies = collect($rankings)->map(function ($ranking) use ($families) {
        $family = $families->firstWhere('noKK', $ranking['alternative']);
        return [
            'noKK' => $family->noKK,
            'nama' => $family->nama,
            'jumlah_anggota' => $family->jumlah_tanggungan,
            'pendapatan' => $family->pendapatan,
            'aset_kendaraan' => $family->aset_kendaraan,
            'luas_tanah' => $family->luas_tanah,
            'kondisi_rumah' => $family->kondisi_rumah,
            'score' => $ranking['score']
        ];
    });

    $breadcrumb = (object)[
        'title' => 'Data Keluarga Pra-Sejahtera',
        'list' => ['Home', 'Keluarga Pra-Sejahtera']
    ];

    // Pass the data to the view
    return view('poor-family.calculate', [
        'breadcrumb' => $breadcrumb,
        'rankedFamilies' => $rankedFamilies,
        'steps' => $steps,
        'criteria' => $criteria,
        'alternatives' => $alternatives,
        'weight' => $normalizedWeights
    ]);
}


    private function convertTanggunganToScore($jumlahTanggungan)
    {
        if ($jumlahTanggungan > 7) {
            return 5;
        } elseif ($jumlahTanggungan >= 6) {
            return 4;
        } elseif ($jumlahTanggungan >= 4) {
            return 3;
        } elseif ($jumlahTanggungan >= 2) {
            return 2;
        } else {
            return 1;
        }
    }

    private function convertPendapatanToScore($pendapatan)
    {
        if ($pendapatan > 2000000) {
            return 5;
        } elseif ($pendapatan > 1500000 && $pendapatan <= 2000000) {
            return 4;
        } elseif ($pendapatan > 1000000 && $pendapatan <= 1500000) {
            return 3;
        } elseif ($pendapatan > 750000 && $pendapatan <= 1000000) {
            return 2;
        } else {
            return 1;
        }
    }
    private function convertAsetKendaraanToScore($aset)
    {
        if ($aset < 750000) {
            return 5;
        } elseif ($aset >= 750000 && $aset < 1000000) {
            return 4;
        } elseif ($aset >= 1000000 && $aset < 1500000) {
            return 3;
        } elseif ($aset >= 1500000 && $aset < 2000000) {
            return 2;
        } else {
            return 1;
        }
    }
    private function convertLuasTanahToScore($luas)
    {
        if ($luas > 50) {
            return 5;
        } elseif ($luas > 40 && $luas <= 50) {
            return 4;
        } elseif ($luas > 30 && $luas <= 40) {
            return 3;
        } elseif ($luas > 20 && $luas <= 30) {
            return 2;
        } else {
            return 1;
        }
    }

    public function list()
    {
        $families = PoorFamilyModel::select(
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
        ]);
    }

    public function create()
    {
        $family = FamilyModel::all();
        $breadcrumb = (object)[
            'title' => 'Tambah Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Keluarga Pra-Sejahtera Baru'
        ];

        return view('poor-family.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'family' => $family,
        ]);
    }

    public function createCriteria()
    {
        // $family = FamilyModel::all();
        $breadcrumb = (object)[
            'title' => 'Tambah Criteria',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Criteria'
        ];

        return view('poor-family.createCriteria', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            // 'family' => $family,
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
        $criteria = CriteriaPraSejahteraModel::where('id',$id)->first();
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
        $request->validate([
            'noKK' => 'required',
            'jumlah_tanggungan' => 'required',
            'pendapatan' => 'required',
            'aset_kendaraan' => 'required',
            'luas_tanah' => 'required',
            'kondisi_rumah' => 'required',
        ]);


        // Fungsi eloquent untuk menambah data
        PoorFamilyModel::create([
            'noKK' => $request->noKK,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
            'pendapatan' => $request->pendapatan,
            'aset_kendaraan' => $request->aset_kendaraan,
            'luas_tanah' => $request->luas_tanah,
            'kondisi_rumah' => $request->kondisi_rumah,
        ]);

        return redirect('/poor-family')->with('success', 'Data Keluarga Pra-Sejahtera berhasil disimpan');
    }

    public function edit(string $id)
    {
        $poorFamily = PoorFamilyModel::where('noKK', $id)->first();
        $family = FamilyModel::all();
        $breadcrumb = (object)[
            'title' => 'Edit Keluarga Pra-Sejahtera',
            'list' => ['Home', 'Keluarga Pra-Sejahtera', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Keluarga Pra-Sejahtera'
        ];
        return view('poor-family.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'poorFamily' => $poorFamily,
            'family' => $family,
        ]);
    }

    public function update(Request $request, string $noKK)
    {
        $request->validate([
            'noKK' => 'required',
            'jumlah_tanggungan' => 'required',
            'pendapatan' => 'required',
            'aset_kendaraan' => 'required',
            'luas_tanah' => 'required',
            'kondisi_rumah' => 'required',
        ]);

        // Update data Keluarga Pra-Sejahtera
        PoorFamilyModel::where('noKK', $noKK)->update([
            'noKK' => $request->noKK,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
            'pendapatan' => $request->pendapatan,
            'aset_kendaraan' => $request->aset_kendaraan,
            'luas_tanah' => $request->luas_tanah,
            'kondisi_rumah' => $request->kondisi_rumah,
        ]);

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
}

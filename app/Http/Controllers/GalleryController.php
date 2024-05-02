<?php

namespace App\Http\Controllers;

use App\Models\GalleryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Galery',
            'list' => ['Home', 'Gallery']
        ];
        return view(
            'gallery.index',
            [
                'breadcrumb' => $breadcrumb
            ]
        );
    }

    // Ambil data Barang dalam bentuk json untuk datatables 
    public function list(Request $request)
    {
        $Gallery = GalleryModel::select('id_galeri', 'nama_foto', 'judul', 'tanggal_kegiatan', 'keterangan');
        return DataTables::of($Gallery)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($gallery) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/gallery/' . $gallery->id_galeri) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';
                $btn .= '<a href="' . url('/gallery/' . $gallery->id_galeri . '/edit') . '" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/gallery/' . $gallery->id_galeri) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');"><i class="fas fa-trash-alt"></i></button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Gallery',
            'list' => ['Home', 'Gallery', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Gallery Baru'
        ];

        return view('gallery.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_foto' => 'image|file|max:1024',
            'judul' => 'required|string',
            'tanggal_kegiatan' => 'required',
            'keterangan' => 'required|string',
        ]);

        if ($request->file('nama_foto')) {
            $validatedData['nama_foto'] = $request->file('nama_foto')->store('gallery');
        }

        //fungsi eloquent untuk menambah data
        GalleryModel::create($validatedData);

        return redirect('/gallery')->with('success', 'Data warga berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gallery = GalleryModel::find($id);
        $breadcrumb = (object)[
            'title' => 'Data Galeri',
            'list' => ['Home', 'Galeri', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Galeri'
        ];
        return view('gallery.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'gallery' => $gallery,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = GalleryModel::find($id);
        $breadcrumb = (object)[
            'title' => 'Edit Galeri',
            'list' => ['Home', 'Galeri', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Galeri'
        ];
        return view('gallery.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'gallery' => $gallery,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nama_foto' => 'image|file|max:1024',
            'judul' => 'required|string',
            'tanggal_kegiatan' => 'required',
            'keterangan' => 'required|string',
        ]);

        if ($request->file('nama_foto')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['nama_foto'] = $request->file('nama_foto')->store('gallery');
        }

        GalleryModel::find($id)->update($validatedData);

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect('/gallery')->with('success', 'Data Galeri Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = GalleryModel::find($id);
        if (!$check) {
            redirect('/gallery')->with('error', 'Data galeri tidak ditemukan');
        }

        try {
            GalleryModel::destroy($id);
            Storage::delete($id);
            return redirect('/gallery')->with('success', 'Data galeri berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi eror ketika menghapus data, redirect kembali ke halaman dengan membawa pesan eror
            return redirect('/gallery')->with('error', 'Data galeri gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
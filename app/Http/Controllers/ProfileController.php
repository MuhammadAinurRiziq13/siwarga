<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index(string $id)
    {
        $user = User::find($id);

        $breadcrumb = (object)[
            'title' => '',
            'list' => ['Home', 'Family']
        ];

        $page = (object)[
            'title' => 'Daftar Keluarga yang terdaftar dalam sistem'
        ];

        return view(
            'profile.index',
            [
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'user' => $user,
            ]
        );
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'username' => 'image|file|max:1024',
            'password' => 'required|string',
            'nama' => 'required|string',
        ]);

        if ($request->file('foto')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['foto'] = $request->file('foto')->store('gallery');
        }

        // Update data warga
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::find($id)->update($validatedData);


        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect('/profile/' . $id)->with('success', 'Data Galeri Berhasil Diubah');
    }
}

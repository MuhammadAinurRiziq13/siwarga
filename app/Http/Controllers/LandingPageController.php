<?php

namespace App\Http\Controllers;

use App\Models\FamilyModel;
use App\Models\GalleryModel;
use App\Models\ResidentModel;
use App\Models\TemporaryResident;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(){
        $resident = ResidentModel::count('NIK');
        $family = FamilyModel::count('noKK');
        $temporary = TemporaryResident::count('NIK_warga_sementara');

        $toddlers = ResidentModel::query();
        $toddlers->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 5');
        $toddlers = $toddlers->count('NIK');

        $elder = ResidentModel::query();
        $elder->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 60');
        $elder = $elder->count('NIK');

        $gallery = GalleryModel::select('id_galeri', 'nama_foto', 'judul', 'tanggal_kegiatan', 'keterangan')->get();

        $landingPage = (object) [
            'resident' => $resident,
            'family' => $family,
            'temporary' => $temporary,
            'toddlers' => $toddlers,
            'elder' => $elder,
            'gallery' => $gallery,
        ];

        return view('landing-page.home', ['landingPage' => $landingPage]);
    }
}

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MigrantController;
use App\Http\Controllers\PoorFamilyController;
use App\Http\Controllers\PoorResidentController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\SubmissionAddController;
use App\Http\Controllers\SubmissionChangesController;
use App\Models\PoorFamilyModel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing-page.home', [
        "title" => "Home"
    ]);
});

Route::get('/login', [LoginController::class, 'index']);
Route::Post('/login', [LoginController::class, 'authenticate']);

Route::get('/logout', [LoginController::class, 'logout']);


Route::get('/dashboard', [DashboardController::class, 'index']);
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth:admin');
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth:superadmin');
// Route::get('/family', [FamilyController::class, 'index']);

Route::group(['prefix' => 'resident'], function () {
    Route::get('/', [ResidentController::class, 'index']);        //menampilkan halaman awal
    Route::post('/list', [ResidentController::class, 'list']);    //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [ResidentController::class, 'create']);
    Route::post('/', [ResidentController::class, 'store']);       //menyimpan data user baru
    Route::get('/{id}', [ResidentController::class, 'show']);
    Route::get('/{id}/edit', [ResidentController::class, 'edit']);
    Route::put('/{id}', [ResidentController::class, 'update']);
    Route::delete('/{id}', [ResidentController::class, 'destroy']);
});

Route::group(['prefix' => 'submission-changes'], function () {
    Route::get('/', [SubmissionChangesController::class, 'index']);        //menampilkan halaman awal
    Route::post('/list', [SubmissionChangesController::class, 'list']);    //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [SubmissionChangesController::class, 'create']);
    Route::post('/', [SubmissionChangesController::class, 'store']);       //menyimpan data user baru
    Route::get('/{id}', [SubmissionChangesController::class, 'show']);
    Route::get('/{id}/edit', [SubmissionChangesController::class, 'edit']);
    Route::put('/{id}', [SubmissionChangesController::class, 'update']);
    Route::delete('/{id}', [SubmissionChangesController::class, 'destroy']);
});

Route::group(['prefix' => 'family'], function () {
    Route::get('/', [FamilyController::class, 'index']);        //menampilkan halaman awal
    Route::post('/list', [FamilyController::class, 'list']);    //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [FamilyController::class, 'create']);
    Route::post('/', [FamilyController::class, 'store']);       //menyimpan data user baru
    Route::get('/{id}', [FamilyController::class, 'show']);
    Route::get('/{id}/edit', [FamilyController::class, 'edit']);
    Route::put('/{id}', [FamilyController::class, 'update']);
    Route::delete('/{id}', [FamilyController::class, 'destroy']);
});

Route::group(['prefix' => 'poor-family'], function () {
    Route::get('/', [PoorFamilyController::class, 'index']);        //menampilkan halaman awal
    Route::post('/list', [PoorFamilyController::class, 'list']);    //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [PoorFamilyController::class, 'create']);
    Route::post('/', [PoorFamilyController::class, 'store']);       //menyimpan data user baru
    Route::get('/{id}', [PoorFamilyController::class, 'show']);
    Route::get('/{id}/edit', [PoorFamilyController::class, 'edit']);
    Route::put('/{id}', [PoorFamilyController::class, 'update']);
    Route::delete('/{id}', [PoorFamilyController::class, 'destroy']);
});

Route::group(['prefix' => 'submission-add'], function () {
    Route::get('/', [SubmissionAddController::class, 'index']);        //menampilkan halaman awal
    Route::post('/list', [SubmissionAddController::class, 'list']);    //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [SubmissionAddController::class, 'create']);
    Route::post('/', [SubmissionAddController::class, 'store']);       //menyimpan data user baru
    Route::get('/{id}', [SubmissionAddController::class, 'show']);
    Route::get('/{id}/edit', [SubmissionAddController::class, 'edit']);
    Route::put('/{id}', [SubmissionAddController::class, 'update']);
    Route::delete('/{id}', [SubmissionAddController::class, 'destroy']);
});

Route::group(['prefix' => 'gallery'], function () {
    Route::get('/', [GalleryController::class, 'index']);        //menampilkan halaman awal
    Route::post('/list', [GalleryController::class, 'list']);    //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [GalleryController::class, 'create']);
    Route::post('/', [GalleryController::class, 'store']);       //menyimpan data user baru
    Route::get('/{id}', [GalleryController::class, 'show']);
    Route::get('/{id}/edit', [GalleryController::class, 'edit']);
    Route::put('/{id}', [GalleryController::class, 'update']);
    Route::delete('/{id}', [GalleryController::class, 'destroy']);
});

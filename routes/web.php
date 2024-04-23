<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MigrantController;
use App\Http\Controllers\PoorResidentController;
use App\Http\Controllers\ResidentController;
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
Route::get('/migrant', [MigrantController::class, 'index']);
Route::get('/poor-resident', [PoorResidentController::class, 'index']);
Route::get('/gallery', [GalleryController::class, 'index']);

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
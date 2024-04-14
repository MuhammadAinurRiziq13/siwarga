<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
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


Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/resident', [ResidentController::class, 'index']);
Route::get('/migrant', [MigrantController::class, 'index']);
Route::get('/poor-resident', [PoorResidentController::class, 'index']);
Route::get('/gallery', [GalleryController::class, 'index']);
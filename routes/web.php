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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::Post('/login', [LoginController::class, 'authenticate']);

Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:admin');
// });
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:admin');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);
});

// Route::group(['prefix' => 'family', 'middleware' => ['auth']], function () {
//     Route::get('/', [FamilyController::class, 'index']);
//     Route::post('/list', [FamilyController::class, 'list']);
//     Route::get('/{id}', [FamilyController::class, 'show']);
//     Route::get('/create', [FamilyController::class, 'create'])->middleware('role:admin');
//     Route::post('/', [FamilyController::class, 'store'])->middleware('role:admin');
//     Route::get('/{id}/edit', [FamilyController::class, 'edit'])->middleware('role:admin');
//     Route::put('/{id}', [FamilyController::class, 'update'])->middleware('role:admin');
//     Route::delete('/{id}', [FamilyController::class, 'destroy'])->middleware('role:admin');
// });

Route::prefix('family')->middleware('auth')->group(function () {
    Route::get('/', [FamilyController::class, 'index']);
    Route::post('/list', [FamilyController::class, 'list']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [FamilyController::class, 'create']);
        Route::post('/', [FamilyController::class, 'store']);
        Route::get('/{id}/edit', [FamilyController::class, 'edit']);
        Route::put('/{id}', [FamilyController::class, 'update']);
        Route::delete('/{id}', [FamilyController::class, 'destroy']);
    });
    Route::get('/{id}', [FamilyController::class, 'show']);
});

Route::prefix('resident')->middleware('auth')->group(function () {
    Route::get('/', [ResidentController::class, 'index']);
    Route::post('/list', [ResidentController::class, 'list']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [ResidentController::class, 'create']);
        Route::post('/', [ResidentController::class, 'store']);
        Route::get('/{id}/edit', [ResidentController::class, 'edit']);
        Route::put('/{id}', [ResidentController::class, 'update']);
        Route::delete('/{id}', [ResidentController::class, 'destroy']);
    });
    Route::get('/{id}', [ResidentController::class, 'show']);
});

Route::prefix('submission-changes')->middleware('auth')->group(function () {
    Route::get('/', [SubmissionChangesController::class, 'index']);
    Route::post('/list', [SubmissionChangesController::class, 'list']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [SubmissionChangesController::class, 'create']);
        Route::post('/', [SubmissionChangesController::class, 'store']);
        Route::get('/{id}/edit', [SubmissionChangesController::class, 'edit']);
        Route::put('/{id}', [SubmissionChangesController::class, 'update']);
        Route::delete('/{id}', [SubmissionChangesController::class, 'destroy']);
    });
    Route::get('/{id}', [SubmissionChangesController::class, 'show']);
});

Route::prefix('poor-family')->middleware('auth')->group(function () {
    Route::get('/', [PoorFamilyController::class, 'index']);
    Route::post('/list', [PoorFamilyController::class, 'list']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [PoorFamilyController::class, 'create']);
        Route::post('/', [PoorFamilyController::class, 'store']);
        Route::get('/{id}/edit', [PoorFamilyController::class, 'edit']);
        Route::put('/{id}', [PoorFamilyController::class, 'update']);
        Route::delete('/{id}', [PoorFamilyController::class, 'destroy']);
    });
    Route::get('/{id}', [PoorFamilyController::class, 'show']);
});

Route::prefix('submission-add')->middleware('auth')->group(function () {
    Route::get('/', [SubmissionAddController::class, 'index']);
    Route::post('/list', [SubmissionAddController::class, 'list']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [SubmissionAddController::class, 'create']);
        Route::post('/', [SubmissionAddController::class, 'store']);
        Route::get('/{id}/edit', [SubmissionAddController::class, 'edit']);
        Route::put('/{id}', [SubmissionAddController::class, 'update']);
        Route::delete('/{id}', [SubmissionAddController::class, 'destroy']);
    });
    Route::get('/{id}', [SubmissionAddController::class, 'show']);
});

Route::prefix('gallery')->middleware('auth')->group(function () {
    Route::get('/', [GalleryController::class, 'index']);
    Route::post('/list', [GalleryController::class, 'list']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [GalleryController::class, 'create']);
        Route::post('/', [GalleryController::class, 'store']);
        Route::get('/{id}/edit', [GalleryController::class, 'edit']);
        Route::put('/{id}', [GalleryController::class, 'update']);
        Route::delete('/{id}', [GalleryController::class, 'destroy']);
    });
    Route::get('/{id}', [GalleryController::class, 'show']);
});
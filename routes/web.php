<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MigrantController;
use App\Http\Controllers\PoorFamilyController;
use App\Http\Controllers\PoorResidentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ResidentEditController;
use App\Http\Controllers\SubmissionAddController;
use App\Http\Controllers\SubmissionChangesController;
use App\Http\Controllers\SubmissionLetterController;
use App\Http\Controllers\SubmissionPengantarController;
use App\Http\Controllers\SubmissionPrasejahteraController;
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
//ajax
Route::get('/noKK', [ResidentController::class, 'getFamilyData']);
Route::get('/noKK1', [PoorFamilyController::class, 'getFamilyData']);
Route::get('/keluarga/{id}', [DashboardController::class, 'getFamilyData']);
Route::get('/warga/{id}', [SubmissionPengantarController::class, 'getFamilyData']);
Route::get('/get-status-kerja', [PoorFamilyController::class, 'getStatusKerja']);

Route::get('/', [LandingPageController::class, 'index']);

// Route::get('/', function () {
//     return view('landing-page.home', [
//         "title" => "Home"
//     ]);
// });

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::Post('/login', [LoginController::class, 'authenticate']);

Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:admin');
// });
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:admin');

// Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
//     Route::get('/', [DashboardController::class, 'index']);
// });
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
});
// Route::prefix('dashboard')->middleware('auth')->group(function () {
//     Route::get('/{id}', [DashboardController::class, 'index2']);
// });

Route::prefix('family')->middleware('auth')->group(function () {
    Route::get('/', [FamilyController::class, 'index']);
    Route::post('/list', [FamilyController::class, 'list']);
    Route::post('/import', [FamilyController::class, 'import'])->name('family.import');
    Route::get('/export', [FamilyController::class, 'export'])->name('family.export');


    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [FamilyController::class, 'create']);
        Route::post('/', [FamilyController::class, 'store']);
        Route::get('/{id}/edit', [FamilyController::class, 'edit']);
        Route::put('/{id}', [FamilyController::class, 'update']);
        Route::delete('/{id}', [FamilyController::class, 'destroy']);
        Route::get('/{id}/create', [FamilyController::class, 'create1']);
        Route::post('/resident', [FamilyController::class, 'store1']);
    });
    Route::get('/{id}', [FamilyController::class, 'show']);
});

Route::prefix('resident')->middleware('auth')->group(function () {
    Route::get('/', [ResidentController::class, 'index']);
    Route::post('/list', [ResidentController::class, 'list']);
    Route::post('/import', [ResidentController::class, 'import'])->name('resident.import');
    Route::get('/export', [ResidentController::class, 'export'])->name('resident.export');

    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [ResidentController::class, 'create']);
        Route::post('/', [ResidentController::class, 'store']);
        Route::get('/{id}/edit', [ResidentController::class, 'edit']);
        Route::put('/{id}', [ResidentController::class, 'update']);
        Route::delete('/{id}', [ResidentController::class, 'destroy']);
    });
    Route::get('/{id}', [ResidentController::class, 'show']);
});

Route::prefix('poor-family')->middleware('auth')->group(function () {
    Route::get('/', [PoorFamilyController::class, 'index']);
    Route::post('/list', [PoorFamilyController::class, 'list']);
    Route::get('/calculate', [PoorFamilyController::class, 'calculate']);
    Route::get('/criteria', [PoorFamilyController::class, 'criteria']);
    Route::get('/createCriteria', [PoorFamilyController::class, 'createCriteria']);
    Route::post('/storeCriteria', [PoorFamilyController::class, 'storeCriteria']);
    Route::get('/{id}/edit-criteria', [PoorFamilyController::class, 'EditCriteria']);
    Route::post('/storeCriteria/{id}', [PoorFamilyController::class, 'updateCriteria']);
    Route::post('/import', [PoorFamilyController::class, 'import'])->name('poor-family.import');
    Route::get('/export', [PoorFamilyController::class, 'export'])->name('poor-family.export');

    Route::middleware('role:admin')->group(function () {
        Route::get('/create', [PoorFamilyController::class, 'create']);
        Route::post('/', [PoorFamilyController::class, 'store']);
        Route::get('/{id}/edit', [PoorFamilyController::class, 'edit']);
        Route::put('/{id}', [PoorFamilyController::class, 'update']);
        Route::delete('/{id}', [PoorFamilyController::class, 'destroy']);
        Route::delete('/delete-criteria/{id}', [PoorFamilyController::class, 'destroyCriteria']);
    });
    Route::get('/{id}', [PoorFamilyController::class, 'show']);
});

Route::prefix('submission-changes')->middleware('auth')->group(function () {
    Route::get('/', [SubmissionChangesController::class, 'index']);
    Route::post('/list', [SubmissionChangesController::class, 'list']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/{id}/proses', [SubmissionChangesController::class, 'proses']);
        Route::put('/{id}', [SubmissionChangesController::class, 'update']);
        Route::delete('/{id}', [SubmissionChangesController::class, 'destroy']);
    });
    Route::get('/{id}', [SubmissionChangesController::class, 'show']);
});

Route::prefix('submission-add')->middleware('auth')->group(function () {
    Route::get('/', [SubmissionAddController::class, 'index']);
    Route::post('/list', [SubmissionAddController::class, 'list']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/{id}/proses', [SubmissionAddController::class, 'proses']);
        Route::put('/{id}', [SubmissionAddController::class, 'update']);
        Route::delete('/{id}', [SubmissionAddController::class, 'destroy']);
    });
    Route::get('/{id}', [SubmissionAddController::class, 'show']);
});

Route::prefix('submission-letter')->middleware('auth')->group(function () {
    Route::get('/', [SubmissionLetterController::class, 'index']);
    Route::post('/list', [SubmissionLetterController::class, 'list']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/{id}/proses', [SubmissionLetterController::class, 'proses']);
        Route::put('/{id}', [SubmissionLetterController::class, 'update']);
        Route::delete('/{id}', [SubmissionLetterController::class, 'destroy']);
        Route::get('/download-word/{id}', [SubmissionLetterController::class, 'downloadWord'])->name('download-word');
    });
    Route::get('/{id}', [SubmissionLetterController::class, 'show']);
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

Route::prefix('resident-edit')->middleware('auth')->group(function () {
    // Route::get('/', [GalleryController::class, 'index']);
    Route::get('/{id}', [ResidentEditController::class, 'index']);
    Route::post('/list', [ResidentEditController::class, 'list']);
    // Route::get('/create', [ResidentEditController::class, 'create']);
    Route::post('/', [ResidentEditController::class, 'store']);
    Route::get('/{id}/edit', [ResidentEditController::class, 'edit']);
    Route::get('/{id}/show', [ResidentEditController::class, 'show']);
    Route::get('/{id}/show1', [ResidentEditController::class, 'show1']);
    // Route::put('/{id}', [ResidentEditController::class, 'update']);
    Route::delete('/{id}', [ResidentEditController::class, 'destroy']);
    // Route::get('/{id}', [GalleryController::class, 'show']);
});

Route::prefix('submission-prasejahtera')->middleware('auth')->group(function () {
    Route::get('/{id}', [SubmissionPrasejahteraController::class, 'index']);
    Route::post('/list', [SubmissionPrasejahteraController::class, 'list']);
    Route::get('/{id}/create', [SubmissionPrasejahteraController::class, 'create']);
    Route::post('/', [SubmissionPrasejahteraController::class, 'store']);
    Route::get('/{id}/show', [SubmissionPrasejahteraController::class, 'show']);
    Route::delete('/{id}', [SubmissionPrasejahteraController::class, 'destroy']);
    // Route::post('/', [SubmissionPrasejahteraController::class, 'store']);
    // Route::get('/{id}/edit', [SubmissionPrasejahteraController::class, 'edit']);
    // Route::put('/{id}', [SubmissionPrasejahteraController::class, 'update']);
    // Route::delete('/{id}', [SubmissionPrasejahteraController::class, 'destroy']);
    // Route::get('/{id}', [GalleryController::class, 'show']);
});

Route::prefix('submission-pengantar')->middleware('auth')->group(function () {
    Route::get('/{id}', [SubmissionPengantarController::class, 'index']);
    Route::get('/{id}/create', [SubmissionPengantarController::class, 'create']);
    Route::post('/list', [SubmissionPengantarController::class, 'list']);
    Route::post('/', [SubmissionPengantarController::class, 'store']);
    Route::get('/{id}/show', [SubmissionPengantarController::class, 'show']);
    Route::delete('/{id}', [SubmissionPengantarController::class, 'destroy']);
});

Route::get('/getData', [SubmissionPengantarController::class, 'getUserData']);

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/{id}', [ProfileController::class, 'index']);
    Route::put('/{id}', [ProfileController::class, 'update']);
});

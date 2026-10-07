<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PublicAfdelingController;
use App\Http\Controllers\Public\PublicReportController;
use App\Http\Controllers\Internal\DashboardController;
use App\Http\Controllers\Internal\AfdelingController;
use App\Http\Controllers\Internal\BlockController;
use App\Http\Controllers\Internal\WorkerController;
use App\Http\Controllers\Internal\ActivityController;
use App\Http\Controllers\Internal\HarvestController;
use App\Http\Controllers\Internal\TargetController;
use App\Http\Controllers\Internal\AttendanceController;
use App\Http\Controllers\Internal\ReportController;
use App\Http\Controllers\Internal\UserController;
use Illuminate\Support\Facades\Route;

// ============================================================
// PUBLIC ROUTES (no auth required)
// ============================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/peta', [PublicAfdelingController::class, 'map'])->name('map');
Route::get('/afdeling/{afdeling}', [PublicAfdelingController::class, 'show'])->name('afdeling.show');
Route::get('/laporan', [PublicReportController::class, 'index'])->name('reports.public');
Route::get('/laporan/{report}', [PublicReportController::class, 'show'])->name('reports.public.show');

// ============================================================
// AUTH ROUTES
// ============================================================
Route::get('/login', [LoginController::class, 'showForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================================
// INTERNAL ROUTES (auth required)
// ============================================================
Route::prefix('internal')->name('internal.')->middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Afdeling (admin only)
    Route::resource('afdelings', AfdelingController::class)->middleware('role:admin');

    // Blocks (admin only)
    Route::resource('blocks', BlockController::class)->middleware('role:admin');

    // Workers (admin only)
    Route::resource('workers', WorkerController::class)->middleware('role:admin');

    // Activities (mandor, asisten, admin)
    Route::resource('activities', ActivityController::class)->middleware('role:admin,mandor,asisten');

    // Harvests (mandor, asisten, admin)
    Route::resource('harvests', HarvestController::class)->middleware('role:admin,mandor,asisten');

    // Targets (asisten, admin)
    Route::resource('targets', TargetController::class)->middleware('role:admin,asisten');

    // Attendance (mandor, asisten, admin)
    Route::resource('attendance', AttendanceController::class)->middleware('role:admin,mandor,asisten');

    // Reports (asisten, admin)
    Route::resource('reports', ReportController::class)->middleware('role:admin,asisten');
    Route::patch('reports/{report}/publish', [ReportController::class, 'publish'])->name('reports.publish')->middleware('role:admin,asisten');
    Route::patch('reports/{report}/archive', [ReportController::class, 'archive'])->name('reports.archive')->middleware('role:admin,asisten');

    // Users (admin only)
    Route::resource('users', UserController::class)->middleware('role:admin');

    // Pimpinan — read-only dashboard access already via dashboard
});

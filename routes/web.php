<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JurusanController;
use App\Http\Controllers\admin\AngkatanController;
use App\Http\Controllers\admin\KegiatanController;
use App\Http\Controllers\admin\PerusahaanController;
use App\Http\Controllers\admin\LowonganController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\PelamarController;
use App\Http\Middleware\EnsureAdminDudi;
use App\Http\Middleware\EnsureAdminSekolah;
use App\Http\Controllers\admin_dudi\DashboardController as DudiDashboardController;
use App\Http\Controllers\admin_dudi\LowongankerjaController;
use App\Http\Controllers\admin_dudi\LamaranController as DudiLamaranController;
use App\Http\Controllers\admin_dudi\ProfileDudiController;
use App\Http\Controllers\admin_dudi\ProfileUserController as DudiProfileUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\TracerAlumniController as AdminTracerAlumniController;
use App\Http\Controllers\admin\ProfileUserController as AdminProfileUserController;
use App\Http\Controllers\admin\ProfileAdminController;
use App\Http\Controllers\admin\LamaranController;
use App\Http\Controllers\PerusahaanPublicController;
use App\Http\Controllers\TracerAlumniPublicController;
use App\Http\Controllers\LowonganPublicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Public Pages
Route::get('/perusahaan', [PerusahaanPublicController::class, 'index'])->name('perusahaan');
Route::get('/perusahaan/{id}', [PerusahaanPublicController::class, 'show'])->name('perusahaan.show');

// Tracer Alumni (hanya untuk user yang sudah login)
Route::get('/tracer-alumni', [TracerAlumniPublicController::class, 'index'])->name('tracer-alumni')->middleware('auth');

// Lowongan Kerja (public)
Route::get('/lowongan', [LowonganPublicController::class, 'index'])->name('lowongan');
Route::get('/lowongan/{id}', [LowonganPublicController::class, 'show'])->name('lowongan.show');
Route::post('/lowongan/{id}/apply', [LowonganPublicController::class, 'apply'])->middleware(['auth', 'throttle:10,1'])->name('lowongan.apply');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.process');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1')->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile/detail', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/berkas/{id}', [ProfileController::class, 'deleteBerkas'])->name('profile.berkas.delete');
});

// Admin DU/DI Routes - Protected by authentication and admin DU/DI middleware
Route::middleware(['auth', EnsureAdminDudi::class])->prefix('admin_dudi')->name('admin_dudi.')->group(function () {
    Route::get('/dashboard', [DudiDashboardController::class, 'index'])->name('dashboard');
    Route::put('/dashboard/{perusahaan}', [DudiDashboardController::class, 'update'])->name('dashboard.update');
    Route::resource('lowongan', LowongankerjaController::class);
    Route::get('/lowongan-data', [LowongankerjaController::class, 'data'])->name('lowongan.data');

    // Data Lamaran
    Route::get('/lamaran', [DudiLamaranController::class, 'index'])->name('lamaran.index');
    Route::get('/lamaran/{lamaran}/edit', [DudiLamaranController::class, 'edit'])->name('lamaran.edit');
    Route::put('/lamaran/{lamaran}', [DudiLamaranController::class, 'update'])->name('lamaran.update');
    Route::get('/lamaran/{lamaran}/lowongan', [DudiLamaranController::class, 'showLowongan'])->name('lamaran.show-lowongan');

    // Profile Admin DU/DI
    Route::get('/profile', [ProfileDudiController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileDudiController::class, 'update'])->name('profile.update');

    // Profile User (Detail Pelamar)
    Route::get('/profile-user/{userId}', [DudiProfileUserController::class, 'index'])->name('profile-user.index');
});
// Admin Routes - Protected by authentication and admin middleware
Route::middleware(['auth', EnsureAdminSekolah::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('jurusan', JurusanController::class);
    Route::get('/jurusan-data', [JurusanController::class, 'data'])->name('jurusan.data');
    Route::resource('angkatan', AngkatanController::class);
    Route::get('/angkatan-data', [AngkatanController::class, 'data'])->name('angkatan.data');
    Route::resource('kegiatan', KegiatanController::class);
    Route::get('/kegiatan-data', [KegiatanController::class, 'data'])->name('kegiatan.data');
    Route::resource('perusahaan', PerusahaanController::class);
    Route::get('/perusahaan-data', [PerusahaanController::class, 'data'])->name('perusahaan.data');

    Route::resource('lowongan', LowonganController::class);
    Route::get('/lowongan-data', [LowonganController::class, 'data'])->name('lowongan.data');

    // Admin User Management
    Route::resource('user', UserController::class);

    // Data Pelamar (CRUD)
    Route::resource('pelamar', PelamarController::class)->except(['show']);

    // Route untuk demo simple modal (no custom JS)
    Route::get('/jurusan-simple', [JurusanController::class, 'indexSimple'])->name('jurusan.simple');

    // Tracer Alumni (tanpa tambah data di sini)
    Route::get('/tracer', [AdminTracerAlumniController::class, 'index'])->name('tracer.index');
    Route::get('/tracer/export', [AdminTracerAlumniController::class, 'export'])->name('tracer.export');
    Route::get('/tracer/{tracer}', [AdminTracerAlumniController::class, 'show'])->name('tracer.show');
    Route::put('/tracer/{tracer}', [AdminTracerAlumniController::class, 'update'])->name('tracer.update');
    Route::delete('/tracer/{tracer}', [AdminTracerAlumniController::class, 'destroy'])->name('tracer.destroy');

    // Profile User (untuk show/edit yang reuse halaman profil)
    Route::get('/profile-user/{userId}', [AdminProfileUserController::class, 'show'])->name('profile-user.show');
    Route::get('/profile-user/{userId}/edit', [AdminProfileUserController::class, 'edit'])->name('profile-user.edit');
    Route::put('/profile-user/{userId}', [AdminProfileUserController::class, 'update'])->name('profile-user.update');
    Route::delete('/profile-user/{userId}/berkas/{berkasId}', [AdminProfileUserController::class, 'deleteBerkas'])->name('profile-user.berkas.delete');

    // Admin Profile (ringkas: hanya tampilan data diri admin yang sedang login)
    Route::get('/profile', [ProfileAdminController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileAdminController::class, 'update'])->name('profile.update');

    // Data Lamaran
    Route::get('/lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
    Route::get('/lamaran/{lamaran}/edit', [LamaranController::class, 'edit'])->name('lamaran.edit');
    Route::put('/lamaran/{lamaran}', [LamaranController::class, 'update'])->name('lamaran.update');
    Route::get('/lamaran/{lamaran}/lowongan', [LamaranController::class, 'showLowongan'])->name('lamaran.show-lowongan');
});

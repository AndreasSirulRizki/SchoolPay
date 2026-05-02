<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaAuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Petugas;
use App\Http\Controllers\Siswa;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// ── SISWA AUTH (/login) ──────────────────────────────────────────────────────
Route::get('/login', [SiswaAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [SiswaAuthController::class, 'login'])->name('login.post');

// ── STAFF AUTH (/login-admin) ────────────────────────────────────────────────
Route::get('/login-admin', [AuthController::class, 'showLogin'])->name('login.admin');
Route::get('/login/{role}', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login-admin', [AuthController::class, 'login'])->name('login.admin.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/siswa/logout', [SiswaAuthController::class, 'logout'])->name('siswa.logout');

// ── ADMIN ────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/petugas', [Admin\PetugasController::class, 'index'])->name('petugas.index');
    Route::post('/petugas', [Admin\PetugasController::class, 'store'])->name('petugas.store');
    Route::put('/petugas/{user}', [Admin\PetugasController::class, 'update'])->name('petugas.update');
    Route::delete('/petugas/{user}', [Admin\PetugasController::class, 'destroy'])->name('petugas.destroy');

    Route::get('/siswa', [Admin\SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa', [Admin\SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/siswa/{siswa}', [Admin\SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa}', [Admin\SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/import', [Admin\SiswaController::class, 'import'])->name('siswa.import');
    Route::get('/siswa/{siswa}/id-card', [Admin\SiswaController::class, 'idCard'])->name('siswa.id-card');

    Route::get('/kelas', [Admin\KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas', [Admin\KelasController::class, 'store'])->name('kelas.store');
    Route::put('/kelas/{kelas}', [Admin\KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{kelas}', [Admin\KelasController::class, 'destroy'])->name('kelas.destroy');

    Route::get('/spp', [Admin\SppController::class, 'index'])->name('spp.index');
    Route::post('/spp', [Admin\SppController::class, 'store'])->name('spp.store');
    Route::put('/spp/{spp}', [Admin\SppController::class, 'update'])->name('spp.update');
    Route::delete('/spp/{spp}', [Admin\SppController::class, 'destroy'])->name('spp.destroy');

    Route::get('/transaksi', [Admin\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi', [Admin\TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/cari-siswa', [Admin\TransaksiController::class, 'cariSiswa'])->name('transaksi.cari-siswa');
    Route::get('/transaksi/{pembayaran}/kwitansi', [Admin\TransaksiController::class, 'kwitansi'])->name('transaksi.kwitansi');

    Route::get('/history', [Admin\HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/preview', [Admin\HistoryController::class, 'preview'])->name('history.preview');
    Route::get('/history/pdf', [Admin\HistoryController::class, 'pdf'])->name('history.pdf');

    Route::get('/laporan', [Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [Admin\LaporanController::class, 'pdf'])->name('laporan.pdf');
    Route::get('/laporan/pdf-siswa', [Admin\LaporanController::class, 'pdfSiswa'])->name('laporan.pdf-siswa');
    Route::get('/laporan/excel', [Admin\LaporanController::class, 'excel'])->name('laporan.excel');
    Route::get('/laporan/excel-siswa', [Admin\LaporanController::class, 'excelSiswa'])->name('laporan.excel-siswa');
    Route::get('/laporan/excel-tunggakan', [Admin\LaporanController::class, 'excelTunggakan'])->name('laporan.excel-tunggakan');

    Route::get('/profile', [Admin\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/search', [Admin\SearchController::class, 'search'])->name('search');
    Route::get('/notifications', [Admin\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [Admin\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [Admin\NotificationController::class, 'readAll'])->name('notifications.read-all');
});

// ── PETUGAS ──────────────────────────────────────────────────────────────────
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/dashboard', [Petugas\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/transaksi', [Petugas\TransaksiController::class, 'index'])->name('transaksi');
    Route::post('/transaksi', [Petugas\TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/cari-siswa', [Petugas\TransaksiController::class, 'cariSiswa'])->name('cari-siswa');
    Route::get('/transaksi/{pembayaran}/kwitansi', [Petugas\TransaksiController::class, 'kwitansi'])->name('transaksi.kwitansi');

    Route::get('/history', [Petugas\HistoryController::class, 'index'])->name('history');
    Route::get('/kwitansi/{pembayaran}/pdf', [Petugas\HistoryController::class, 'kwitansiPdf'])->name('kwitansi');

    Route::get('/profile', [Petugas\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [Petugas\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/notifications', [Petugas\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [Petugas\NotificationController::class, 'markRead'])->name('notifications.read');
});

// ── SISWA ─────────────────────────────────────────────────────────────────────
Route::prefix('siswa')->name('siswa.')->middleware('auth.siswa')->group(function () {
    Route::get('/dashboard', [Siswa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/history', [Siswa\HistoryController::class, 'index'])->name('history');
    Route::get('/kwitansi/{pembayaran}/pdf', [Siswa\HistoryController::class, 'kwitansiPdf'])->name('kwitansi');
    Route::get('/bantuan', [Siswa\BantuanController::class, 'index'])->name('bantuan');
    Route::get('/profil', [Siswa\ProfileController::class, 'index'])->name('profil');
    Route::put('/profil', [Siswa\ProfileController::class, 'update'])->name('profil.update');
    Route::get('/notifications', [Siswa\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [Siswa\NotificationController::class, 'markRead'])->name('notifications.read');
});

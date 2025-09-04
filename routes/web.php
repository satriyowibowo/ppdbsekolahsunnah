<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GelombangController;

Route::get('/', fn() => redirect()->route('pendaftaran.jenjang'));

Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    Route::get('jenjang', [PendaftaranController::class, 'pilihJenjang'])->name('jenjang');
    Route::post('jenis-kelamin', [PendaftaranController::class, 'pilihJenisKelamin'])->name('jenis-kelamin');
    Route::post('form', [PendaftaranController::class, 'form'])->name('form');
    Route::post('/', [PendaftaranController::class, 'store'])->name('store');

    Route::middleware(['check.pendaftaran.ownership'])->group(function () {
        Route::get('sukses/{pendaftaran}', [PendaftaranController::class, 'sukses'])->name('sukses');
        Route::get('cetak/{pendaftaran}', [PendaftaranController::class, 'cetakFormulir'])->name('cetak');
        Route::get('pdf/{pendaftaran}', [PendaftaranController::class, 'downloadPDF'])->name('pdf');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('login', 'admin.login')->name('login');
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');

    Route::get('pendaftaran', [AdminController::class, 'daftarPendaftaran'])->name('pendaftaran.index');
    Route::get('pendaftaran/{pendaftaran}', [AdminController::class, 'detailPendaftaran'])->name('pendaftaran.show');

    Route::resource('gelombang', GelombangController::class);
    Route::patch('gelombang/{gelombang}/toggle-status', [GelombangController::class, 'toggleStatus'])
        ->name('gelombang.toggleStatus');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\Admin\GelombangController;

Route::get('/', function () {
    return redirect()->route('pendaftaran.jenjang');
});
Route::get('/pendaftaran/jenjang', [PendaftaranController::class, 'pilihJenjang'])->name('pendaftaran.jenjang');
Route::post('/pendaftaran/jenis-kelamin', [PendaftaranController::class, 'pilihJenisKelamin'])->name('pendaftaran.jenis-kelamin');
Route::post('/pendaftaran/form', [PendaftaranController::class, 'form'])->name('pendaftaran.form');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/sukses/{pendaftaran:uuid}', [PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', function () {
        return view('admin.login');
    })->name('login');

    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('gelombang', GelombangController::class);

    Route::patch('gelombang/{gelombang}/toggle-status', [GelombangController::class, 'toggleStatus'])
        ->name('gelombang.toggleStatus');


});

Route::middleware(['check.pendaftaran.ownership'])->group(function () {
    Route::get('/pendaftaran/sukses/{pendaftaran}', [PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');
    Route::get('/pendaftaran/cetak/{pendaftaran}', [PendaftaranController::class, 'cetakFormulir'])->name('pendaftaran.cetak');
    Route::get('/pendaftaran/pdf/{pendaftaran}', [PendaftaranController::class, 'downloadPDF'])->name('pendaftaran.pdf');
});

Route::get('/pendaftaran/cetak/{pendaftaran}', [PendaftaranController::class, 'cetakFormulir'])->name('pendaftaran.cetak');
Route::get('/pendaftaran/pdf/{pendaftaran}', [PendaftaranController::class, 'downloadPDF'])->name('pendaftaran.pdf');

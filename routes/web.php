<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMonitorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangHampirHabisController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/monitoring-barang', [BarangMonitorController::class, 'index'])->name('barang.index');

  
   // Route::get('/monitoring-barang', [BarangMonitorController::class, 'index'])->name('barang.monitor');


   // Export Excel & PDF
    Route::get('/barang/export/excel', [ExportController::class, 'exportExcel'])->name('barang.exportExcel');
    Route::get('/barang/export/pdf', [ExportController::class, 'exportPdf'])->name('barang.exportPdf');


    Route::get('/tambahData', [BarangController::class, 'create'])->name('tambahData');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');


Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barangKeluar.index');
Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])->name('barangKeluar.create');
Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barangKeluar.store');

Route::get('/barang-keluar/export/excel', [BarangKeluarController::class, 'exportExcel'])->name('barangKeluar.exportExcel');
Route::get('/barang-keluar/export/pdf', [BarangKeluarController::class, 'exportPdf'])->name('barangKeluar.exportPdf');

Route::get('/barang-hampir-habis', [BarangHampirHabisController::class, 'index'])->name('barang.hampir.habis');




Route::prefix('master')->name('master.')->group(function () {
    Route::get('/', [MasterBarangController::class, 'index'])->name('index');

    Route::post('/storeTipe', [MasterBarangController::class, 'storeTipe'])->name('storeTipe');
    Route::delete('/deleteTipe/{id}', [MasterBarangController::class, 'deleteTipe'])->name('deleteTipe');

    Route::post('/storeStatus', [MasterBarangController::class, 'storeStatus'])->name('storeStatus');
    Route::delete('/deleteStatus/{id}', [MasterBarangController::class, 'deleteStatus'])->name('deleteStatus');

    Route::post('/storeJasa', [MasterBarangController::class, 'storeJasa'])->name('storeJasa');
    Route::delete('/deleteJasa/{id}', [MasterBarangController::class, 'deleteJasa'])->name('deleteJasa');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

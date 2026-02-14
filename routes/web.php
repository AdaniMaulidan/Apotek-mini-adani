<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupplierController;

use App\Models\Obat;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\Pelanggan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Dashboard (Halaman Utama)
Route::get('/', function () {

    $totalObat = Obat::count();
    $totalPenjualan = Penjualan::count();
    $totalPembelian = Pembelian::count();
    $totalSupplier = Supplier::count();
    $totalPelanggan = Pelanggan::count();

    return view('dashboard', compact(
        'totalObat',
        'totalPenjualan',
        'totalPembelian',
        'totalSupplier',
        'totalPelanggan'
    ));
});

// Resource Routes
Route::resource('obat', ObatController::class);
Route::resource('penjualan', PenjualanController::class);
Route::resource('pembelian', PembelianController::class);
Route::resource('supplier', SupplierController::class);

// Pelanggan Routes
Route::get('pelanggan/aktif', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::get('pelanggan/semua', [PelangganController::class, 'list'])->name('pelanggan.list');
Route::resource('pelanggan', PelangganController::class)->except(['index']);

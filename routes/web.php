<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    
    if ($role === 'pelanggan') {
        $pelanggan = auth()->user()->pelanggan;
        $totalObat = Obat::count(); // Still count drugs for catalog
        $totalPenjualan = $pelanggan ? Penjualan::where('kd_pelanggan', $pelanggan->id)->count() : 0;
        $totalPembelian = 0; // Pelanggan doesn't see purchases
        $totalSupplier = 0;
        $totalPelanggan = 0;
        
        $latestSales = $pelanggan 
            ? Penjualan::with(['pelanggan', 'penjualanDetails.obat'])
                ->where('kd_pelanggan', $pelanggan->id)
                ->latest()->take(5)->get()
            : collect([]);
    } else {
        $totalObat = Obat::count();
        $totalPenjualan = Penjualan::count();
        $totalPembelian = Pembelian::count();
        $totalSupplier = Supplier::count();
        $totalPelanggan = Pelanggan::count();
        $latestSales = Penjualan::with(['pelanggan', 'penjualanDetails.obat'])->latest()->take(5)->get();
    }

    return view('dashboard', compact(
        'totalObat',
        'totalPenjualan',
        'totalPembelian',
        'totalSupplier',
        'totalPelanggan',
        'latestSales'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin & Apoteker Routes
    Route::middleware('role:admin,apoteker')->group(function () {
        Route::resource('obat', ObatController::class);
        Route::resource('supplier', SupplierController::class);
        Route::resource('pembelian', PembelianController::class);
        
        // Expired medicines specifically requested for Apoteker/Admin
        Route::get('obat-kadaluarsa', [ObatController::class, 'expired'])->name('obat.expired');
        Route::delete('obat-kadaluarsa/cleanup', [ObatController::class, 'cleanupExpired'])->name('obat.expired.cleanup');
    });

    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('pelanggan/aktif', [PelangganController::class, 'index'])->name('pelanggan.index');
        Route::get('pelanggan/semua', [PelangganController::class, 'list'])->name('pelanggan.list');
        Route::resource('pelanggan', PelangganController::class)->except(['index']);
        
        // User management
        Route::resource('users', UserController::class);
        
        // Reports
        Route::get('laporan/penjualan', [PenjualanController::class, 'report'])->name('penjualan.report');
    });

    // Apoteker & Pelanggan & Admin Routes (Penjualan)
    Route::middleware('role:apoteker,pelanggan,admin')->group(function () {
        Route::resource('penjualan', PenjualanController::class);
    });
    
    // Pelanggan Catalog
    Route::middleware('role:pelanggan')->group(function () {
        Route::get('/katalog', [ObatController::class, 'katalog'])->name('pelanggan.katalog');
    });
});

require __DIR__.'/auth.php';

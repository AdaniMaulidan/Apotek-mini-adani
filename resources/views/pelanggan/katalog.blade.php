@extends('layouts.app')

@section('title', 'Katalog Obat')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Katalog Obat</h1>
    <form action="{{ route('pelanggan.katalog') }}" method="GET" class="d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg-white border-primary small" placeholder="Cari nama obat..." value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<div class="row">
    @forelse($obats as $o)
    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
        <div class="card shadow h-100 border-bottom-primary">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-pills fa-4x text-primary-20 opacity-50"></i>
                </div>
                <h5 class="font-weight-bold text-gray-800 mb-1">{{ $o->nm_obat }}</h5>
                <p class="text-muted small mb-3">{{ $o->jenis }}</p>
                
                <div class="mb-3 px-3">
                    <div class="text-xs text-uppercase mb-2 text-primary font-weight-bold border-bottom pb-1">Daftar Harga</div>
                    
                    <!-- Harga Besar -->
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small text-muted">{{ $o->satuan_besar }}</span>
                        <span class="font-weight-bold text-gray-800">Rp {{ number_format($o->harga_jual_besar, 0, ',', '.') }}</span>
                    </div>

                    <!-- Harga Menengah -->
                    @if($o->satuan_menengah)
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small text-muted">{{ $o->satuan_menengah }}</span>
                        <span class="font-weight-bold text-gray-800">Rp {{ number_format($o->harga_jual_menengah, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <!-- Harga Kecil -->
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted">{{ $o->satuan_kecil }} (Ecer)</span>
                        <span class="font-weight-bold text-gray-800">Rp {{ number_format($o->harga_jual_kecil, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mb-1">
                    <span class="badge badge-success badge-pill">Stok Tersedia</span>
                </div>
            </div>
            <div class="card-footer bg-white border-0 pb-3">
                <a href="{{ route('penjualan.create', ['obat_id' => $o->id]) }}" class="btn btn-primary btn-block rounded-pill">
                    <i class="fas fa-shopping-cart mr-2"></i> Beli Sekarang
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <img src="https://illustrations.popsy.co/blue/waiting-for-something.svg" style="max-width: 200px;" class="mb-4">
        <h3>Obat tidak ditemukan</h3>
        <p class="text-muted">Coba kata kunci lain atau hubungi apoteker kami.</p>
    </div>
    @endforelse
</div>

<style>
    .text-primary-20 { color: rgba(78, 115, 223, 0.2); }
    .opacity-50 { opacity: 0.5; }
    .rounded-pill { border-radius: 50px; }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <span class="badge badge-primary px-3 py-2">Role: {{ ucfirst(auth()->user()->role) }}</span>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Penjualan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success h-100 py-2 shadow-sm">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            {{ auth()->user()->role == 'pelanggan' ? 'Riwayat Transaksi Saya' : 'Total Penjualan' }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPenjualan }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Obat Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2 shadow-sm">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Jenis Obat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalObat }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-pills fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role != 'pelanggan')
    <!-- Pembelian Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info h-100 py-2 shadow-sm">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pembelian</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPembelian }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Supplier Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning h-100 py-2 shadow-sm">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Supplier</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSupplier }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-truck fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Account Info Card for Pelanggan -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-info h-100 py-2 shadow-sm">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">ID Pelanggan Anda</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ auth()->user()->pelanggan->kd_pelanggan ?? 'Belum Terhubung' }}</div>
                        <div class="small mt-2 text-muted">Gunakan ID ini saat transaksi di kasir apotek.</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-id-card fa-3x text-gray-200"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
    .text-xs { font-size: .7rem; }
    .sidebar-heading { font-size: 0.75rem; font-weight: 800; }
</style>

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Menu Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap" style="gap: 15px;">
                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'apoteker')
                        <a href="{{ route('obat.index') }}" class="btn btn-primary shadow-sm btn-icon-split">
                            <span class="icon text-white-50"><i class="fas fa-pills"></i></span>
                            <span class="text">Kelola Data Obat</span>
                        </a>
                        <a href="{{ route('supplier.index') }}" class="btn btn-info shadow-sm btn-icon-split">
                            <span class="icon text-white-50"><i class="fas fa-truck"></i></span>
                            <span class="text">Data Supplier</span>
                        </a>
                    @endif
                    
                    @if(auth()->user()->role == 'admin')
                        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary shadow-sm btn-icon-split">
                            <span class="icon text-white-50"><i class="fas fa-users"></i></span>
                            <span class="text">Daftar Pelanggan</span>
                        </a>
                    @endif

                    @if(auth()->user()->role == 'apoteker')
                        <a href="{{ route('pembelian.create') }}" class="btn btn-dark shadow-sm btn-icon-split">
                            <span class="icon text-white-50"><i class="fas fa-shopping-basket"></i></span>
                            <span class="text">Beli Stok Baru</span>
                        </a>
                    @endif

                    @if(auth()->user()->role == 'apoteker' || auth()->user()->role == 'pelanggan')
                        <a href="{{ route('penjualan.create') }}" class="btn btn-success shadow-sm btn-icon-split">
                            <span class="icon text-white-50"><i class="fas fa-cash-register"></i></span>
                            <span class="text">Transaksi Penjualan</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Latest Sales Table -->
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transaksi Penjualan Terakhir</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>Nota</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestSales as $sale)
                            <tr>
                                <td class="font-weight-bold">{{ $sale->nota }}</td>
                                <td>{{ date('d/m/Y', strtotime($sale->tgl_nota)) }}</td>
                                <td>{{ $sale->pelanggan->nm_pelanggan }}</td>
                                <td class="text-right">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-info btn-sm rounded-circle shadow-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small italic">Belum ada transaksi terekam.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-icon-split {
        padding: 0;
        overflow: hidden;
        display: inline-flex;
        align-items: stretch;
        justify-content: center;
    }
    .btn-icon-split .icon {
        background: rgba(0,0,0,.15);
        padding: .375rem .75rem;
    }
    .btn-icon-split .text {
        padding: .375rem .75rem;
    }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Dashboard Apotek Adani</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
        <div class="card" style="margin-bottom: 0; background-color: #eff6ff; border-left: 4px solid var(--primary);">
            <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600;">TOTAL OBAT</div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--primary);">{{ $totalObat }}</div>
        </div>
        <div class="card" style="margin-bottom: 0; background-color: #ecfdf5; border-left: 4px solid var(--success);">
            <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600;">TOTAL PENJUALAN</div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--success);">{{ $totalPenjualan }}</div>
        </div>
        <div class="card" style="margin-bottom: 0; background-color: #fffbeb; border-left: 4px solid var(--warning);">
            <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600;">TOTAL PEMBELIAN</div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--warning);">{{ $totalPembelian }}</div>
        </div>
        <div class="card" style="margin-bottom: 0; background-color: #fef2f2; border-left: 4px solid var(--danger);">
            <div style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600;">TOTAL SUPPLIER</div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--danger);">{{ $totalSupplier }}</div>
        </div>
    </div>

    <div style="margin-top: 3rem;">
        <h3>Menu Cepat</h3>
        <div style="display: flex; gap: 1rem; margin-top: 1rem; flex-wrap: wrap;">
            <a href="{{ route('obat.index') }}" class="btn btn-primary">Kelola Data Obat</a>
            <a href="{{ route('supplier.index') }}" class="btn btn-outline" style="border-color: var(--primary); color: var(--primary);">Data Supplier</a>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-outline" style="border-color: var(--secondary); color: var(--secondary);">Daftar Pelanggan</a>
            <a href="{{ route('pembelian.create') }}" class="btn btn-outline" style="border-color: var(--primary); color: var(--primary);">Beli Stok Baru</a>
            <a href="{{ route('penjualan.create') }}" class="btn btn-outline" style="border-color: var(--success); color: var(--success);">Transaksi Penjualan</a>
        </div>
    </div>
</div>
@endsection

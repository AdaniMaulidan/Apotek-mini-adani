@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Penjualan</h1>
    <a href="{{ route('penjualan.create') }}" class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Penjualan Baru
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Keluar</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="50">No</th>
                        <th>No. Nota</th>
                        <th>Tgl Nota</th>
                        <th>Pelanggan</th>
                        <th>Total Bayar</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penjualans as $penjualan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-light border">{{ $penjualan->nota }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($penjualan->tgl_nota)->format('d/m/Y') }}</td>
                        <td><strong>{{ $penjualan->pelanggan->nm_pelanggan ?? '-' }}</strong></td>
                        <td><span class="badge badge-success px-2 py-1">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span></td>
                        <td class="text-center">
                            <a href="{{ route('penjualan.show', $penjualan->id) }}" class="btn btn-info btn-sm shadow-sm" title="Detail">
                                <i class="fas fa-search mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted small italic">
                            Belum ada riwayat penjualan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

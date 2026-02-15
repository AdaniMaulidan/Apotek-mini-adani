@extends('layouts.app')

@section('title', 'Riwayat Pembelian')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Pembelian Stok</h1>
    <a href="{{ route('pembelian.create') }}" class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Pembelian Baru
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 text-primary font-weight-bold">
        Data Pembelian dari Supplier
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="50">No</th>
                        <th>No. Nota</th>
                        <th>Tgl Nota</th>
                        <th>Supplier</th>
                        <th>Diskon</th>
                        <th>Total Bayar</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelians as $pembelian)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-light border">{{ $pembelian->nota }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($pembelian->tgl_nota)->format('d/m/Y') }}</td>
                        <td><strong>{{ $pembelian->supplier->nm_suplier ?? '-' }}</strong></td>
                        <td>Rp {{ number_format($pembelian->diskon, 0, ',', '.') }}</td>
                        <td><span class="badge badge-success px-2 py-1">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</span></td>
                        <td class="text-center">
                            <a href="{{ route('pembelian.show', $pembelian->id) }}" class="btn btn-info btn-sm shadow-sm" title="Detail">
                                <i class="fas fa-search mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted small italic">
                            Belum ada riwayat pembelian stok.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

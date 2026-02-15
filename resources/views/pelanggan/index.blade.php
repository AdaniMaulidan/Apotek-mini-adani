@extends('layouts.app')

@section('title', 'Daftar Pelanggan Aktif')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pelanggan Aktif</h1>
    <span class="text-muted small">Pelanggan dengan riwayat transaksi</span>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pelanggan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="50">No</th>
                        <th width="100">Kode</th>
                        <th>Nama Pelanggan</th>
                        <th>Kontak</th>
                        <th>Lokasi</th>
                        <th width="120">Transaksi</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $pelanggan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-light border">{{ $pelanggan->kd_pelanggan }}</span></td>
                        <td><strong>{{ $pelanggan->nm_pelanggan }}</strong></td>
                        <td><i class="fas fa-phone-alt mr-2 text-muted"></i>{{ $pelanggan->telpon ?: '-' }}</td>
                        <td>
                            <div class="small"><i class="fas fa-map-marker-alt mr-1 text-danger"></i> {{ $pelanggan->kota ?: '-' }}</div>
                            <div class="text-muted extra-small">{{ $pelanggan->alamat ?: '-' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-primary">{{ $pelanggan->penjualans_count ?? $pelanggan->penjualans->count() }} Transaksi</span>
                        </td>
                        <td>
                            <a href="{{ route('penjualan.index', ['pelanggan_id' => $pelanggan->id]) }}" class="btn btn-info btn-sm btn-block shadow-sm">
                                <i class="fas fa-history mr-1"></i> Riwayat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-user-slash fa-3x mb-3 d-block"></i>
                            Belum ada pelanggan aktif.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

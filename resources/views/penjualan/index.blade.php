@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Riwayat Penjualan</h2>
        <a href="{{ route('penjualan.create') }}" class="btn btn-primary">Tambah Penjualan Baru</a>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Nota</th>
                    <th>Tgl Nota</th>
                    <th>Pelanggan</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualans as $penjualan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $penjualan->nota }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($penjualan->tgl_nota)->format('d/m/Y') }}</td>
                    <td>{{ $penjualan->pelanggan->nm_pelanggan ?? '-' }}</td>
                    <td><span class="badge badge-success">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span></td>
                    <td>
                        <a href="{{ route('penjualan.show', $penjualan->id) }}" class="btn btn-outline" style="padding: 0.25rem 0.5rem;">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Belum ada data penjualan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Daftar Pelanggan Aktif')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Daftar Pelanggan Aktif</h2>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Daftar pelanggan yang pernah melakukan transaksi penjualan.</p>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Pelanggan</th>
                    <th>Telepon</th>
                    <th>Kota / Alamat</th>
                    <th>Total Transaksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggans as $pelanggan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge" style="background: var(--background);">{{ $pelanggan->kd_pelanggan }}</span></td>
                    <td><strong>{{ $pelanggan->nm_pelanggan }}</strong></td>
                    <td>{{ $pelanggan->telpon ?: '-' }}</td>
                    <td>
                        {{ $pelanggan->kota ?: '-' }}<br>
                        <small style="color: var(--text-muted);">{{ $pelanggan->alamat ?: '-' }}</small>
                    </td>
                    <td>
                        <span class="badge badge-success">{{ $pelanggan->penjualans->count() }} Kali</span>
                    </td>
                    <td>
                        <a href="{{ route('penjualan.index', ['pelanggan_id' => $pelanggan->id]) }}" class="btn btn-outline" style="padding: 0.25rem 0.5rem;">Lihat Riwayat</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Belum ada pelanggan yang melakukan transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

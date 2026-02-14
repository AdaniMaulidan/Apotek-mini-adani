@extends('layouts.app')

@section('title', 'Data Pembelian')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Data Pembelian Stok</h2>
        <a href="{{ route('pembelian.create') }}" class="btn btn-primary">Tambah Pembelian</a>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Nota</th>
                    <th>Tgl Nota</th>
                    <th>Supplier</th>
                    <th>Diskon</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembelians as $pembelian)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $pembelian->nota }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($pembelian->tgl_nota)->format('d/m/Y') }}</td>
                    <td>{{ $pembelian->supplier->nm_suplier ?? '-' }}</td>
                    <td>Rp {{ number_format($pembelian->diskon, 0, ',', '.') }}</td>
                    <td><span class="badge badge-success">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</span></td>
                    <td>
                        <a href="{{ route('pembelian.show', $pembelian->id) }}" class="btn btn-outline" style="padding: 0.25rem 0.5rem;">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Belum ada data pembelian.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

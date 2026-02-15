@extends('layouts.app')

@section('title', 'Manajemen Obat Kadaluarsa')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Obat Kadaluarsa</h1>
    <form action="{{ route('obat.expired.cleanup') }}" method="POST" onsubmit="return confirm('Hapus semua data obat yang sudah melewati tanggal kadaluarsa?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger shadow-sm">
            <i class="fas fa-trash-alt fa-sm text-white-50 mr-1"></i> Hapus Data Kadaluarsa
        </button>
    </form>
</div>

<!-- Overdue Section -->
<div class="card shadow mb-4 border-left-danger">
    <div class="card-header py-3 bg-danger text-white">
        <h6 class="m-0 font-weight-bold"><i class="fas fa-exclamation-circle mr-2"></i>Sudah Kadaluarsa</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th>Stok Tersisa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($overdue as $o)
                    <tr class="table-danger">
                        <td>{{ $o->kd_obat }}</td>
                        <td>{{ $o->nm_obat }}</td>
                        <td><strong>{{ date('d/m/Y', strtotime($o->tgl_kadaluarsa)) }}</strong></td>
                        <td>{{ $o->formatStok() }}</td>
                        <td>
                            <a href="{{ route('obat.edit', $o->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Tidak ada obat yang sudah kadaluarsa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Proximity Warning Section -->
<div class="card shadow mb-4 border-left-warning">
    <div class="card-header py-3 bg-warning text-dark">
        <h6 class="m-0 font-weight-bold"><i class="fas fa-clock mr-2"></i>Segera Kadaluarsa (Dalam 30 Hari)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th>Sisa Hari</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($warning as $w)
                    @php
                        $days = now()->diffInDays($w->tgl_kadaluarsa);
                    @endphp
                    <tr>
                        <td>{{ $w->kd_obat }}</td>
                        <td>{{ $w->nm_obat }}</td>
                        <td>{{ date('d/m/Y', strtotime($w->tgl_kadaluarsa)) }}</td>
                        <td><span class="badge badge-warning">{{ $days }} Hari Lagi</span></td>
                        <td>{{ $w->formatStok() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Tidak ada obat yang mendekati tanggal kadaluarsa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

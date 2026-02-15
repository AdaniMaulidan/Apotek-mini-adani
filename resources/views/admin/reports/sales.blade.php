@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Penjualan</h1>
    <button onclick="window.print()" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-print fa-sm text-white-50 mr-1"></i> Cetak Laporan
    </button>
</div>

<div class="card shadow mb-4 no-print">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('penjualan.report') }}" method="GET" class="form-inline">
            <div class="form-group mr-3">
                <label class="mr-2">Dari Tanggal:</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="form-group mr-3">
                <label class="mr-2">Sampai Tanggal:</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('penjualan.report') }}" class="btn btn-secondary ml-2">Reset</a>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="text-center mb-4 only-print">
            <h2>Laporan Penjualan Apotek Adani</h2>
            <p>Periode: {{ request('start_date') ?: 'Awal' }} s/d {{ request('end_date') ?: 'Hari Ini' }}</p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nota</th>
                        <th>Pelanggan</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualans as $p)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($p->tgl_nota)) }}</td>
                        <td>{{ $p->nota }}</td>
                        <td>{{ $p->pelanggan->nm_pelanggan }}</td>
                        <td>{{ $p->penjualanDetails->count() }} Item</td>
                        <td class="text-right">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold bg-light">
                        <td colspan="4" class="text-right">TOTAL PENDAPATAN:</td>
                        <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        .sidebar, .topbar { display: none !important; }
        #wrapper { display: block; }
        .container-fluid { width: 100%; padding: 0; }
        .card { border: none; box-shadow: none; }
        .only-print { display: block !important; }
    }
    .only-print { display: none; }
</style>
@endsection

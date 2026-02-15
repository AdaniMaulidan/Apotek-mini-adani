@extends('layouts.app')

@section('title', 'Detail Pembelian - ' . $pembelian->nota)

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Transaksi Pembelian</h1>
    <a href="{{ route('pembelian.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-primary">
            <div class="card-body">
                <h6 class="font-weight-bold text-primary text-uppercase mb-3">Informasi Nota</h6>
                <div class="row no-gutters">
                    <div class="col-4 text-muted small">No. Nota</div>
                    <div class="col-8 font-weight-bold">: {{ $pembelian->nota }}</div>
                    
                    <div class="col-4 text-muted small mt-2">Tanggal</div>
                    <div class="col-8 font-weight-bold">: {{ \Carbon\Carbon::parse($pembelian->tgl_nota)->format('d F Y') }}</div>
                    
                    <div class="col-4 text-muted small mt-2">Supplier</div>
                    <div class="col-8 font-weight-bold">: {{ $pembelian->supplier->nm_suplier ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 border-left-success">
            <div class="card-body">
                <h6 class="font-weight-bold text-success text-uppercase mb-3">Ringkasan Biaya</h6>
                <div class="row no-gutters">
                    <div class="col-4 text-muted small">Total Bruto</div>
                    @php $bruto = $pembelian->total + $pembelian->diskon; @endphp
                    <div class="col-8 font-weight-bold">: Rp {{ number_format($bruto, 0, ',', '.') }}</div>
                    
                    <div class="col-4 text-muted small mt-2">Diskon</div>
                    <div class="col-8 font-weight-bold text-danger">: - Rp {{ number_format($pembelian->diskon, 0, ',', '.') }}</div>
                    
                    <div class="col-4 text-muted small mt-2">Total Netto</div>
                    <div class="col-8 font-weight-bold text-success" style="font-size: 1.2rem;">: Rp {{ number_format($pembelian->total, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Item Obat</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="bg-light text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>Harga Beli</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembelian->pembelianDetails as $detail)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center"><span class="badge badge-light border">{{ $detail->obat->kd_obat }}</span></td>
                        <td><strong>{{ $detail->obat->nm_obat }}</strong></td>
                        <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $detail->jumlah }} {{ $detail->satuan }}</td>
                        <td class="text-right font-weight-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-light">
                        <td colspan="5" class="text-right font-weight-bold">DISKON NOTA:</td>
                        <td class="text-right font-weight-bold text-danger">Rp {{ number_format($pembelian->diskon, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-primary text-white">
                        <td colspan="5" class="text-right font-weight-bold" style="font-size: 1.1rem;">TOTAL AKHIR:</td>
                        <td class="text-right font-weight-bold" style="font-size: 1.1rem;">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

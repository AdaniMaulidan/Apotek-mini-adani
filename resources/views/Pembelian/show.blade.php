@extends('layouts.app')

@section('title', 'Detail Pembelian - ' . $pembelian->nota)

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Detail Transaksi Pembelian</h2>
        <a href="{{ route('pembelian.index') }}" class="btn btn-outline">Kembali ke Daftar</a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div style="background: var(--background); padding: 1.5rem; border-radius: 12px;">
            <h3 style="margin-bottom: 1rem; color: var(--primary);">Informasi Nota</h3>
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.5rem;">
                <tr>
                    <td style="color: var(--text-muted); width: 40%;">No. Nota</td>
                    <td style="font-weight: 700;">: {{ $pembelian->nota }}</td>
                </tr>
                <tr>
                    <td style="color: var(--text-muted);">Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($pembelian->tgl_nota)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td style="color: var(--text-muted);">Supplier</td>
                    <td>: {{ $pembelian->supplier->nm_suplier ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div style="background: var(--background); padding: 1.5rem; border-radius: 12px;">
            <h3 style="margin-bottom: 1rem; color: var(--success);">Ringkasan Biaya</h3>
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.5rem;">
                <tr>
                    <td style="color: var(--text-muted); width: 40%;">Diskon</td>
                    <td style="font-weight: 600;">: Rp {{ number_format($pembelian->diskon, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="color: var(--text-muted);">Total Bayar</td>
                    <td style="font-size: 1.25rem; font-weight: 700; color: var(--success);">: Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <h3 style="margin-bottom: 1.5rem;">Daftar Item Obat</h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Obat</th>
                    <th>Nama Obat</th>
                    <th style="text-align: right;">Harga Beli</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelian->pembelianDetails as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge" style="background: var(--background);">{{ $detail->obat->kd_obat }}</span></td>
                    <td><strong>{{ $detail->obat->nm_obat }}</strong></td>
                    <td style="text-align: right;">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $detail->jumlah }} {{ $detail->obat->satuan }}</td>
                    <td style="text-align: right; font-weight: 600;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: 700;">Diskon Nota</td>
                    <td style="text-align: right; font-weight: 700; color: var(--danger);">- Rp {{ number_format($pembelian->diskon, 0, ',', '.') }}</td>
                </tr>
                <tr style="background: var(--background);">
                    <td colspan="5" style="text-align: right; font-weight: 700; font-size: 1.1rem;">TOTAL AKHIR</td>
                    <td style="text-align: right; font-weight: 700; font-size: 1.1rem; color: var(--success);">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

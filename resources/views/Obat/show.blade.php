@extends('layouts.app')

@section('title', 'Detail Obat - ' . $obat->nm_obat)

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin: 0;">Detail Informasi Obat</h2>
        <p style="color: var(--text-muted);">Informasi lengkap mengenai stok, harga, dan riwayat transaksi.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('obat.index') }}" class="btn btn-outline">Kembali</a>
        <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-primary">Edit Data</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Bagian Kiri: Info Dasar -->
    <div class="card" style="height: fit-content;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="width: 80px; height: 80px; background: var(--background); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; border: 2px solid var(--primary);">
                <span style="font-size: 2rem;">💊</span>
            </div>
            <h3 style="margin: 0;">{{ $obat->nm_obat }}</h3>
            <span class="badge" style="background: var(--background); margin-top: 0.5rem;">{{ $obat->kd_obat }}</span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
                <span style="color: var(--text-muted);">Jenis</span>
                <span style="font-weight: 600;">{{ $obat->jenis }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
                <span style="color: var(--text-muted);">Konversi Stok</span>
                <span style="font-weight: 600;">1 {{ $obat->satuan_besar }} = {{ $obat->isi_menengah }} {{ $obat->satuan_menengah }} = {{ $obat->isi_menengah * $obat->isi_kecil }} {{ $obat->satuan_kecil }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
                <span style="color: var(--text-muted);">Stok Saat Ini</span>
                <span style="font-weight: 700; color: {{ $obat->stok <= ($obat->isi_menengah * $obat->isi_kecil) ? 'var(--danger)' : 'var(--success)' }};">
                    {{ $obat->formatStok() }}
                </span>
            </div>
            @if($obat->satuan_menengah && $obat->satuan_menengah != $obat->satuan_kecil)
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
                <span style="color: var(--text-muted);">Total {{ $obat->satuan_menengah }}</span>
                <span style="font-weight: 600;">{{ floor($obat->stok / $obat->isi_kecil) }} {{ $obat->satuan_menengah }}</span>
            </div>
            @endif
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
                <span style="color: var(--text-muted);">Total Satuan Kecil</span>
                <span style="font-weight: 600;">{{ $obat->stok }} {{ $obat->satuan_kecil }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">
                <span style="color: var(--text-muted);">Supplier Utama</span>
                <span style="font-weight: 600;">{{ $obat->supplier->nm_suplier ?? '-' }}</span>
            </div>
        </div>

        <div style="margin-top: 2rem; background: var(--background); padding: 1.5rem; border-radius: 12px;">
            <div style="margin-bottom: 1.5rem; border-bottom: 1px dashed var(--border); padding-bottom: 1rem;">
                <small style="color: var(--text-muted); display: block;">Harga Beli Modal (per {{ $obat->satuan_besar }})</small>
                <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">Rp {{ number_format($obat->harga_beli, 0, ',', '.') }}</span>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <h4 style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">Harga Jual Target:</h4>
                <div style="display: flex; justify-content: space-between;">
                    <span>per {{ $obat->satuan_besar }}</span>
                    <span style="font-weight: 700; color: var(--success);">Rp {{ number_format($obat->harga_jual_besar, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>per {{ $obat->satuan_menengah }}</span>
                    <span style="font-weight: 700; color: var(--success);">Rp {{ number_format($obat->harga_jual_menengah, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>per {{ $obat->satuan_kecil }}</span>
                    <span style="font-weight: 700; color: var(--success);">Rp {{ number_format($obat->harga_jual_kecil, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Kanan: Riwayat -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Riwayat Pembelian -->
        <div class="card">
            <h3 style="margin-bottom: 1.5rem; border-left: 4px solid var(--primary); padding-left: 1rem;">Riwayat Pembelian (Stok Masuk)</h3>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Tgl Nota</th>
                            <th>No. Nota</th>
                            <th>Jml</th>
                            <th>Harga Beli</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obat->pembelianDetails as $detail)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($detail->pembelian->tgl_nota)->format('d/m/Y') }}</td>
                            <td><span style="font-weight: 600;">{{ $detail->pembelian->nota }}</span></td>
                            <td>{{ $detail->jumlah }} {{ $detail->satuan }}</td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-muted);">Belum ada riwayat pembelian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Riwayat Penjualan -->
        <div class="card">
            <h3 style="margin-bottom: 1.5rem; border-left: 4px solid var(--success); padding-left: 1rem;">Riwayat Penjualan (Stok Keluar)</h3>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Tgl Nota</th>
                            <th>No. Nota</th>
                            <th>Jml</th>
                            <th>Harga Jual</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obat->penjualanDetails as $detail)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($detail->penjualan->tgl_nota)->format('d/m/Y') }}</td>
                            <td><span style="font-weight: 600;">{{ $detail->penjualan->nota }}</span></td>
                            <td>{{ $detail->jumlah }} {{ $detail->satuan }}</td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-muted);">Belum ada riwayat penjualan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Obat')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Data Obat</h2>
        <a href="{{ route('obat.index') }}" class="btn btn-outline">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('obat.update', $obat->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Kode Obat</label>
                <input type="text" name="kd_obat" class="form-control" value="{{ old('kd_obat', $obat->kd_obat) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Obat</label>
                <input type="text" name="nm_obat" class="form-control" value="{{ old('nm_obat', $obat->nm_obat) }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Jenis Obat</label>
                <select name="jenis" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    @php
                        $jenis_obat = ['Tablet', 'Sirup', 'Kapsul', 'Salep', 'Injeksi', 'Cair'];
                    @endphp
                    @foreach($jenis_obat as $j)
                        <option value="{{ $j }}" {{ old('jenis', $obat->jenis) == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
        <div style="background: var(--background); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px dashed var(--border);">
            <h3 style="margin-bottom: 1.5rem; color: var(--primary);">Konfigurasi Multi-Satuan</h3>
            
            <!-- Satuan Besar -->
            <div style="display: grid; grid-template-columns: 2fr 1fr 2fr; gap: 1.5rem; margin-bottom: 1.5rem; align-items: end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Satuan Besar (Utama)</label>
                    <input type="text" name="satuan_besar" class="form-control" value="{{ old('satuan_besar', $obat->satuan_besar) }}" required>
                </div>
                <div style="text-align: center; color: var(--text-muted); padding-bottom: 0.75rem;">—</div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Harga Jual per Satuan Besar</label>
                    <input type="number" name="harga_jual_besar" class="form-control" value="{{ old('harga_jual_besar', $obat->harga_jual_besar) }}" required>
                </div>
            </div>

            <!-- Satuan Menengah -->
            <div style="display: grid; grid-template-columns: 2fr 1fr 2fr; gap: 1.5rem; margin-bottom: 1.5rem; align-items: end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Satuan Menengah</label>
                    <input type="text" name="satuan_menengah" class="form-control" value="{{ old('satuan_menengah', $obat->satuan_menengah) }}">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Isi per Satuan Besar</label>
                    <input type="number" name="isi_menengah" class="form-control" value="{{ old('isi_menengah', $obat->isi_menengah) }}" min="1" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Harga Jual per Satuan Menengah</label>
                    <input type="number" name="harga_jual_menengah" class="form-control" value="{{ old('harga_jual_menengah', $obat->harga_jual_menengah) }}">
                </div>
            </div>

            <!-- Satuan Kecil -->
            <div style="display: grid; grid-template-columns: 2fr 1fr 2fr; gap: 1.5rem; align-items: end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Satuan Kecil (Eceran)</label>
                    <input type="text" name="satuan_kecil" class="form-control" value="{{ old('satuan_kecil', $obat->satuan_kecil) }}" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Isi per Satuan Menengah</label>
                    <input type="number" name="isi_kecil" class="form-control" value="{{ old('isi_kecil', $obat->isi_kecil) }}" min="1" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Harga Jual per Satuan Kecil</label>
                    <input type="number" name="harga_jual_kecil" class="form-control" value="{{ old('harga_jual_kecil', $obat->harga_jual_kecil) }}" required>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Harga Beli Modal (Terakhir)</label>
                <input type="number" step="0.01" name="harga_beli" class="form-control" value="{{ old('harga_beli', $obat->harga_beli) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Stok (Dalam Satuan Terkecil)</label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok', $obat->stok) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Supplier Utama</label>
            <select name="kd_suplier" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('kd_suplier', $obat->kd_suplier) == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->nm_suplier }} ({{ $supplier->kota }})
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;">Update Data Obat</button>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script>
    document.querySelector('select[name="jenis"]').addEventListener('change', function() {
        const jenis = this.value;
        const s_besar = document.querySelector('input[name="satuan_besar"]');
        const s_menengah = document.querySelector('input[name="satuan_menengah"]');
        const s_kecil = document.querySelector('input[name="satuan_kecil"]');
        const i_menengah = document.querySelector('input[name="isi_menengah"]');
        const i_kecil = document.querySelector('input[name="isi_kecil"]');

        const confirmChange = confirm('Ubah konfigurasi satuan default berdasarkan jenis obat baru?');
        if (!confirmChange) return;

        if (jenis === 'Tablet' || jenis === 'Kapsul') {
            s_besar.value = 'Box';
            s_menengah.value = 'Strip';
            s_kecil.value = jenis;
            i_menengah.value = 10;
            i_kecil.value = 10;
        } else if (jenis === 'Sirup' || jenis === 'Cair') {
            s_besar.value = 'Box';
            s_menengah.value = 'Botol';
            s_kecil.value = 'Botol';
            i_menengah.value = 1;
            i_kecil.value = 1;
        } else if (jenis === 'Salep') {
            s_besar.value = 'Box';
            s_menengah.value = 'Tube';
            s_kecil.value = 'Tube';
            i_menengah.value = 1;
            i_kecil.value = 1;
        } else if (jenis === 'Injeksi') {
            s_besar.value = 'Box';
            s_menengah.value = 'Vial';
            s_kecil.value = 'Vial';
            i_menengah.value = 1;
            i_kecil.value = 1;
        }
    });
</script>
@endsection

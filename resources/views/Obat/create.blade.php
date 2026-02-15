@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Tambah Obat Baru</h2>
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

    <form action="{{ route('obat.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Kode Obat (Otomatis)</label>
                <input type="text" name="kd_obat" class="form-control" value="{{ $nextKode }}" readonly style="background: var(--background);">
            </div>
            <div class="form-group">
                <label class="form-label">Nama Obat</label>
                <input type="text" name="nm_obat" class="form-control" value="{{ old('nm_obat') }}" placeholder="Nama Lengkap Obat" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Jenis Obat</label>
                <select name="jenis" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Tablet" {{ old('jenis') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="Sirup" {{ old('jenis') == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                    <option value="Kapsul" {{ old('jenis') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                    <option value="Salep" {{ old('jenis') == 'Salep' ? 'selected' : '' }}>Salep</option>
                    <option value="Injeksi" {{ old('jenis') == 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
                    <option value="Cair" {{ old('jenis') == 'Cair' ? 'selected' : '' }}>Cair</option>
                </select>
            </div>
        <div style="background: var(--background); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px dashed var(--border);">
            <h3 style="margin-bottom: 1.5rem; color: var(--primary);">Konfigurasi Multi-Satuan</h3>
            
            <!-- Satuan Besar -->
            <div style="display: grid; grid-template-columns: 2fr 1fr 2fr; gap: 1.5rem; margin-bottom: 1.5rem; align-items: end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Satuan Besar (Utama)</label>
                    <input type="text" name="satuan_besar" class="form-control" value="{{ old('satuan_besar', 'Box') }}" placeholder="Contoh: Box, Botol" required>
                </div>
                <div style="text-align: center; color: var(--text-muted); padding-bottom: 0.75rem;">—</div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Harga Jual per Satuan Besar</label>
                    <input type="number" name="harga_jual_besar" class="form-control" value="{{ old('harga_jual_besar') }}" placeholder="0" required>
                </div>
            </div>

            <!-- Satuan Menengah -->
            <div style="display: grid; grid-template-columns: 2fr 1fr 2fr; gap: 1.5rem; margin-bottom: 1.5rem; align-items: end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Satuan Menengah (Opsional)</label>
                    <input type="text" name="satuan_menengah" class="form-control" value="{{ old('satuan_menengah', 'Strip') }}" placeholder="Contoh: Strip">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Isi per Satuan Besar</label>
                    <input type="number" name="isi_menengah" class="form-control" value="{{ old('isi_menengah', 1) }}" min="1" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Harga Jual per Satuan Menengah</label>
                    <input type="number" name="harga_jual_menengah" class="form-control" value="{{ old('harga_jual_menengah', 0) }}" placeholder="0">
                </div>
            </div>

            <!-- Satuan Kecil -->
            <div style="display: grid; grid-template-columns: 2fr 1fr 2fr; gap: 1.5rem; align-items: end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Satuan Kecil (Terkecil/Eceran)</label>
                    <input type="text" name="satuan_kecil" class="form-control" value="{{ old('satuan_kecil', 'Tablet') }}" placeholder="Contoh: Tablet, Kapsul, Pcs" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Isi per Satuan Menengah</label>
                    <input type="number" name="isi_kecil" class="form-control" value="{{ old('isi_kecil', 1) }}" min="1" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Harga Jual per Satuan Kecil</label>
                    <input type="number" name="harga_jual_kecil" class="form-control" value="{{ old('harga_jual_kecil') }}" placeholder="0" required>
                </div>
            </div>
            
            <small style="display: block; margin-top: 1rem; color: var(--text-muted); font-style: italic;">
                *Jika hanya ada 2 level satuan (misal: Botol langsung ke Tablet), isi Satuan Menengah sama dengan Satuan Besar dan Isi per Satuan Besar = 1.
            </small>
        </div>

        <div class="form-group">
            <label class="form-label">Supplier Utama</label>
            <select name="kd_suplier" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('kd_suplier') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->nm_suplier }} ({{ $supplier->kota }})
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;">Simpan Data Obat</button>
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

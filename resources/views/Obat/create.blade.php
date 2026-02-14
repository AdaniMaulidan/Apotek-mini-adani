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
            <div class="form-group">
                <label class="form-label">Satuan</label>
                <select name="satuan" class="form-control" required>
                    <option value="">-- Pilih Satuan --</option>
                    <option value="Box" {{ old('satuan') == 'Box' ? 'selected' : '' }}>Box</option>
                    <option value="Botol" {{ old('satuan') == 'Botol' ? 'selected' : '' }}>Botol</option>
                    <option value="Strip" {{ old('satuan') == 'Strip' ? 'selected' : '' }}>Strip</option>
                    <option value="Tablet" {{ old('satuan') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="Kapsul" {{ old('satuan') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                    <option value="Pcs" {{ old('satuan') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                    <option value="Tube" {{ old('satuan') == 'Tube' ? 'selected' : '' }}>Tube</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Harga Jual Target (Rp)</label>
                <input type="number" step="0.01" name="harga_jual" class="form-control" value="{{ old('harga_jual') }}" placeholder="Tentukan harga jual ke pelanggan" required>
                <small style="color: var(--text-muted);">*Harga beli dan stok akan terisi otomatis saat Anda melakukan transaksi pembelian.</small>
            </div>
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

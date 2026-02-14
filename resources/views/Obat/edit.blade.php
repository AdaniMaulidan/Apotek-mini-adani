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
            <div class="form-group">
                <label class="form-label">Satuan</label>
                <select name="satuan" class="form-control" required>
                    <option value="">-- Pilih Satuan --</option>
                    @php
                        $satuan_obat = ['Box', 'Botol', 'Strip', 'Tablet', 'Kapsul', 'Pcs', 'Tube'];
                    @endphp
                    @foreach($satuan_obat as $s)
                        <option value="{{ $s }}" {{ old('satuan', $obat->satuan) == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Harga Beli (Rp)</label>
                <input type="number" step="0.01" name="harga_beli" class="form-control" value="{{ old('harga_beli', $obat->harga_beli) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Harga Jual (Rp)</label>
                <input type="number" step="0.01" name="harga_jual" class="form-control" value="{{ old('harga_jual', $obat->harga_jual) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Stok</label>
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

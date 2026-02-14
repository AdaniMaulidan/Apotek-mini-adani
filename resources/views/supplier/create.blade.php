@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Tambah Supplier Baru</h2>
        <a href="{{ route('supplier.index') }}" class="btn btn-outline">Kembali</a>
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

    <form action="{{ route('supplier.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Kode Supplier (Otomatis)</label>
                <input type="text" name="kd_suplier" class="form-control" value="{{ $nextKode }}" readonly style="background: var(--background);">
            </div>
            <div class="form-group">
                <label class="form-label">Nama Supplier</label>
                <input type="text" name="nm_suplier" class="form-control" value="{{ old('nm_suplier') }}" placeholder="PT. Alam Raya" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Kota</label>
                <input type="text" name="kota" class="form-control" value="{{ old('kota') }}" placeholder="Jakarta, Surabaya, dll" required>
            </div>
            <div class="form-group">
                <label class="form-label">Telepon</label>
                <input type="text" name="telpon" class="form-control" value="{{ old('telpon') }}" placeholder="021-xxxxxx" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Jl. Perintis Kemerdekaan No. 10..." required>{{ old('alamat') }}</textarea>
        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;">Simpan Data Supplier</button>
        </div>
    </form>
</div>
@endsection

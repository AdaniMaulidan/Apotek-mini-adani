@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Data Supplier</h2>
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

    <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Kode Supplier</label>
                <input type="text" name="kd_suplier" class="form-control" value="{{ $supplier->kd_suplier }}" readonly style="background: var(--background);">
            </div>
            <div class="form-group">
                <label class="form-label">Nama Supplier</label>
                <input type="text" name="nm_suplier" class="form-control" value="{{ old('nm_suplier', $supplier->nm_suplier) }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Kota</label>
                <input type="text" name="kota" class="form-control" value="{{ old('kota', $supplier->kota) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Telepon</label>
                <input type="text" name="telpon" class="form-control" value="{{ old('telpon', $supplier->telpon) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $supplier->alamat) }}</textarea>
        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;">Perbarui Data Supplier</button>
        </div>
    </form>
</div>
@endsection

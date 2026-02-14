@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Tambah Pelanggan Baru</h2>
        <a href="{{ route('pelanggan.list') }}" class="btn btn-outline">Kembali</a>
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

    <form action="{{ route('pelanggan.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Kode Pelanggan (Otomatis)</label>
                <input type="text" name="kd_pelanggan" class="form-control" value="{{ $nextKode }}" readonly style="background: var(--background);">
            </div>
            <div class="form-group">
                <label class="form-label">Nama Pelanggan</label>
                <input type="text" name="nm_pelanggan" class="form-control" value="{{ old('nm_pelanggan') }}" placeholder="Nama Lengkap" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="telpon" class="form-control" value="{{ old('telpon') }}" placeholder="08xxxxxxxx">
            </div>
            <div class="form-group">
                <label class="form-label">Kota</label>
                <input type="text" name="kota" class="form-control" value="{{ old('kota') }}" placeholder="Jakarta, Bandung, dll">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Jl. Raya No. 123...">{{ old('alamat') }}</textarea>
        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;">Simpan Data Pelanggan</button>
        </div>
    </form>
</div>
@endsection

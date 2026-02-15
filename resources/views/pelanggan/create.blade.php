@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Pelanggan Baru</h1>
    <a href="{{ route('pelanggan.list') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Data Pelanggan</h6>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger border-left-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kode Pelanggan (Otomatis)</label>
                                <input type="text" name="kd_pelanggan" class="form-control bg-light" value="{{ $nextKode }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Pelanggan</label>
                                <input type="text" name="nm_pelanggan" class="form-control" value="{{ old('nm_pelanggan') }}" placeholder="Nama Lengkap" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nomor Telepon</label>
                                <input type="text" name="telpon" class="form-control" value="{{ old('telpon') }}" placeholder="08xxxxxxxx">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kota</label>
                                <input type="text" name="kota" class="form-control" value="{{ old('kota') }}" placeholder="Jakarta, Bandung, dll">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Jl. Raya No. 123...">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm font-weight-bold">
                            <i class="fas fa-save mr-2"></i> Simpan Data Pelanggan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Obat')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Data Obat</h1>
    <a href="{{ route('obat.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Perubahan Data: {{ $obat->nm_obat }}</h6>
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

        <form action="{{ route('obat.update', $obat->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Kode Obat</label>
                        <input type="text" name="kd_obat" class="form-control" value="{{ old('kd_obat', $obat->kd_obat) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Obat</label>
                        <input type="text" name="nm_obat" class="form-control" value="{{ old('nm_obat', $obat->nm_obat) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Tanggal Kadaluarsa</label>
                        <input type="date" name="tgl_kadaluarsa" class="form-control" value="{{ old('tgl_kadaluarsa', $obat->tgl_kadaluarsa) }}" required>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Jenis Obat</label>
                        <select name="jenis" class="form-control custom-select" required>
                            @php $jenis_list = ['Tablet', 'Sirup', 'Kapsul', 'Salep', 'Injeksi', 'Cair']; @endphp
                            @foreach($jenis_list as $j)
                                <option value="{{ $j }}" {{ old('jenis', $obat->jenis) == $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Supplier Utama</label>
                        <select name="kd_suplier" class="form-control custom-select" required>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('kd_suplier', $obat->kd_suplier) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nm_suplier }} ({{ $supplier->kota }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-danger">Harga Beli Modal (Nett)</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                            <input type="number" step="0.01" name="harga_beli" class="form-control" value="{{ old('harga_beli', $obat->harga_beli) }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-primary">Stok Sekarang (Unit Terkecil)</label>
                        <input type="number" name="stok" class="form-control" value="{{ old('stok', $obat->stok) }}" required>
                        <small class="text-muted">Setara dengan: {{ $obat->formatStok() }}</small>
                    </div>
                </div>
            </div>

            <div class="card bg-light border-left-primary mb-4">
                <div class="card-body">
                    <h5 class="font-weight-bold text-primary mb-3"><i class="fas fa-layer-group mr-2"></i>Konfigurasi Multi-Satuan</h5>
                    
                    <div class="row align-items-end mb-3">
                        <div class="col-md-5">
                            <label class="small font-weight-bold">Satuan Besar</label>
                            <input type="text" name="satuan_besar" class="form-control" value="{{ old('satuan_besar', $obat->satuan_besar) }}" required>
                        </div>
                        <div class="col-md-2 text-center text-muted"><i class="fas fa-arrow-right d-none d-md-block"></i></div>
                        <div class="col-md-5">
                            <label class="small font-weight-bold">Harga Jual Besar</label>
                            <input type="number" name="harga_jual_besar" class="form-control" value="{{ old('harga_jual_besar', $obat->harga_jual_besar) }}" required>
                        </div>
                    </div>

                    <div class="row align-items-end mb-3">
                        <div class="col-md-4">
                            <label class="small font-weight-bold">Satuan Menengah</label>
                            <input type="text" name="satuan_menengah" class="form-control" value="{{ old('satuan_menengah', $obat->satuan_menengah) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="small font-weight-bold">Isi per Besar</label>
                            <input type="number" name="isi_menengah" class="form-control" value="{{ old('isi_menengah', $obat->isi_menengah) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="small font-weight-bold">Harga Jual Menengah</label>
                            <input type="number" name="harga_jual_menengah" class="form-control" value="{{ old('harga_jual_menengah', $obat->harga_jual_menengah) }}">
                        </div>
                    </div>

                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="small font-weight-bold">Satuan Kecil</label>
                            <input type="text" name="satuan_kecil" class="form-control" value="{{ old('satuan_kecil', $obat->satuan_kecil) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="small font-weight-bold">Isi per Menengah</label>
                            <input type="number" name="isi_kecil" class="form-control" value="{{ old('isi_kecil', $obat->isi_kecil) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="small font-weight-bold">Harga Jual Kecil</label>
                            <input type="number" name="harga_jual_kecil" class="form-control" value="{{ old('harga_jual_kecil', $obat->harga_jual_kecil) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-warning btn-lg shadow-sm px-5 font-weight-bold">
                    <i class="fas fa-sync-alt mr-2"></i> Update Data Obat
                </button>
            </div>
        </form>
    </div>
</div>
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSelect = document.querySelector('select[name="jenis"]');
        
        function updateKonfigurasi() {
            const jenis = jenisSelect.value;
            const s_besar = document.querySelector('input[name="satuan_besar"]');
            const s_menengah = document.querySelector('input[name="satuan_menengah"]');
            const s_kecil = document.querySelector('input[name="satuan_kecil"]');
            const i_menengah = document.querySelector('input[name="isi_menengah"]');
            const i_kecil = document.querySelector('input[name="isi_kecil"]');

            if (!jenis) return;

            if (jenis === 'Tablet' || jenis === 'Kapsul') {
                s_besar.value = 'Box'; s_menengah.value = 'Strip'; s_kecil.value = jenis;
                i_menengah.value = 10; i_kecil.value = 10;
            } else if (jenis === 'Sirup' || jenis === 'Cair') {
                s_besar.value = 'Box'; s_menengah.value = 'Botol'; s_kecil.value = 'Botol';
                i_menengah.value = 1; i_kecil.value = 1;
            } else if (jenis === 'Salep') {
                s_besar.value = 'Box'; s_menengah.value = 'Tube'; s_kecil.value = 'Tube';
                i_menengah.value = 1; i_kecil.value = 1;
            } else if (jenis === 'Injeksi') {
                s_besar.value = 'Box'; s_menengah.value = 'Vial'; s_kecil.value = 'Vial';
                i_menengah.value = 1; i_kecil.value = 1;
            }
        }

        if (jenisSelect) {
            jenisSelect.addEventListener('change', updateKonfigurasi);
            // Don't trigger on edit if already has data, 
            // but we can trigger if it's currently empty/default
        }
    });
</script>
@endsection

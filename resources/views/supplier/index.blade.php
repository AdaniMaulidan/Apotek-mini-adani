@extends('layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Supplier</h1>
    <a href="{{ route('supplier.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Supplier Baru
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Rekanan Supplier</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="50">No</th>
                        <th width="100">Kode</th>
                        <th>Nama Supplier</th>
                        <th>Alamat & Kota</th>
                        <th>Kontak</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-light border">{{ $supplier->kd_suplier }}</span></td>
                        <td><strong>{{ $supplier->nm_suplier }}</strong></td>
                        <td>
                            <div>{{ $supplier->alamat }}</div>
                            <div class="small text-muted"><i class="fas fa-map-marker-alt mr-1"></i> {{ $supplier->kota }}</div>
                        </td>
                        <td>
                            <div class="badge badge-info"><i class="fas fa-phone mr-1"></i> {{ $supplier->telpon }}</div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-warning btn-sm shadow-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Yakin hapus supplier ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                            Belum ada data supplier.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

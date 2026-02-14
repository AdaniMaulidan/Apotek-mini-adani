@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Daftar Supplier</h2>
        <a href="{{ route('supplier.create') }}" class="btn btn-primary">Tambah Supplier</a>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Supplier</th>
                    <th>Kota</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge" style="background: var(--background);">{{ $supplier->kd_suplier }}</span></td>
                    <td><strong>{{ $supplier->nm_suplier }}</strong></td>
                    <td>{{ $supplier->kota }}</td>
                    <td>{{ $supplier->telpon }}</td>
                    <td>{{ $supplier->alamat }}</td>
                    <td style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-outline" style="padding: 0.25rem 0.5rem;">Edit</a>
                        <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Yakin hapus supplier ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="padding: 0.25rem 0.5rem; color: var(--danger); border-color: #fecaca;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                        Belum ada data supplier.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

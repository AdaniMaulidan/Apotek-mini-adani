@extends('layouts.app')

@section('title', 'Manajemen Pelanggan')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Semua Data Pelanggan</h2>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Pelanggan</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggans as $pelanggan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge" style="background: var(--background);">{{ $pelanggan->kd_pelanggan }}</span></td>
                    <td><strong>{{ $pelanggan->nm_pelanggan }}</strong></td>
                    <td>{{ $pelanggan->telpon }}</td>
                    <td>{{ $pelanggan->alamat }} ({{ $pelanggan->kota }})</td>
                    <td>
                        <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-outline" style="padding: 0.25rem 0.5rem;">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

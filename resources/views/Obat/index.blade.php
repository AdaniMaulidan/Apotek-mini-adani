@extends('layouts.app')

@section('title', 'Data Obat')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="margin: 0;">Data Inventori Obat</h2>
            <p style="color: var(--text-muted); font-size: 0.875rem; margin-top: 0.25rem;">Kelola stok dan informasi obat apotek.</p>
        </div>
        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <form action="{{ route('obat.index') }}" method="GET" style="display: flex; gap: 0.5rem; align-items: center;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode..." value="{{ request('search') }}" style="width: 250px;">
                <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;">Cari</button>
                @if(request('search'))
                    <a href="{{ route('obat.index') }}" class="btn btn-outline" style="background: var(--background); border-color: var(--danger); color: var(--danger); text-decoration: none;">Reset</a>
                @endif
            </form>
            <a href="{{ route('obat.create') }}" class="btn btn-primary">Tambah Obat Baru</a>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Obat</th>
                    <th>Daftar Harga Jual</th>
                    <th>Stok (Total)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($obats as $obat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge" style="background: var(--background);">{{ $obat->kd_obat }}</span></td>
                    <td><strong>{{ $obat->nm_obat }}</strong></td>
                    <td style="font-size: 0.875rem;">
                        <div style="margin-bottom: 0.25rem;">
                            <span style="color: var(--text-muted);">per {{ $obat->satuan_besar }}:</span> 
                            <strong>Rp {{ number_format($obat->harga_jual_besar, 0, ',', '.') }}</strong>
                        </div>
                        @if($obat->satuan_menengah && $obat->satuan_menengah != $obat->satuan_besar)
                        <div style="margin-bottom: 0.25rem;">
                            <span style="color: var(--text-muted);">per {{ $obat->satuan_menengah }}:</span> 
                            <strong>Rp {{ number_format($obat->harga_jual_menengah, 0, ',', '.') }}</strong>
                        </div>
                        @endif
                        <div>
                            <span style="color: var(--text-muted);">per {{ $obat->satuan_kecil }}:</span> 
                            <strong>Rp {{ number_format($obat->harga_jual_kecil, 0, ',', '.') }}</strong>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--primary);">{{ $obat->formatStok() }}</div>
                        <small style="color: var(--text-muted);">Total: {{ $obat->stok }} {{ $obat->satuan_kecil }}</small>
                    </td>
                    <td style="display: flex; gap: 0.5rem; align-items: start;">
                        <a href="{{ route('obat.show', $obat->id) }}" class="btn btn-outline" style="padding: 0.25rem 0.5rem; color: var(--primary); border-color: #bfdbfe;">Detail</a>
                        <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-outline" style="padding: 0.25rem 0.5rem;">Edit</a>
                        <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" onsubmit="return confirm('Yakin hapus obat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="padding: 0.25rem 0.5rem; color: var(--danger); border-color: #fecaca;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

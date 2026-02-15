@extends('layouts.app')

@section('title', 'Data Obat')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Obat</h1>
    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'apoteker')
        <a href="{{ route('obat.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Obat Baru
        </a>
    @endif
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Inventori Obat</h6>
        <form action="{{ route('obat.index') }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari obat..." value="{{ request('search') }}" aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('obat.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Daftar Harga Jual</th>
                        <th>Stok (Total)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obats as $obat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-light border">{{ $obat->kd_obat }}</span></td>
                        <td><strong>{{ $obat->nm_obat }}</strong></td>
                        <td>
                            @if($obat->tgl_kadaluarsa)
                                @php
                                    $diff = now()->diffInDays($obat->tgl_kadaluarsa, false);
                                    $badgeClass = $diff < 0 ? 'badge-danger' : ($diff < 30 ? 'badge-warning' : 'badge-success');
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    {{ date('d/m/Y', strtotime($obat->tgl_kadaluarsa)) }}
                                    @if($diff < 0) (Expired) @endif
                                </span>
                            @else
                                <span class="text-muted small">N/A</span>
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                <span class="text-muted">{{ $obat->satuan_besar }}:</span> 
                                <strong>{{ number_format($obat->harga_jual_besar, 0, ',', '.') }}</strong>
                            </div>
                            @if($obat->satuan_menengah && $obat->satuan_menengah != $obat->satuan_besar)
                            <div class="small">
                                <span class="text-muted">{{ $obat->satuan_menengah }}:</span> 
                                <strong>{{ number_format($obat->harga_jual_menengah, 0, ',', '.') }}</strong>
                            </div>
                            @endif
                            <div class="small text-primary">
                                <span class="text-muted">{{ $obat->satuan_kecil }}:</span> 
                                <strong>{{ number_format($obat->harga_jual_kecil, 0, ',', '.') }}</strong>
                            </div>
                        </td>
                        <td>
                            @php
                                $stok_total = $obat->stok;
                                $konversi_menengah = $obat->isi_kecil; 
                                $konversi_besar = $obat->isi_menengah * $obat->isi_kecil; 

                                // Hitung total ekuivalen di setiap satuan
                                $total_besar = $konversi_besar > 0 ? $stok_total / $konversi_besar : 0;
                                $total_menengah = $konversi_menengah > 0 ? $stok_total / $konversi_menengah : 0;
                                
                                // Hilangkan angka di belakang koma jika memang bilangan bulat
                                $display_besar = (floor($total_besar) == $total_besar) ? number_format($total_besar, 0, ',', '.') : number_format($total_besar, 1, ',', '.');
                                $display_menengah = (floor($total_menengah) == $total_menengah) ? number_format($total_menengah, 0, ',', '.') : number_format($total_menengah, 1, ',', '.');
                            @endphp
                            
                            <div class="small">
                                <span class="text-muted">{{ $obat->satuan_besar }}:</span> 
                                <strong>{{ $display_besar }}</strong>
                            </div>

                            @if($obat->satuan_menengah && $obat->satuan_menengah != $obat->satuan_besar && $obat->satuan_menengah != $obat->satuan_kecil)
                            <div class="small">
                                <span class="text-muted">{{ $obat->satuan_menengah }}:</span> 
                                <strong>{{ $display_menengah }}</strong>
                            </div>
                            @endif

                            <div class="small">
                                <span class="text-muted">{{ $obat->satuan_kecil }}:</span> 
                                <strong>{{ number_format($stok_total, 0, ',', '.') }}</strong>
                            </div>
                            
                            <hr class="my-1">
                            <div class="extra-small text-muted font-italic" style="font-size: 0.7rem;">
                                Total: {{ number_format($stok_total, 0, ',', '.') }} {{ $obat->satuan_kecil }}
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('obat.show', $obat->id) }}" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'apoteker')
                                    <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" onsubmit="return confirm('Yakin hapus obat ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

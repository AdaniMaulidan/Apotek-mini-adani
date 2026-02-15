@extends('layouts.app')

@section('title', 'Edit Staf')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Data Staf</h1>
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Staf: {{ $user->name }}</h6>
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

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Role</label>
                        <select name="role" class="form-control custom-select" required>
                            <option value="apoteker" {{ $user->role == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    
                    <hr>
                    <div class="alert alert-info small">
                        Kosongkan password jika tidak ingin mengubahnya.
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block shadow-sm py-2 mt-4 font-weight-bold">
                        <i class="fas fa-sync-alt mr-2"></i> Update Data Staf
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

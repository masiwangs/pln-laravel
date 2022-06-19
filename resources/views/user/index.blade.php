@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ auth()->user()->name }}</h3>
                <p class="text-subtitle text-muted">{{ auth()->user()->email }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.html">Administrasi</a></li>
                        <li class="breadcrumb-item active"><a href="index.html">User</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4"><i class="bi bi-person-fill"></i> Profil Anda</h5>
                @if(\Session::has('successUpdate'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Berhasil disimpan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form action="/administrasi/profile" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Alamat Email</label>
                                <input type="email" class="form-control" disabled value="{{ auth()->user()->email }}" placeholder="name@example.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                                @error('name')
                                <div><small class="text-danger">{{ $message }}</small></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4"><i class="bi bi-shield-lock-fill"></i> Keamanan</h5>
                @if(\Session::has('successChangePassword'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Berhasil disimpan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form action="/administrasi/profile/password" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Pasword Baru</label>
                                <input type="password" class="form-control" name="password" placeholder="Masukkan password baru">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Masukkan konfirmasi password baru">
                                @error('confirm_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')

@endsection
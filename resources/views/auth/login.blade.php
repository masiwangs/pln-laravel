@extends('layouts.auth')

@section('content')
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <h1 class="auth-title">Masuk</h1>
            <p class="auth-subtitle mb-5">Masukkan data yang valid untuk masuk ke halaman Admin.</p>
            @if(\Session::has('message'))
            <div class="alert alert-danger" role="alert">
                {{ \Session::get('message') }}
            </div>
            @endif
            <div class="alert alert-info" role="alert">
                <strong>Akun admin dummy:</strong><br/>
                email: admin@monitoring.com<br/>
                password: 123456
            </div>
            <form action="/login" method="POST">
                @csrf
                <div class="mb-4">
                    <div class="form-group position-relative has-icon-left">
                        <input type="text" name="email" class="form-control form-control-lg" placeholder="Email">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    @error('email')
                    <div>
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <div class="form-group position-relative has-icon-left">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    @error('password')
                    <div>
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember-me" value="1" id="rememberMeInput">
                        <label class="form-check-label" for="rememberMeInput">
                            Ingat saya
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg mt-5">Masuk</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'>Belum punya akun? <a href="/register" class="font-bold">Daftar</a>.</p>
                <p class='text-gray-600'>Lupa password? <a href="/forgot-password" class="font-bold">Reset</a>.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
            <img src="/assets/images/undraw/undraw_predictive_analytics.svg" alt="">
        </div>
    </div>
</div>
@endsection
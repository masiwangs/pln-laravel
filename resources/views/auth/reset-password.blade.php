@extends('layouts.auth')

@section('content')
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <h1 class="auth-title">Buat Password Baru</h1>
            <p class="auth-subtitle mb-5">Masukkan password baru.</p>

            <form method="POST">
                @csrf
                @if(\Session::has('status'))
                <div class="alert alert-success" role="alert">
                    {{ \Session::get('status') }}
                </div>
                @endif
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ \Request::query('email') }}">
                <div class="form-group position-relative has-icon-left">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                @error('password')
                <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
                <div class="form-group position-relative has-icon-left mt-4">
                    <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Konfirmasi password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                @error('password_confirmation')
                <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
                @error('email')
                <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
                @error('token')
                <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
                <button type="submit" class="btn btn-primary btn-block btn-lg mt-5">Reset password</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'>Sudah punya akun? <a href="/login" class="font-bold">Login</a>.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
            <img src="/assets/images/undraw/undraw_forgot_password_re_hxwm.svg" style="width: 60%" alt="">
        </div>
    </div>
</div>
@endsection
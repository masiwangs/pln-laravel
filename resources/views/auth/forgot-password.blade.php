@extends('layouts.auth')

@section('content')
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <h1 class="auth-title">Reset Password</h1>
            <p class="auth-subtitle mb-5">Masukkan email untuk reset password.</p>

            <form method="POST">
                @csrf
                @if(\Session::has('status'))
                <div class="alert alert-success" role="alert">
                    {{ \Session::get('status') }}
                </div>
                @endif
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" name="email" class="form-control form-control-lg" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
                @error('email')
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
@extends('layouts.auth')

@section('content')
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <h1 class="auth-title">Masuk</h1>
            <p class="auth-subtitle mb-5">Masukkan data yang valid untuk masuk ke halaman Admin.</p>

            <form action="/login" method="POST">
                @csrf
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" name="email" class="form-control form-control-lg" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
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
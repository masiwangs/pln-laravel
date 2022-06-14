@extends('layouts.auth')

@section('content')
<div class="row d-flex justify-content-center h-100">
    <div class="col-6 col-lg-3">
        <div class="my-5 d-flex justify-content-center">
            <img src="/assets/images/undraw/undraw_my_personal_files.svg" style="width: 75%" alt="">
        </div>
        <div class="card">
            <div class="card-body">
                <p><strong>Kode verifikasi pendaftaran telah dikirim ke Email Anda.</strong></p>
                <p>
                    Silahkah verifikasi terlebih dahulu sebelum masuk ke halaman Admin.
                </p>
                <hr>
                <p>Belum menerima link?</p>
                <form action="/email/verification-notification" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary">Kirim ulang</button>
                </form>
                @if(\Session::has('message'))
                <div class="mt-3">
                    <span class="text-success">{{ \Session::get('message') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
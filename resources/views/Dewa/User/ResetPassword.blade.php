@extends('Dewa.Base.Basic-page')

@section('css')
<!-- <link rel="stylesheet" href="{{asset('css/login.css')}}"> -->
<link rel="stylesheet" href="{{ auto_asset('Dewa/css/login.css') }}">
@endsection

@section('peta')
@endsection

@section('content')
<div class="container login">
    <h1>Masukkan Password Baru Anda</h1>

    <form action="/reset_password" method="POST" class="w-100">

        @csrf

        <!-- <label for="">Kode Verifikasi*</label> -->
        <label for="">Password*</label>
        <input type="password" class="password w-100 @error('password') is-invalid @enderror" name="password"
            maxlength="15" placeholder="Masukkan Password" data-bs-toggle="popover" data-bs-trigger="hover focus"
            data-bs-content="Password harus minimal (8 karakter, 1 angka, 1 huruf Kapital, 1 huruf Kecil)">
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <label for="">Verifikasi Password*</label>
        <input type="password" maxlength="15" class="password w-100 @error('password-retype') is-invalid @enderror"
            name="password-retype" placeholder="Masukkan Password">
        @error('password-retype')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="setara see-password form-check form-switch">
            <input class="form-check-input appearance-none focus:outline-none" onclick="see_password()" type="checkbox"
                role="switch" id="LihatKataSandi">
            <p>Lihat kata sandi</p>
        </div>
        <div class="submit-button mt-5">
            <button type="submit" class="btn btn-warning">Submit</button>
        </div>

    </form>
</div>
@endsection

@section('script')
@endsection
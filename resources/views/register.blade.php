@extends('Base.Basic-page')

@section('css')
    <!-- <link rel="stylesheet" href="{{asset('css/login.css')}}"> -->
    <link rel="stylesheet" href="{{ auto_asset('css/login.css') }}">
@endsection

@section('peta')
@endsection

@section('content')
<div class="container login">
    <h1>Buat Akun</h1>

    <form action="/Register_account" method="POST" class="w-auto">

        @csrf
        <div class="d-flex flex-row h-auto gap-3 w-100 justify-content-between">
            <div class="d-flex flex-column w-50">
                <label for="">Nama Depan*</label>
                <input type="text" name="nama-depan" maxlength="10" placeholder="john" class="w-100">
            </div>
            <div class="d-flex flex-column w-50">
                <label for="">Nama Belakang*</label>
                <input type="text" name="nama-belakang" maxlength="30" placeholder="john" class="w-100">
            </div>          
        </div>
        <label for="">Alamat Email*</label>
        <input type="email" name="email" maxlength="40" placeholder="Masukkan Email anda">
        <label for="">Password*</label>
        <input type="password"
            class="password"
            name="password"
            maxlength="15"
            placeholder="Masukkan Password"
            data-bs-toggle="popover"
            data-bs-trigger="hover focus"
            data-bs-content="Password harus minimal (8 karakter, 1 angka, 1 huruf Kapital, 1 huruf Kecil)">
        <label for="">Verifikasi Password*</label>
        <input type="password" maxlength="15" class="password" name="password-retype" placeholder="Masukkan Password">
        <div class="setara see-password form-check form-switch">
            <input class="form-check-input appearance-none focus:outline-none" onclick="see_password()" type="checkbox" role="switch" id="LihatKataSandi">
            <p>Lihat kata sandi</p>
        </div>
        <div class="submit-button">
            <!-- <button type="submit" >Register</button> -->
            <button type="submit" class="btn btn-warning" data-bs-target="#AlertModal">Register</button>

        </div>
    </form>
</div>
@endsection

@section('script')


<script>
    @error('message')
        NotifyAlertSuccess('Registrasi', '{{$message}}');
    @enderror
    // function submit_form(elemen,event){
    //     event.preventDefault();
    //     let form = elemen.closest('form')
    //     if(form.submit){
    //         console.log('masuk')
    //     }
    // }

    function see_password(){
        let form = document.querySelector('form')
        let inp = form.querySelectorAll('.password');

        inp.forEach(element => {
            if(element.getAttribute('type')=='password'){
                element.setAttribute('type','text')
            }
            else{
                element.setAttribute('type','password')
            }
            
        });
    }

    
</script>
@endsection
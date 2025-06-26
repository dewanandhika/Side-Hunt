@extends('Dewa.Base.Basic-page')

@section('css')
<style>
    .job {
        background-color: #CDCDCD !important;
    }

    .img-container {
        overflow: hidden;
        position: relative;
    }

    .img-custom {
        object-fit: fill;
        object-position: center;
        scale: 1;
        display: block;
        width: 100%;
        height: 100%;
        min-height: 100%;
        max-height: 100%;
    }

    .img-container::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 30%;
        height: 100%;
        /* background: linear-gradient(to left, #4d4d4d, transparent); */
        /* pointer-events: none; */
    }
</style>
@endsection

@section('content')
<div class="container w-100 h-auto gap-5 d-flex my-5 flex-column justify-content-center align-items-center">
    <div class="w-100 d-flex mt-5 mb-2 flex-column justify-content-center align-items-center">
        <p class="fw-bolder" style="font-size: 30px;">Cari Pekerjaan</p>
        <div
            class="form-control w-75 ps-3 rounded-5 shadow d-flex flex-row gap-0 justify-content-center align-items-center">
            <i class="bi bi-search w-auto"></i>
            <input type="text"
                class="searchBox form-control rounded-5 flex-1 px-2 no-outline border-0  @error('max_gaji') is-invalid @enderror"
                maxlength="150" name="searchBox" oninput="SearchBox(this)" value="{{ old('nama') }}" placeholder="">
        </div>
    </div>
    <div class="newest d-none w-100 d-flex mt-5 flex-column row">
        Pekerjaan Terbaru Nih,
        <div class="w-100 justify-content-center align-items-center d-flex ">
            <div class="row g-3 border-3 border-black shadow mt-0 rounded-4 p-3 pt-0 row d-flex flex-wrap justify-content-start justify-content-md-between align-items-start"
                style="min-height: 43vh; width: fit-content; max-width: fit-content; min-width: 100%;">
                @for($i=5;$i>1;$i--)
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="/Pekerjaan/{id}"
                        class=" w-100 h-100 job text-decoration-none d-flex flex-row p-0 gap-0 rounded-2 align-items-center justify-content-between"
                        style="">
                        <div class="rounded-start-2 justify-content-start align-items-center"
                            style="width: 40%; min-width: 40%; height: 100%;">
                            <img class="rounded-start-2"
                                src="{{ auto_asset('Dewa/img/f4030acf172260f3241cad5f4527a7d8.jpg') }}"
                                style="width: 100%; height: 100%;  object-fit: cover;" alt="">
                        </div>
                        <div class="d-flex flex-column justify-content-center text-truncate align-items-start gap-0 flex-grow-1 h-100 p-2"
                            style=" max-width: 100%;">
                            <p class="clear-p fw-bolder text-truncate w-100" style="font-size: 12px; color: #2E2D2C;">
                                Potong
                                Rumput ksdaksjdkjasbdkjasbdkmasbndmanb</p>
                            <p class="clear-p  opacity-50" style="font-size: 10px; color: #2E2D2C;">5 Jam yang lalu</p>
                            <p class="clear-p opacity-50" style="font-size: 10px; color: #2E2D2C;"></p>
                        </div>
                    </a>
                </div>
                @endfor
            </div>
        </div>
    </div>
    @if(session('account'))

    <div class="result Newest w-100 mt-5 flex-column row" id="Rekomendation" style="display: flex;">
        @if(count($match)!=0)
        Pekerjaan Disarankan,
        <div class="w-100 justify-content-center align-items-center d-flex ">
            <div class="g-3 border-3 border-black mt-0 rounded-4 p-3 pt-0 row d-flex gy-4 flex-wrap justify-content-start flex-grow-1 align-items-start"
                style="min-height: 43vh; width: fit-content; max-width: fit-content; min-width: 100%;">
                @foreach($match as $key => $value)
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="/Pekerjaan/{{{$key}}}"
                        class=" w-100 h-100 job text-decoration-none d-flex flex-row p-0 gap-0 rounded-2 align-items-center justify-content-between"
                        style="">
                        <div class="rounded-start-2 justify-content-start align-items-center"
                            style="width: 40%; min-width: 40%; height: 100%;">
                            <img class="rounded-start-2"
                                src="{{ auto_asset('Dewa/img/f4030acf172260f3241cad5f4527a7d8.jpg') }}"
                                style="width: 100%; height: 100%;  object-fit: cover;" alt="">
                        </div>
                        <div class="d-flex flex-column justify-content-center text-truncate align-items-start gap-0 flex-grow-1 h-100 p-2"
                            style=" max-width: 100%;">
                            <p class="clear-p fw-bolder text-truncate w-100" style="font-size: 12px; color: #2E2D2C;">
                                {{{$all_rekomendasi[$key-1]['nama']}}}</p>
                            <p class="clear-p  opacity-50" style="font-size: 10px; color: #2E2D2C;">5 Jam yang lalu</p>
                            <p class="clear-p opacity-50" style="font-size: 10px; color: #2E2D2C;">
                                {{{hitungJarak($all_rekomendasi[$key-1]['longitude'],
                                $all_rekomendasi[$key-1]['langitude'],
                                session('account')['longitude'], session('account')['langitude'])}}}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <h5>
            Berdasarkan data yang kamu isi di preferensi user, Belum ada Pekerjaan yang cocok untukmu
        </h5>
        <p>tapi jangan sedih berikut pekerjaan yang sedang diminati oleh kebanyakan user</p>

        <div class="w-100 justify-content-center align-items-center d-flex ">
            <div class="g-3 border-3 border-black mt-0 rounded-4 p-3 pt-0 row d-flex gy-4 flex-wrap justify-content-start flex-grow-1 align-items-start"
                style="min-height: 43vh; width: fit-content; max-width: fit-content; min-width: 100%;">
                @foreach($match as $key => $value)
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{{$key}}}"
                        class=" w-100 h-100 job text-decoration-none d-flex flex-row p-0 gap-0 rounded-2 align-items-center justify-content-between"
                        style="">
                        <div class="rounded-start-2 justify-content-start align-items-center"
                            style="width: 40%; min-width: 40%; height: 100%;">
                            <img class="rounded-start-2"
                                src="{{ auto_asset('Dewa/img/f4030acf172260f3241cad5f4527a7d8.jpg') }}"
                                style="width: 100%; height: 100%;  object-fit: cover;" alt="">
                        </div>
                        <div class="d-flex flex-column justify-content-center text-truncate align-items-start gap-0 flex-grow-1 h-100 p-2"
                            style=" max-width: 100%;">
                            <p class="clear-p fw-bolder text-truncate w-100" style="font-size: 12px; color: #2E2D2C;">
                                {{{$all[$key-1]['nama']}}}</p>
                            <p class="clear-p  opacity-50" style="font-size: 10px; color: #2E2D2C;">5 Jam yang lalu</p>
                            @if(session)
                            <p class="clear-p opacity-50" style="font-size: 10px; color: #2E2D2C;">
                                {{{hitungJarak($all[$key-1]['longitude'], $all[$key-1]['langitude'],
                                session('account')['longitude'], session('account')['langitude'])}}}</p>

                            @else
                            <p class="clear-p  opacity-50" style="font-size: 10px; color: #2E2D2C;">Jarak</p>
                            @endif
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    <div class="result d-flex w-100 d-flex mt-0 flex-column row">
        Semua Pekerjaan,
        <div class="w-100 p-3 mt-2 border-3 border-black shadow rounded-3">
            <div class="card bg-transparent border-0 mb-0">
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label for="jobType" class="form-label">Skill Yang Dibutuhkan</label>
                            <select class="form-select" id="jobType">
                                <option selected>Semua</option>
                                <option>Editing</option>
                                <option>Video</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="city" class="form-label">Kota</label>
                            <select class="form-select" id="city">
                                <option selected>Semua</option>
                                <option>Surabaya</option>
                                <option>Jakarta</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-100 justify-content-center align-items-center d-flex ">
                <div class="g-3 border-3 border-black mt-0 rounded-4 p-3 pt-0 row d-flex gy-4 flex-wrap justify-content-start flex-grow-1 align-items-start"
                    style="min-height: 43vh; width: fit-content; max-width: fit-content; min-width: 100%;">
                    @if(count($all)!=null)
                    @foreach($all as $pekerjaan)
                    <div class="col-12 col-md-6 col-lg-3 the_job">
                        <a href="/Pekerjaan/{{{$pekerjaan['id']}}}"
                            class=" w-100 h-100 job text-decoration-none d-flex flex-row p-0 gap-0 rounded-2 align-items-center justify-content-between"
                            style="">
                            <div class="rounded-start-2 justify-content-start align-items-center"
                                style="width: 40%; min-width: 40%; height: 100%;">
                                <img class="rounded-start-2"
                                    src="{{ auto_asset('Dewa/img/f4030acf172260f3241cad5f4527a7d8.jpg') }}"
                                    style="width: 100%; height: 100%;  object-fit: cover;" alt="">
                            </div>
                            <div class="d-flex flex-column justify-content-center text-truncate align-items-start gap-0 flex-grow-1 h-100 p-2"
                                style=" max-width: 100%;">
                                <p class="clear-p fw-bolder text-truncate w-100"
                                    style="font-size: 12px; color: #2E2D2C;">
                                    {{{$pekerjaan['nama']}}}</p>
                                <p class="clear-p  opacity-50" style="font-size: 10px; color: #2E2D2C;">5 Jam yang lalu
                                </p>
                                @if(session('account'))
                                <p class="clear-p opacity-50" style="font-size: 10px; color: #2E2D2C;">
                                    {{{hitungJarak($pekerjaan['longitude'], $pekerjaan['langitude'],
                                    session('account')['longitude'], session('account')['langitude'])}}}</p>

                                @else
                                <p class="clear-p  opacity-50" style="font-size: 10px; color: #2E2D2C;">Jarak</p>


                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="notFound w-100 justify-content-center align-items-center" style="display: none;">
                        <p>Tidak ada pekerjaan yang ditemukan</p>
                    </div>
                    @endforeach
                    @else
                    <p>Belum ada pekerjaan yang terdaftar</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>


    function SearchBox(elemen) {
        let rekomen = document.querySelector('#Rekomendation');
        rekomen.style.display = "none"
        let all_jobs = document.querySelectorAll('.the_job')
        $count = 0;
        all_jobs.forEach(element => {

            console.log();
            document.addEventListener('DOMContentLoaded', function () {
            })
            if (element.innerText.toLowerCase().includes(elemen.value.toLowerCase())) {
                element.style.display = "flex"
                $count += 1;

            }
            else {

                element.style.display = "none"
            }
        });

        if ($count == 0) {
            document.querySelector('.notFound').style.display = 'flex'
        }
        else {
            document.querySelector('.notFound').style.display = 'none'

        }

    }
</script>
@endsection

@php
function hitungJarak($lon1, $lat1, $lon2, $lat2)
{
$earthRadius = 6371; // kilometer

$dLat = deg2rad($lat2 - $lat1);
$dLon = deg2rad($lon2 - $lon1);

$a = sin($dLat / 2) * sin($dLat / 2) +
cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
sin($dLon / 2) * sin($dLon / 2);

$c = 2 * atan2(sqrt($a), sqrt(1 - $a));

$distance = $earthRadius * $c;

return number_format($distance, 2) . ' km';
}


@endphp
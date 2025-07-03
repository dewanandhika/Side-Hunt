@extends('Dewa.Base.Basic-page')

@section('css')
<style>
    .hfull {
        min-height: 100% !important;
        height: 100% !important;
        max-height: fit-content;
    }

    .hcont {
        min-height: 80vh;
    }

    .Deskripsi_area {
        width: 60% !important;
    }

    @media (max-width: 768px) {
        .Deskripsi_area {
            width: 93% !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container w-100 hcont gap-1 d-flex my-5 p-3 flex-column justify-content-start align-items-start">
    <div class="w-100 d-flex justify-content-start">
        <p class="clear-p fw-bold">Detil Pekerjaan</p>
    </div>
    <div class="w-100 flex-grow-1 shadow p-2 rounded-4 flex gap-1 justify-content-start align-items-start d-flex flex-md-row flex-column"
        style="min-height: 100%;">
        <div class="d-flex m-3 h-100 gap-5 flex-column justify-content-start align-items-center"
            style="min-height: 100%;">
            <h4 class="clear-p fw-bolder text-truncate w-100 text-center text-wrap" style="color: #2E2D2C;">
                {{{$data_pekerjaan[0]->nama}}}</h4>
            <div class="w-100 flex-grow-1 rounded-2 justify-content-start align-items-center" style="">
                <img class="rounded-2" src="{{ auto_asset('Dewa/img/f4030acf172260f3241cad5f4527a7d8.jpg') }}"
                    style="width: 100%; height: 100%;  object-fit: cover;" alt="">
            </div>
            <div class="h-25 w-100 gap-2 d-flex flex-column justify-content-start align-items-start">
                <div class="d-flex flex-row gap-2 justify-content-center align-items-center">
                    <i class="bi bi-calendar2-plus"></i>
                    <p class="clear-p" style="font-size: 10px; color: #2E2D2C;">
                        {{{timeAgo($data_pekerjaan[0]['created_at'])}}}</p>
                </div>
                <div class="d-flex flex-row gap-2 justify-content-center align-items-center">
                    <i class="bi bi-pin-map clear-p"></i>
                    @if(session('account'))
                    <p class="clear-p" style="font-size: 12px; color: #2E2D2C;">
                        {{{$data_pekerjaan[0]['alamat']." (".hitungJarak($data_pekerjaan[0]['longitude'],
                        $data_pekerjaan[0]['latitude'],
                        session('account')['longitude'], session('account')['latitude']).")"}}}</p>

                    @else
                    <p class="clear-p" style="font-size: 12px; color: #2E2D2C;">
                        {{{$data_pekerjaan[0]['alamat']}}}
                    </p>
                    @endif
                </div>
                <div class="d-flex flex-row gap-2 justify-content-center align-items-center">
                    <i class="bi bi-coin clear-p"></i>
                    <p class="clear-p" style="font-size: 12px; color: #2E2D2C;">{{{$data_pekerjaan[0]->min_gaji." -
                        ".$data_pekerjaan[0]->max_gaji}}}</p>
                </div>
                <div class="d-flex flex-row gap-2 justify-content-center align-items-center">
                    <i class="bi bi-calendar4-range clear-p"></i>
                    <p class="clear-p" style="font-size: 12px; color: #2E2D2C;">{{{date('d-m-Y',
                        strtotime($data_pekerjaan[0]->start_job))." hingga ".date('d-m-Y',
                        strtotime($data_pekerjaan[0]->end_job))}}}</p>
                </div>
                @if(session()->has('account'))
                @if(session('account')['role']!='mitra')
                @if(now()<$data_pekerjaan[0]->deadline_job && ($history->isEmpty()))
                    <div class="d-flex flex-row gap-2 justify-content-center align-items-center">
                        <p class="clear-p" style="font-size: 12px; color: #2E2D2C;">Pendaftaran pekerjaan ini akan
                            ditutup
                            pada {{{date('d-m-Y H:i:s', strtotime($data_pekerjaan[0]->deadline_job))}}}</p>
                    </div>
                    <button class="btn btn-warning mt-2 w-100"
                        onclick="ValidasiPendaftaran('{{{$data_pekerjaan[0]->id}}}')">Lamar Sekarang</button>
                    @elseif(!$history->isEmpty())
                    <div class="w-100 gap-2 d-flex flex-row justify-content-evenly align-items-center">
                        <button class="btn btn-dark mt-2 w-100" disabled>Anda Sudah Mendaftar</button>
                        <button class="btn btn-info mt-2 w-100">Chat Pemberi Kerja</button>
                    </div>
                    @else
                    <div class="d-flex flex-row gap-2 justify-content-center align-items-center">
                        <p class="clear-p opacity-50" style="font-size: 12px; color: #2E2D2C;">Pendaftaran pekerjaan ini
                            sudah ditutup
                            pada {{{date('d-m-Y H:i:s', strtotime($data_pekerjaan[0]->deadline_job))}}}</p>
                    </div>
                    @endif


                    @if(!$history->isEmpty())
                    <div class="container my-5">
                        <h4 class="mb-4">History Lamaran Kerja</h4>
                        <div class="row">
                            <div class="col-12 col-md-8 mx-auto">
                                <div class="d-flex flex-column">
                                    <!-- Step 1 -->
                                    @if($history[0]->status=='tunda')
                                    <div class="d-flex align-items-start position-relative pb-4">
                                        <span class="position-relative me-1">
                                            <span class="bg-primary rounded-circle d-inline-block"
                                                style="width:16px;height:16px;"></span>
                                            <!-- Vertical Line -->
                                            <span
                                                class="position-absolute top-100 start-50 translate-middle-x bg-primary"
                                                style="width:2px;height:40px;z-index:0;"></span>
                                        </span>
                                        <div>
                                            <div class="fw-bold">Lamaran Disubmit</div>
                                            <small class="text-muted">Lamaran kamu sudah dikirim ke perusahaan.</small>
                                        </div>
                                    </div>
                                    <!-- Step 2 -->
                                     @elseif($history[0]->status=='ditolak')
                                    <div class="d-flex align-items-start position-relative pb-4">
                                        <span class="position-relative me-1">
                                            <span class="bg-info rounded-circle d-inline-block"
                                                style="width:16px;height:16px;"></span>
                                            <span class="position-absolute top-100 start-50 translate-middle-x bg-info"
                                                style="width:2px;height:40px;z-index:0;"></span>
                                        </span>
                                        <div>
                                            <div class="fw-bold">Diterima</div>
                                            <small class="text-muted">Lamaran Anda Diterima</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start position-relative pb-4">
                                        <span class="position-relative me-1">
                                            <span class="bg-danger rounded-circle d-inline-block"
                                                style="width:16px;height:16px;"></span>
                                        </span>
                                        <div>
                                            <div class="fw-bold">Ditolak</div>
                                            <small class="text-muted">Lamaran Anda Ditolak</small>
                                        </div>
                                    </div>
                                    @elseif($history[0]->status=='interview')
                                    <div class="d-flex align-items-start position-relative pb-4">
                                        <span class="position-relative me-1">
                                            <span class="bg-primary rounded-circle d-inline-block"
                                                style="width:16px;height:16px;"></span>
                                            <!-- Vertical Line -->
                                            <span
                                                class="position-absolute top-100 start-50 translate-middle-x bg-primary"
                                                style="width:2px;height:40px;z-index:0;"></span>
                                        </span>
                                        <div>
                                            <div class="fw-bold">Lamaran Disubmit</div>
                                            <small class="text-muted">Lamaran kamu sudah dikirim ke perusahaan.</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start position-relative pb-4">
                                        <span class="position-relative me-1">
                                            <span class="bg-warning rounded-circle d-inline-block"
                                                style="width:16px;height:16px;"></span>
                                            <span
                                                class="position-absolute top-100 start-50 translate-middle-x bg-warning"
                                                style="width:2px;height:40px;z-index:0;"></span>
                                        </span>
                                        <div>
                                            <div class="fw-bold">Dalam Tahap interview</div>
                                            <small class="text-muted">Lihat Lamaran Anda</small>
                                        </div>
                                    </div>
                                    @elseif($history[0]->status=='Gagal')
                                    <div class="d-flex align-items-start position-relative pb-4">
                                        <span class="position-relative me-1">
                                            <span class="bg-info rounded-circle d-inline-block"
                                                style="width:16px;height:16px;"></span>
                                        </span>
                                        <div>
                                            <div class="fw-bold">Interview Gagal</div>
                                            <small class="text-muted">Lamaran Berhenti Sampai Disini</small>
                                        </div>
                                    </div>
                                    <!-- Step 3 -->
                                    @elseif($history[0]->status=='Menunggu Pekerjaan')
                                    <div class="d-flex align-items-start position-relative pb-4">
                                        <span class="position-relative me-1">
                                            <span class="bg-primary rounded-circle d-inline-block"
                                                style="width:16px;height:16px;"></span>
                                            <!-- Vertical Line -->
                                            <span
                                                class="position-absolute top-100 start-50 translate-middle-x bg-primary"
                                                style="width:2px;height:40px;z-index:0;"></span>
                                        </span>
                                        <div>
                                            <div class="fw-bold">Lamaran Disubmit</div>
                                            <small class="text-muted">Lamaran kamu sudah dikirim ke perusahaan.</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start position-relative pb-4">
                                        <span class="position-relative me-1">
                                            <span class="bg-warning rounded-circle d-inline-block"
                                                style="width:16px;height:16px;"></span>
                                            <span
                                                class="position-absolute top-100 start-50 translate-middle-x bg-warning"
                                                style="width:2px;height:40px;z-index:0;"></span>
                                        </span>
                                        <div>
                                            <div class="fw-bold">Dalam Tahap interview</div>
                                            <small class="text-muted">Lihat Lamaran Anda</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start position-relative pb-4">
                                        <span class="position-relative me-1">
                                            <span class="bg-info rounded-circle d-inline-block"
                                                style="width:16px;height:16px;"></span>
                                            <span class="position-absolute top-100 start-50 translate-middle-x bg-info"
                                                style="width:2px;height:40px;z-index:0;"></span>
                                        </span>
                                        <div>
                                            <div class="fw-bold">Diterima</div>
                                            <small class="text-muted">Lamaran Anda Diterima</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start position-relative pb-4">
                                        <span class="position-relative me-1">
                                            <span class="bg-info rounded-circle d-inline-block"
                                                style="width:16px;height:16px;"></span>
                                            <span class="position-absolute top-100 start-50 translate-middle-x bg-info"
                                                style="width:2px;height:40px;z-index:0;"></span>
                                        </span>
                                        <div>
                                            <div class="fw-bold">Menunggu Bekerja</div>
                                            <div class="d-flex flex-column gap-0">
                                                <small class="text-muted">{{{$data_pekerjaan[0]->start_job}}} Mulai Bekerja</small>
                                                <a class="text-muted" style="font-size: 10px;" href="https://maps.google.com/?q={{{$data_pekerjaan[0]->latitude}}},{{{$data_pekerjaan[0]->longitude}}}">klik untuk ke lokasi pekerjaan</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Step 4 -->
                                    
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @elseif(session('account')['role']=='mitra')
                    <button class="btn btn-warning mt-5 w-100"
                        onclick="window.location.href='/daftar-Pelamar/{{{$data_pekerjaan[0]->id}}}'">Daftar
                        Pelamar</button>
                    @endif
                    @else
                    <button class="btn btn-info mt-2 w-100" onclick="window.location.href='/Login'">Login Untuk
                        Mendaftar</button>
                    @endif





            </div>
        </div>
        <div class="vr d-none d-md-flex"></div>
        <div class="m-3 p-3 h-100 d-flex justify-content-between Deskripsi_area d-flex flex-column gap-5">
            <div class="h-75">
                <h3 class="fw-bold">DESKRIPSI</h3>
                <hr>
                {!! $data_pekerjaan[0]->deskripsi !!}
            </div>

            <div class="">
                <h6 class="fw-bold">Tagg</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($data_pekerjaan[0]['kriteria'] as $kriteria) <span
                        class="badge w-auto text-wrap text-start fs-6 bg-prim-me">
                        {{{$kriteria}}}</span>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@section('script')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    async function ValidasiPendaftaran(idPekerjaan) {
        let route = '/Lamar/' + idPekerjaan;
        console.log('route: ', route);
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Pemberi kerja akan meninjau data preferensi usermu, klik Ya jika yakin!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Daftar!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/Lamar/' + idPekerjaan, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        // tambahkan header lain jika perlu, misal token, dll
                    }, body: JSON.stringify({
                        _token: csrfToken,
                    })
                }).then(response => response.json())
                    .then(data => {
                        console.log('Response dari server:', data);
                        if (data.success == true) {
                            Swal.fire({
                                title: "Berhasil Mendaftar!",
                                text: "Biasanya butuh 1 - 2 minggu untuk HRD memproses lamaranmu, semoga dilancarkan!.",
                                icon: "success"
                            }).then((result) => {
                                location.reload();
                            });
                        }
                        else {
                            fail('Gagal Mendaftar', data.success)
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

            }
        });
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

function timeAgo($datetime) {
$now = new DateTime();
$past = new DateTime($datetime);
$diff = $now->diff($past);

if ($diff->y > 0) {
return $diff->y . ' tahun yang lalu';
} elseif ($diff->m > 0) {
return $diff->m . ' bulan yang lalu';
} elseif ($diff->d > 0) {
return $diff->d . ' hari yang lalu';
} elseif ($diff->h > 0) {
return $diff->h . ' jam yang lalu';
} elseif ($diff->i > 0) {
return $diff->i . ' menit yang lalu';
} elseif ($diff->s > 0) {
return $diff->s . ' detik yang lalu';
} else {
return 'Baru saja';
}
}



@endphp
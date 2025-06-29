@extends('Dewa.Base.Basic-page')

@section('css')
<!-- <link rel="stylesheet" href="{{ auto_asset('Dewa/css/?.css') }}"> -->
<style>
    body {
        background: white;
    }

    .table-bg {
        background: white;
        border-radius: 24px;
        box-shadow: 0 4px 32px #00000012;
        padding: 2rem;
    }

    .table th {
        background: #444 !important;
        border: none;
        font-weight: 500;
        font-size: 1rem;
        color: #ffffff;
        vertical-align: middle;
    }

    .table td {
        background: transparent !important;
        border: none;
        font-size: 1rem;
        vertical-align: middle;
    }

    .see-more-btn {
        background: #4242423c;
        color: #424242;
        border-radius: 999px;
        font-weight: 500;
        border: none;
        transition: background 0.15s;
    }

    .see-more-btn:hover {
        background: #42424271;
        color: #222;
    }

    .status-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-right: 0.25rem;
    }

    /* Pagination custom */
    .pagination .page-item .page-link {
        background: white;
        color: #575757;
        border: none;
        border-radius: 50% !important;
        margin: 0 0.15rem;
    }

    .pagination .active .page-link {
        background: #575757;
        color: white;
    }

    .pagination .page-link:focus {
        box-shadow: none;
    }

    /* Dropdown style tweak */
    .form-select {
        border-radius: 1rem;
        background: white;
    }

    .fs-10 {
        font-size: 10px !important;
    }

    .fs-12 {
        font-size: 12px !important;
    }
</style>
@endsection
@section('add-onn')
<div class="offcanvas ToInterview offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="formBackdrop"
    aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="staticBackdropLabel">Data Interview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="/pelamar/interview" method="POST">
            @csrf

            <div class="mb-3">
                <label for="tanggal_interview" class="form-label">Tanggal Interview*</label>
                <input type="datetime-local" class="form-control" id="tanggalInterview" name="tanggal_interview"
                    value="{{ old('tanggal_interview') }}" required>
                @error('tanggal_interview')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="link_nterview" class="form-label">Link Interview*</label>
                <input type="url" class="form-control" id="linkInterview" name="link_interview"
                    value="{{ old('link_interview') }}" placeholder="https://example.com" required>
                @error('link_interview')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="Message_Interview" class="form-label">Pesan Untuk User (opsional)</label>
                <input type="text" class="form-control" id="linkInterview" name="pesan_interview"
                    value="{{ old('pesan_interview') }}" placeholder="Jaringan harus normal">
                @error('pesan_interview')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="text" class="form-control id" id="id" value="{{ old('id') }}" name="id" placeholder=""
                    style="display: none;">
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <button type="submit" class="btn btn-primary w-100">Set Interview</button>
        </form>
    </div>
</div>

@endsection
@section('content')
<div class="container py-5">
    <div class="table-bg">
        <div
            class="d-flex justify-content-md-between justify-content-start  flex-column-reverse flex-md-row gap-2 align-items-md-center align-items-start mb-4">
            <div class="col-3 justify-content-start align-items-start">
                <select class="form-select" onclick="set_to_status(this)">
                    <option>Status</option>
                    <option>Active</option>
                    <option>Finished</option>
                    <option>Delayed</option>
                </select>
            </div>
            <h3 class="text-center w-100 flex-grow-1 mb-0 fw-bold" style="color: #2c2c2c;">Daftar Pelamar (Semua)</h3>
            <div class="col-3"></div>
        </div>
        <div class="table-responsive" style="min-height: 45vh;">

            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center">Tanggal Daftar</th class="text-center">
                        <th class="text-center">Pekerjaan yang dilamar</th class="text-center">
                        <th class="text-center">Nama Pelamar</th class="text-center">
                        <th class="text-center">Keahlian</th class="text-center">
                        <th class="text-center">Interview</th class="text-center">
                        <th class="text-center">Jadwal Interview</th class="text-center">
                        <th class="text-center">Message</th class="text-center">
                        <th class="text-center">Action</th class="text-center">
                    </tr>
                </thead>
                <tbody>
                    @if(!count($pelamars)==0)
                    @foreach($pelamars as $pelamar)
                    <tr class="@if(in_array($pelamar->status_job, ['ditolak','Gagal'])) opacity-50 @endif">
                        <td class="fs-12">{{{$pelamar->daftar}}}</td>
                        <td onclick="window.location.href='/Pelamar/Profile/{{{$pelamar->id}}}'">
                            {{{$pelamar->nama}}}

                        </td>
                        <td>
                            <div class="d-flex flex-row gap-2">
                                <p class="clear-p text-truncate">{{{$pelamar->nama_pelamar}}}
                                <div class="d-flex flex-row gap-1 justify-content-center align-items-center">
                                    <p class="clear-p">3.5</p>
                                    <i class="bi bi-star-fill fs-10"></i>
                                </div>

                                </p>

                            </div>
                        </td>
                        <td style="font-size: 10px;">{{{$pelamar->preferensi_user}}}</td>
                        <td>
                            @if($pelamar->link!=null)
                            <a href="{{{$pelamar->link}}}">klik</a>
                            @endif
                        </td>
                        <td>
                            @if($pelamar->jadwal!=null)
                            <p class="clear-p" style="font-size: 10px;">{{{\Carbon\Carbon::parse($pelamar->jadwal)->translatedFormat('l, d F Y H:i')}}}</p>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(!(in_array($pelamar->status_job, ['ditolak','Gagal'])))
                            <button class="btn btn-toolbar">
                                <i class="bi bi-envelope text-center"></i>
                            </button>
                            @endif

                        </td>

                        <td>
                            <div class="d-flex flex-row gap-2 justify-content-center align-items-center">
                                @if($pelamar->status_job=='tunda')
                                <button class="btn btn-success rounded-5"
                                    onclick="lanjut_interview('{{{$pelamar->id_pelamars}}}')" data-bs-toggle="offcanvas"
                                    data-bs-target="#formBackdrop" aria-controls="staticBackdrop">Interview</button>
                                <button class="btn btn-danger rounded-5"
                                    onclick="tolak('{{{$pelamar->id_pelamars}}}', alasan)">Tolak</button>
                                @elseif($pelamar->status_job=='interview')
                                <button class="btn btn-success rounded-5"
                                    onclick="interview_sukses('{{{$pelamar->id_pelamars}}}')">Terima</button>
                                <button class="btn btn-danger rounded-5"
                                    onclick="interview_gagal('{{{$pelamar->id_pelamars}}}', alasan)">Gagal</button>
                                @elseif($pelamar->status_job=='ditolak')
                                <button class="btn btn-disabled">Ditolak (alasan)</button>
                                @elseif($pelamar->status_job=='Gagal')
                                <button class="btn btn-disabled">Tidak Lolos Interview (alasan)</button>

                                @else
                                <button class="btn btn-disabled">Diterima: {{{$pelamar->status_job}}}</button>
                                @endif

                                @if(in_array($pelamar->status_job, ['tunda', 'interview','ditolak','Gagal']))
                                <button class="btn btn-toolbar">
                                    <i class="bi bi-trash text-black"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else

                    @endif
                </tbody>
            </table>
            @if(count($pelamars)==0)
            <div class="d-flex w-100 justify-content-center mt-4 align-items-center">
                <p class="clear-p">Belum ada pelamar</p>
            </div>
            @endif
        </div>
        <!-- Pagination -->
        <!-- <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination mb-0">
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                    </li>
                    <li class="page-item active"><span class="page-link">1</span></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><span class="page-link">...</span></li>
                    <li class="page-item"><a class="page-link" href="#">18</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div> -->
    </div>
</div>
@endsection

@section('script')
<script>
    @if ($errors->any())
        show_form_interview()
    @endif

    function show_form_interview() {
        var offcanvasElement = document.getElementById('formBackdrop');
        var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
        offcanvas.show();
    }
    function lanjut_interview(idLamaran) {
        let id = document.querySelector('.ToInterview .id')
        id.value = idLamaran;
    }
    function tolak(idLamaran, alasan) {
        // form('/pelamar/terima', 'ditolak', idLamaran, alasan);
    }
    function interview_sukses(idLamaran) {
        form('/pelamar/terima', 'Menunggu Pekerjaan', idLamaran, null);
    }
    function interview_gagal(idLamaran) {
        form('/pelamar/terima', 'Gagal', idLamaran, null);
    }


    function form(link, status, idLamaran, alasan) {
        fetch(link, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            }, body: JSON.stringify({
                _token: csrfToken,
                status: status,
                id_lamaran: idLamaran,
                alasan: alasan,
            })
        }).then(response => response.json())
            .then(data => {
                location.reload();
            })
            .catch(error => {
                fail('Gagal', error);
            });
    }
</script>
@endsection
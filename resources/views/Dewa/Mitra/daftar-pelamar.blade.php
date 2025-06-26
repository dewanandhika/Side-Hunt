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
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="table-bg">
        <div class="d-flex justify-content-between flex-column-reverse flex-md-row gap-2 align-items-center mb-4">
            <div class="col-3 justify-content-start align-items-start">
                <select class="form-select">
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
            <table class="table align-middle mb-0" >
                <thead>
                    <tr>
                        <th class="text-center">Tanggal Daftar</th class="text-center">
                        <th class="text-center">Pekerjaan yang dilamar</th class="text-center">
                        <th class="text-center">Nama Pelamar</th class="text-center">
                        <th class="text-center">Keahlian</th class="text-center">
                        <th class="text-center">Rating</th class="text-center">
                        <th class="text-center">Profile</th class="text-center">
                        <th class="text-center">Text this person</th class="text-center">
                        <th class="text-center">Action</th class="text-center">
                    </tr>
                </thead>
                <tbody>
                    @if(!count($pelamars)==0)
                    @foreach($pelamars as $pelamar)
                    <tr>
                        <td>{{{$pelamar->daftar}}}</td>
                        <td>
                            {{{$pelamar->nama}}}
                        </td>
                        <td>{{{$pelamar->nama_pelamar}}}</td>
                        <td>{{{$pelamar->preferensi_user}}}</td>
                        <td>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </td>
                        <td>
                            <button
                                class="see-more-btn d-flex gap-1 flex-row px-3 py-1 justify-content-center align-items-center">
                                <p class="clear-p d-none d-md-flex">See more</p>
                                <i class="bi bi-eye clear-p"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-secondary d-flex rounded-5 flex-row gap-2">
                                <p class="clear-p d-none d-md-flex">Chat</p>
                                <i class="bi bi-send-fill"></i>
                            </button>

                        </td>
                        <td>
                            <div class="d-flex flex-row gap-2">
                                @if($pelamar->status_job=='tunda')
                                <button class="btn btn-success rounded-5">Terima</button>
                                <button class="btn btn-danger rounded-5">Tolak</button>
                                @endif
                                <button class="btn btn-toolbar">
                                    <i class="bi bi-trash text-black"></i>
                                </button>
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
                <p>Belum ada pelamar</p>
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

</script>
@endsection
@extends('layouts.base')

@section('content')
    <form action="/usages/{{ $usage->id }}" method="post" id="PutPemakaian">
        @csrf
        @method('PUT')


        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title ?? 'x' }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">DataTable</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div>&nbsp;</div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div style="display: flex; align-items: center;">
                                        <i class="fas fa-tint" style="font-size: 28px; margin-right: 8px;"></i>
                                        <b>Edit Pemakaian</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="alert alert-light" role="alert">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="customer">Nama Pemakai</label>
                                        <input type="text" class="form-control" name="customer" id="customer"
                                            value="{{ $usage->customers->nama }}" readonly>
                                        <small class="text-danger" id="msg_customer"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="id_instalasi">Kode Instalasi</label>
                                        <input type="text" class="form-control hitungan" id="id_instalasi"
                                            name="id_instalasi" value="{{ $usage->installation->kode_instalasi }}" readonly>
                                        <small class="text-danger" id="msg_id_instalasi"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="tgl_akhir">Tanggal Akhir</label>
                                        <input type="text" class="form-control date" name="tgl_akhir"
                                            id="tgl_akhir"value=" {{ date('d/m/Y') }}">
                                        <small class="text-danger">{{ $errors->first('tgl_akhir') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="awal">Awal Pemakaian</label>
                                        <input type="text" class="form-control hitungan input-nilai-awal" id="awal"
                                            name="awal" value="{{ $usage->akhir }}">
                                        <small class="text-danger" id="msg_awal"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="akhir">Akhir Pemakaian</label>
                                        <input type="text" class="form-control total hitungan input-nilai-akhir"
                                            name="akhir" value="{{ $usage->akhir }}" id="akhir">
                                        <small class="text-danger" id="msg_akhir"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="text" class="form-control" name="jumlah"
                                            value="{{ $usage->jumlah }}" id="jumlah" readonly>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button id="kembali" class="btn btn-light btn-sm">Kembali</button>
                            <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanPemakaian"
                                style="float: right; margin-left: 10px;">
                                <span class="icon text-white-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-sign-intersection-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM7.25 4h1.5v3.25H12v1.5H8.75V12h-1.5V8.75H4v-1.5h3.25z" />
                                    </svg>
                                </span>
                                <span class="text" style="float: right;">Simpan Pembayaran</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/usages';
        });

        jQuery.datetimepicker.setLocale('de');
        $('.date').datetimepicker({
            i18n: {
                de: {
                    months: [
                        'Januar', 'Februar', 'März', 'April',
                        'Mai', 'Juni', 'Juli', 'August',
                        'September', 'Oktober', 'November', 'Dezember',
                    ],
                    dayOfWeek: [
                        "So.", "Mo", "Di", "Mi",
                        "Do", "Fr", "Sa.",
                    ]
                }
            },
            timepicker: false,
            format: 'd/m/Y'
        });

        $(document).on('change', '.input-nilai-akhir', function(e) {
            e.preventDefault()

            var id = $(this).attr('id').split('_')[1]
            var nilai_akhir = $(this).val()
            var nilai_awal = $('#awal_' + id).val()

            if (nilai_akhir - nilai_awal < 0) {
                Swal.fire({
                    title: 'Periksa kembali nilai yang dimasukkan',
                    text: 'Nilai Akhir tidak boleh lebih kecil dari Nilai Awal',
                    icon: 'warning',
                })

                $(this).val(nilai_awal)
                return;
            }

            var jumlah = nilai_akhir - nilai_awal
            $('#jumlah' + id).val(jumlah)
        })
    </script>
@endsection

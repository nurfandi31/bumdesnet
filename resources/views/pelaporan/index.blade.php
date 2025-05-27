@extends('Layout.base')
@php
    $thn_awal = explode('-', $busines->created_at)[0];
@endphp
@section('content')
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
    <form action="/installations" method="post" id="FormRegisterPermohonan">
        @csrf
        <input type="hidden" name="customer_id" id="customer_id">

        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="tahun">Tahun</label>
                                    <select class="choices form-control" name="tahun" id="tahun">
                                        <option value="">---</option>
                                        @for ($i = $thn_awal; $i <= date('Y'); $i++)
                                            <option {{ $i == date('Y') ? 'selected' : '' }} value="{{ $i }}">
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="bulan">Bulan</label>
                                    <select class="choices form-control" name="bulan" id="bulan">
                                        <option value="">---</option>
                                        <option value="01">01. JANUARI</option>
                                        <option value="02">02. FEBRUARI</option>
                                        <option value="03">03. MARET</option>
                                        <option value="04">04. APRIL</option>
                                        <option value="05">05. MEI</option>
                                        <option value="06">06. JUNI</option>
                                        <option value="07">07. JULI</option>
                                        <option value="08">08. AGUSTUS</option>
                                        <option value="09">09. SEPTEMBER</option>
                                        <option value="10">10. OKTOBER</option>
                                        <option value="11">11. NOVEMBER</option>
                                        <option value="12">12. DESEMBER</option>
                                    </select>
                                    <small class="text-danger" id="msg_bulan"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="hari">Tanggal</label>
                                    <select class="choices form-control" name="hari" id="hari">
                                        <option value="">---</option>
                                        @for ($j = 1; $j <= 31; $j++)
                                            @if ($j < 10)
                                                <option value="0{{ $j }}">0{{ $j }}</option>
                                            @else
                                                <option value="{{ $j }}">{{ $j }}</option>
                                            @endif
                                        @endfor
                                    </select>
                                    <small class="text-danger" id="msg_hari"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="position-relative mb-3">
                                    <label for="laporan">Nama Laporan</label>
                                    <select class="choices form-control" name="laporan" id="laporan">
                                        <option value="">---</option>
                                        @foreach ($laporan as $lap)
                                            <option value="{{ $lap->file }}">
                                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.
                                                {{ $lap->nama_laporan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="msg_laporan"></small>
                                </div>
                            </div>
                            <div id="subLaporan" class="col-md-6">
                                <div class="position-relative mb-3">
                                    <label for="sub_laporan1">Nama Sub Laporan</label>
                                    <select class="choices form-control" name="sub_laporan1" id="sub_laporan1">
                                        <option value="">---</option>
                                    </select>
                                    <small class="text-danger" id="msg_sub_laporan1"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-0 p-0 pe-3 ps-3 pb-2">
                                <div class="d-grid">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="col-md-2 mb-0 p-0 pe-3 ps-3 pb-2">
                                <div class="d-grid">
                                    <button id="SimpanSaldo" class="btn btn-danger">
                                        Simpan Saldo
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2 mb-0 p-0 pe-3 ps-0 pb-2">
                                <div class="d-grid">
                                    <button id="Excel" class="btn btn-success">
                                        Excel
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2 mb-0 p-0 pe-3 ps-0 pb-2">
                                <div class="d-grid">
                                    <button id="Preview" class="btn btn-secondary">
                                        Preview
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-card mb-3 card">
            <div class="card-body" id="LayoutPreview">
                <br>
                <div class="p-2"></div>
                <script>
                    (function() {
                        'use strict';
                        window.addEventListener('load', function() {
                            var forms = document.getElementsByClassName('needs-validation');
                            var validation = Array.prototype.filter.call(forms, function(form) {
                                form.addEventListener('submit', function(event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        }, false);
                    })();
                </script>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        const currentMonth = new Date().getMonth() + 1;
        const formattedMonth = currentMonth.toString().padStart(2, '0');
        document.getElementById('bulan').value = formattedMonth;

        $(document).on('change', '#tahun, #bulan', function(e) {
            e.preventDefault()

            var file = $('select#laporan').val()
            subLaporan(file)
        })

        $(document).on('change', '#laporan', function(e) {
            e.preventDefault()

            var file = $(this).val()
            subLaporan(file)
        })

        function subLaporan(file) {
            var tahun = $('select#tahun').val()
            var bulan = $('select#bulan').val()

            if (file == 'calk') {
                $('#namaLaporan').removeClass('col-md-6')
                $('#namaLaporan').addClass('col-md-12')
                $('#subLaporan').removeClass('col-md-6')
                $('#subLaporan').addClass('col-md-12')
            }

            $.get('/pelaporan/sub_laporan/' + file + '?tahun=' + tahun + '&bulan=' + bulan, function(result) {
                $('#subLaporan').html(result)
            })
        }

        $(document).on('click', '#Preview', async function(e) {
            e.preventDefault()

            $(this).parent('form').find('#type').val('pdf')
            var file = $('select#laporan').val()
            if (file == 'calk') {
                await $('textarea#sub_laporan1').val(quill.container.firstChild.innerHTML)
            }

            var form = $('#FormPelaporan')
            if (file != '') {
                form.submit()
            }
        })

        $(document).on('click', '#Excel', async function(e) {
            e.preventDefault()

            $(this).parent('form').find('#type').val('excel')
            var file = $('select#laporan').val()
            if (file == 'calk') {
                await $('textarea#sub_laporan1').val(quill.container.firstChild.innerHTML)
            }

            var form = $('#FormPelaporan')
            console.log(form.serialize())
            if (file != '') {
                form.submit()
            }
        })

        let childWindow, loading;
        $(document).on('click', '#SimpanSaldo', function(e) {
            e.preventDefault()

            var tahun = $('select#tahun').val()
            var bulan = $('select#bulan').val()
            if (bulan < 1) {
                bulan = 0
            }

            var nama_bulan = namaBulan(bulan)

            var pesan = nama_bulan + " sampai Desember "
            if (bulan == '12') {
                pesan = nama_bulan + " "
            }

            loading = Swal.fire({
                title: "Mohon Menunggu..",
                html: "Menyimpan Saldo Bulan " + pesan + tahun,
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            })

            var link = '/pelaporan/simpan_saldo/' + tahun + '/' + bulan;
            childWindow = window.open(link, '_blank');
        })

        window.addEventListener('message', function(event) {
            if (event.data === 'closed') {
                loading.close()
                window.location.reload()
            }
        })

        function namaBulan(bulan) {
            switch (bulan) {
                case '01s':
                    return 'Januari';
                    break;
                case '02':
                    return 'Februari';
                    break;
                case '03':
                    return 'Maret';
                    break;
                case '04':
                    return 'April';
                    break;
                case '05':
                    return 'Mei';
                    break;
                case '06':
                    return 'Juni';
                    break;
                case '07':
                    return 'Juli';
                    break;
                case '08':
                    return 'Agustus';
                    break;
                case '09':
                    return 'September';
                    break;
                case '10':
                    return 'Oktober';
                    break;
                case '11':
                    return 'November';
                    break;
                case '12':
                    return 'Desember';
                    break;
            }

            return 'Januari';
        }
    </script>
@endsection

@extends('layout.base')
@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
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
    <form action="/packages" method="post" id="tambahpaket">
        @csrf

        <input type="hidden" name="abodemen" id="abodemen" value="{{ $tampil_settings->abodemen }}">
        <input type="hidden" name="denda" id="denda" value="{{ $tampil_settings->denda }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <!-- Gambar -->
                            <img src="../assets/static/images/logo/sop1.png" style="max-height: 200px; margin-right: 20px;"
                                class="img-fluid d-none d-lg-block">
                            <div class="w-100">
                                <h4 class="alert-heading"><b>Tentukan Harga Paket</b></h4>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="position-relative mb-2">
                                            <label for="kelas" class="form-label">Kelas</label>
                                            <input autocomplete="off" maxlength="16" type="text" name="kelas"
                                                id="kelas" class="form-control form-control-sm">
                                            <small class="text-danger" id="msg_kelas"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @for ($i = 0; $i < $jumlah_blok; $i++)
                                        <div class="col-{{ 12 / $jumlah_blok }}">
                                            <div class="position-relative mb-2">
                                                <label for="block_1" class="form-label">{{ $blok[$i]['nama'] }} .
                                                    [ {{ $blok[$i]['jarak'] }} ]
                                                </label>
                                                <input autocomplete="off" maxlength="16" type="text" name="blok[]"
                                                    id="block_{{ $i }}"
                                                    class="form-control form-control-sm block">
                                                <small class="text-danger" id="msg_block_{{ $i }}"></small>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <hr>
                                <div class="col-12 d-flex justify-content-end">
                                    <button id="kembali" class="btn btn-light btn-icon-split">
                                        <span class="text">Kembali</span>
                                    </button>

                                    <button type="button" class="btn btn-info block" data-bs-toggle="modal"
                                        data-bs-target="#border-less" style="float: right; margin-left: 10px;">
                                        Block
                                    </button>
                                    <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanPaket"
                                        class="btn btn-dark" style="float: right; margin-left: 10px;">
                                        <span class="text" style="float: right;">Simpan Harga</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('modal')
    {{-- modal tampil block --}}
    <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Tambah Block Baru</b></h4>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <hr>
                <div class="modal-body">
                    @include('paket.block_paket')
                </div>
            </div>
        </div>
    </div>
    {{-- end modal tampil block --}}
@endsection

@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/packages';
        });
        // block paket

        $(document).on('click', '#blockinput', function(e) {
            e.preventDefault()

            var container = $('#inputFromblock')
            var row = $('<div>').addClass('row mb-3')
            var block = $('#RowBlock').html()

            row.html(block)
            container.append(row)
        })

        $('#blockinput').trigger('click')

        $(document).on('click', '#SimpanBlock', function(e) {
            e.preventDefault();
            var form = $('#Fromblock');
            var actionUrl = form.attr('action');

            var toastMixin = Swal.mixin({
                toast: true,
                icon: 'success',
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            $.ajax({
                type: 'GET',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: 'Pembaruhan Block Paket Berhasil'
                        });
                        // window.location.href = '/packages/';
                        setTimeout(() => window.location.reload(), 3000);
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');
                }
            });
        });
        //endblok
    </script>
    <script>
        // create 
        $(".block").maskMoney({
            allowNegative: true
        });

        $(document).on('click', '#SimpanPaket', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#tambahpaket');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Tambahkan Paket Baru?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Tambahkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/packages/';
                            }
                        });
                    }
                },
                error: function(result) {
                    const response = result.responseJSON;

                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');

                    if (response && typeof response === 'object') {
                        $.each(response, function(key, message) {
                            $('#' + key)
                                .closest('.input-group.input-group-static')
                                .addClass('is-invalid');

                            $('#msg_' + key).html(message);
                        });
                    }
                }
            });
        });
        //endcreate
    </script>
@endsection

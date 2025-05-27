@extends('Layout.base')
@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
    $harga = json_decode($package->harga, true);
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
    <form action="/packages/{{ $package->id }}" method="post" id="formeditpaket">
        @csrf
        @method('PUT')

        <input type="hidden" name="abodemen" id="abodemen" value="{{ $tampil_settings->abodemen }}">
        <input type="hidden" name="denda" id="denda" value="{{ $tampil_settings->denda }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Bagian Informasi Customer -->
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <!-- Gambar -->
                            <img src="../../assets/static/images/logo/sop1.png"
                                style="max-height: 200px; margin-right: 20px;" class="img-fluid d-none d-lg-block">
                            <div class="w-100">
                                <h4 class="alert-heading"><b>Tentukan Harga Paket</b></h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="position-relative mb-2">
                                            <label for="kelas" class="form-label">Kelas</label>
                                            <input autocomplete="off" maxlength="16" type="text" name="kelas"
                                                id="kelas" class="form-control form-control-sm"
                                                value="{{ $package->kelas }}">
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
                                                    class="form-control form-control-sm block"
                                                    value="{{ number_format(isset($harga[$i]) ? $harga[$i] : '0', 2) }}">
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
                                    <button class="btn btn-secondary btn-icon-split" type="submit" id="EditPaket"
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
@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/packages';
        });
        // edit data
        $(".block").maskMoney({
            allowNegative: true
        });

        $(document).on('click', '#EditPaket', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#formeditpaket');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: 'Pembaruhan Kelas & Biaya Pemakaian Berhasil'
                        });

                        setTimeout(() => {
                            window.location.href = '/packages/';
                        }, 1500);
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
    </script>
@endsection

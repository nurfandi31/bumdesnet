@extends('Layout.base')
@php
    $status = $settings->swit_tombol ?? null;
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4" style="background-color: #00d9ff; border: 1mm solid white;">
                <div class="card-body pb-0">
                    <!-- Bagian Informasi Customer -->
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <div class="col-md-3 text-center">
                                <div class="d-inline-block border border-2 rounded bg-light shadow-sm"
                                    style="width: 120px; height: 120px; padding: 10px; display: flex; align-items: center; justify-content: left;">
                                    {!! $qr !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mb-2">
                            <h3 class="alert-heading">
                                <b>Nama Pelanggan: {{ $installations->customer->nama }}</b>
                            </h3>
                            <p class="mb-0">
                                Desa {{ $installations->village->nama }},
                                {{ $installations->alamat }}, [Koordinate: {{ $installations->koordinate }}].
                            </p>
                            <hr>
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <select class="choices form-control" name="caters" id="caters"
                                        style="height: 38px;">
                                        <option value="">Pilih Cater</option>
                                        @foreach ($caters as $cater)
                                            <option value="{{ $cater->id }}">
                                                {{ $cater->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                        value="{{ date('d/m/Y') }}" style="height: 38px;">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="4">Permohonan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    <span style="float: left;">Paket Instalasi</span>
                                    <span class="badge bg-success"
                                        style="float: right; width: 30%; padding: 5px; text-align: center;">
                                        {{ $installations->package->kelas }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    <span style="float: left;">No. Induk</span>
                                    <span class="badge bg-success"
                                        style="float: right; width: 30%; padding: 5px; text-align: center;">
                                        {{ $installations->kode_instalasi }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    <span style="float: left;">Desa</span>
                                    <span class="badge bg-success"
                                        style="float: right; width: 30%; padding: 5px; text-align: center;">
                                        {{ $installations->village->nama }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="4">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    <span style="float: left;">Abodemen</span>
                                    <span class="badge bg-success"
                                        style="float: right; width: 30%; padding: 5px; text-align: center;">
                                        {{ number_format($installations->abodemen, 2) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    <span style="float: left;">Status Instalasi</span>
                                    @if ($installations->status === 'R')
                                        <span class="badge bg-success"
                                            style="float: right; width: 30%; padding: 5px; text-align: center;">
                                            PAID
                                        </span>
                                    @elseif($installations->status === '0')
                                        <span class="badge bg-warning"
                                            style="float: right; width: 30%; padding: 5px; text-align: center;">
                                            UNPAID
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; font-size: 14px; padding: 8px; position: relative;">
                                    &nbsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form action="/installations/{{ $installations->id }}" method="post" id="FormEditPermohonan">
                        @csrf
                        @method('PUT')
                        <input type="text" name="status" id="status" value="EditData" hidden>
                        <div class="row">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="order">Tanggal Order</label>
                                            <input type="text" class="form-control date" name="order" id="order"
                                                aria-describedby="order" placeholder="order" value="{{ date('d/m/Y') }}">
                                            <small class="text-danger" id="msg_order"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat"
                                                aria-describedby="alamat" placeholder="Alamat"
                                                value="{{ $installations->alamat }}">
                                            <small class="text-danger" id="msg_alamat"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="koordinate">Koordinate</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control"
                                                placeholder="Masukkan Link Koordinate" aria-describedby="koordinate"
                                                name="koordinate" id="koordinate"
                                                value="{{ $installations->koordinate }}">
                                            <div class="input-group-append">
                                                {{-- https://www.google.com/maps/place/-7.462512371777572,%20110.1149253906747 --}}
                                                <span class="input-group-text" id="basic-addon2">
                                                    <a href="https://maps.google.com/" target="_blank"
                                                        style="color: rgb(75, 75, 75); text-decoration: none;">Google
                                                        Maps</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative mb-3">
                                            <label for="biaya_instalasi">Nominal</label>
                                            <input type="text" class="form-control" name="biaya_instalasi"
                                                id="biaya_instalasi" aria-describedby="biaya_instalasi"
                                                placeholder="biaya_instalasi"value="{{ number_format($installations->biaya_instalasi, 2) }}"
                                                disabled>
                                            <small class="text-danger" id="msg_biaya_instalasi"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="formEditjenis_paket">
                                </div>
                                <hr>

                                <div class="col-12 d-flex justify-content-end">
                                    <a href="/installations/permohonan" class="btn btn-light btn-icon-split">
                                        <span class="text">Kembali</span>
                                    </a>

                                    <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanEdit"
                                        class="btn btn-dark" style="float: right; margin-left: 10px;">
                                        <span class="text" style="float: right;">Simpan Perubahan</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#abodemen").maskMoney({
            allowNegative: true
        });

        $("#total").maskMoney({
            allowNegative: true
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

        $(document).on('click', '#SimpanEdit', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormEditPermohonan');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {

                    if (result.success) {
                        toastMixin.fire({
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(() => {
                            window.location.href = '/installations/{{ $installations->id }}';
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

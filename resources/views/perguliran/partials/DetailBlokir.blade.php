@extends('Layout.base')

@section('content')
    <form action="/installations/{{ $installation->id }}" method="post" id="Form_status_B">
        @csrf
        @method('PUT')
        <input type="text" name="status" id="status" value="{{ $installation->status }}" hidden>
        <input type="text" value="{{ number_format($tampil_settings->pasang_baru, 2) }}" name="pasang_baru" hidden>
        <input type="hidden" name="id" value="{{ $installation->id }}" id="id">
        <div class="page-heading">
            <br>
            <section class="section">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center flex-column">
                                    <div class="avatar avatar-2xl">
                                        <div class="d-inline-block border border-2 rounded bg-light shadow-sm"
                                            style="width: 125px; height: 125px; padding: 10px; display: flex; align-items: center; justify-content: left;">
                                            {!! $qr !!}
                                        </div>
                                    </div>

                                    <h4 class="mt-3">{{ $installation->customer->nama }}</h4>
                                    <p class="text-small">
                                        {{ $installation->village->nama }} {{ $installation->alamat }}</p>
                                </div>
                                <div class="row p-2">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="cabut">Tentukan Tanggal Cabut</label>
                                            <input type="text" class="form-control date" name="cabut" id="cabut"
                                                value="{{ date('d/m/Y') }}">
                                            <small class="text-danger" id="msg_cabut"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="kode_instalasi">Nik</label>
                                            <input type="text" class="form-control" name="kode_instalasi"
                                                id="kode_instalasi" value="{{ $installation->customer->nik }}" disabled>
                                            <small class="text-danger" id="msg_kode_instalasi"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h4 class="card-title"><b>Detail Installation Blokir</b></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>No. Induk</span>
                                            <span
                                                class="badge bg-warning badge-pill badge-round ms-1">{{ $installation->kode_instalasi }}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Tgl Order</span>
                                            <span
                                                class="badge bg-warning badge-pill badge-round ms-1">{{ \Carbon\Carbon::parse($installation->order)->format('d-m-Y') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Tgl Pasang</span>
                                            <span
                                                class="badge bg-warning badge-pill badge-round ms-1">{{ \Carbon\Carbon::parse($installation->pasang)->format('d-m-Y') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span> Paket Instalasi</span>
                                            <span
                                                class="badge bg-warning badge-pill badge-round ms-1">{{ $installation->package->kelas }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Abodemen</span>
                                            <span
                                                class="badge bg-warning badge-pill badge-round ms-1">{{ number_format($installation->abodemen, 2) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Status</span>
                                            @if ($installation->status === 'B')
                                                <span class="badge bg-warning">
                                                    Blokir
                                                </span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card ">
                            <div class="card-content ">
                                <div class="card-body pb-2 pt-2 pe-2 ps-2">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="/installations/blokir" class="btn btn-secondary btn-icon-split">
                                                    <span class="text-white">Kembali</span>
                                                </a>
                                                <button class="btn btn-success btn-icon-split"
                                                    data-id="{{ $installation->id }}" type="submit" id="Kembali_Status_A">
                                                    <span class="text-white">Kembali ke Aktif</span>
                                                </button>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-primary btn-icon-split" type="submit"
                                                    id="Simpan_status_B">
                                                    <span class="text-wehite">Cabut Sekarang</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
@section('script')
    <script>
        $(document).on('click', '#cetakBrcode', function(e) {
            e.preventDefault();
            window.open('/installations/cetak/{{ $installation->id }}', '_blank');
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

        $(document).on('click', '#Simpan_status_B', function(e) {
            e.preventDefault();
            $('small').html('');

            var btn = $(this);
            var originalText = btn.html();
            btn.html(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...'
            );
            btn.prop('disabled', true);
            var form = $('#Form_status_B');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            icon: "success",
                            draggable: true
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.href = '/installations/' + result.cabut.id;
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
        // mengembalikan status B ke A
        $(document).on('click', '#Kembali_Status_A', function(e) {
            e.preventDefault();

            var btn = $(this);
            var originalText = btn.html();
            btn.html(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...'
            );
            btn.prop('disabled', true);
            var cek_id = $(this).attr('data-id');
            var actionUrl = '/installations/KembaliStatus_A/' + cek_id;

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data akan diproses dan tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Process",
                cancelButtonText: "No, Cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#FormHapus')
                    $.ajax({
                        type: form.attr('method'),
                        url: actionUrl,
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: response.msg,
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then((res) => {
                                if (res.isConfirmed) {
                                    window.location.reload()
                                } else {
                                    window.location.href = '/installations/' + result
                                        .kembaliA.id;
                                }
                            });
                        },
                        error: function(response) {
                            const errorMsg = "Terjadi kesalahan.";
                            Swal.fire({
                                title: "Error",
                                text: errorMsg,
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "Dibatalkan",
                        text: "Data Akan Tetap di Status BLOKIR",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
    </script>
@endsection

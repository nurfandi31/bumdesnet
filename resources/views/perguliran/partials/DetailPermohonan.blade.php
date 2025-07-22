@extends('Layout.base')
@php
    $status = $settings->swit_tombol ?? null;
    $disabled = $installation->status === 'R' ? '' : 'disabled';
@endphp
@section('content')
    <form action="/installations/{{ $installation->id }}" method="post" id="Form_status_R">
        @csrf
        @method('PUT')
        <input type="text" name="status" id="status" value="{{ $installation->status }}" hidden>

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
                                    <p class="text-small">{{ $installation->village->nama }}</p>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="kode_instalasi">Kode Instalasi</label>
                                            <input type="text" class="form-control date" name="kode_instalasi"
                                                id="kode_instalasi" value="{{ $installation->kode_instalasi }}" disabled>
                                            <small class="text-danger" id="msg_kode_instalasi"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="pasang">Tanggal Pasang</label>
                                            <input type="text" class="form-control date" name="pasang" id="pasang"
                                                value="{{ date('d/m/Y') }}">
                                            <small class="text-danger" id="msg_pasang"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="biaya_instalasi">Jumlah Pembayaran</label>
                                            <input type="text" class="form-control" name="biaya_instalasi"
                                                id="biaya_instalasi" value="{{ number_format($trx, 2) }}" disabled>
                                            <small class="text-danger" id="msg_biaya_instalasi"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h4 class="card-title"><b>Detail Installation Permohonan</b></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>No. Induk</span>
                                            <span
                                                class="badge bg-secondary badge-pill badge-round ms-1">{{ $installation->kode_instalasi }}
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Tgl Order</span>
                                            <span
                                                class="badge bg-secondary badge-pill badge-round ms-1">{{ \Carbon\Carbon::parse($installation->order)->format('d-m-Y') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span> Paket Instalasi</span>
                                            <span
                                                class="badge bg-secondary badge-pill badge-round ms-1">{{ $installation->package->kelas }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Abodemen</span>
                                            <span
                                                class="badge bg-secondary badge-pill badge-round ms-1">{{ number_format($installation->abodemen, 2) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Status</span>
                                            <span class="badge bg-secondary badge-pill badge-round ms-1">PAID</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body pb-2 pt-2 pe-2 ps-2">
                                    <div class="d-flex gap-2">
                                        <a href="/installations/{{ $installation->id }}/edit"
                                            class="btn btn-warning btn-icon-split flex-fill">
                                            <span class="text-white">Edit Pemakaian</span>
                                        </a>
                                        <a href="#" data-id="{{ $installation->id }}"
                                            class="btn btn-danger btn-icon-split flex-fill Hapus_id">
                                            <span class="text-white">Hapus Pemakaian</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-content">
                                <div class="card-body pb-2 pt-2 pe-2 ps-2">
                                    <div class="col-12 d-flex align-items-center gap-2">
                                        <a href="/installations/permohonan" class="btn btn-secondary btn-icon-split">
                                            <span class="text">Kembali</span>
                                        </a>
                                        @if ($status === 1)
                                            <button class="btn btn-primary btn-icon-split ms-auto" type="submit"
                                                id="Simpan_status_R" <?= $disabled ?>>
                                                <span class="text">Aktifkan Sekarang</span>
                                            </button>
                                        @elseif ($status === 2)
                                            <button class="btn btn-primary btn-icon-split ms-auto" type="submit"
                                                id="Simpan_status_R">
                                                <span class="text">Aktifkan Sekarang</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>

    <form action="" method="post" id="FormHapus">
        @method('DELETE')
        @csrf
    </form>
@endsection

@section('script')
    <script>
        $(document).on('click', '#cetakBrcode', function(e) {
            e.preventDefault();
            window.open('/installations/cetak/{{ $installation->id }}', '_blank');
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

        $(document).on('click', '#Simpan_status_R', function(e) {
            e.preventDefault();
            $('small').html('');

            var btn = $(this);
            var originalText = btn.html();
            btn.html(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...'
            );
            btn.prop('disabled', true);

            var form = $('#Form_status_R');
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
                                window.location.href = '/installations/' + result.Pasang.id;
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
    </script>
    <script>
        $(document).on('click', '.Hapus_id', function(e) {
            e.preventDefault();

            var hapus_id = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/installations/' + hapus_id; // URL endpoint untuk proses hapus

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data Akan dihapus secara permanen dari aplikasi tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#FormHapus')
                    $.ajax({
                        type: form.attr('method'), // Gunakan metode HTTP DELETE
                        url: actionUrl,
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: response.message || "Data berhasil dihapus.",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then((res) => {
                                if (res.isConfirmed) {
                                    window.location.href = 'permohonan';
                                } else {
                                    window.location.reload()
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
                        text: "Data tidak jadi dihapus.",
                        icon: "secondary",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
    </script>
@endsection

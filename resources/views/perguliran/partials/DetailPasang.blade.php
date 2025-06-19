@extends('Layout.base')
@section('content')
    <!-- Form -->
    <form action="/installations/{{ $installation->id }}" method="post" id="Form_status_I">
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
                                    <p class="text-small">
                                        {{ $installation->village->nama }} {{ $installation->alamat }}</p>
                                </div>
                                <div class="row p-2">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="aktif">Tanggal Aktivasi</label>
                                            <input type="text" class="form-control date" name="aktif" id="aktif"
                                                value="{{ date('d/m/Y') }}">
                                            <small class="text-info" id="msg_aktif"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="kode_instalasi">Biaya Pemasangan baru</label>
                                            <input type="text" class="form-control date" name="kode_instalasi"
                                                id="kode_instalasi"
                                                value="{{ number_format($tampil_settings->pasang_baru, 2) }}" disabled>
                                            <small class="text-info" id="msg_kode_instalasi"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h4 class="card-title"><b>Detail Installation Pasang</b></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>No. Induk</span>
                                            <span
                                                class="badge bg-info badge-pill badge-round ms-1">{{ $installation->kode_instalasi }}
                                                {{ substr($installation->package->kelas, 0, 1) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Tgl Order</span>
                                            <span
                                                class="badge bg-info badge-pill badge-round ms-1">{{ \Carbon\Carbon::parse($installation->order)->format('d-m-Y') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Tgl Pasang</span>
                                            <span
                                                class="badge bg-info badge-pill badge-round ms-1">{{ \Carbon\Carbon::parse($installation->pasang)->format('d-m-Y') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span> Paket Instalasi</span>
                                            <span
                                                class="badge bg-info badge-pill badge-round ms-1">{{ $installation->package->kelas }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Abodemen</span>
                                            <span
                                                class="badge bg-info badge-pill badge-round ms-1">{{ number_format($installation->abodemen, 2) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Status</span>
                                            <span class="badge bg-success badge-pill badge-round ms-1">PASANG</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card ">
                            <div class="card-content ">
                                <div class="card-body pb-2 pt-2 pe-2 ps-2">
                                    <div class="col-12 d-flex justify-content-end align-items-center gap-2">
                                        <a href="/installations/pasang" class="btn btn-light btn-icon-split"
                                            style="float: right; margin-left: 10px;">
                                            <span class="text">Kembali</span>
                                        </a>

                                        <button class="btn btn-secondary btn-icon-split" type="submit" id="Simpan_status_I"
                                            style="float: right; margin-left: 10px;">
                                            <span class="text" style="float: right;">Aktifkan Sekarang</span>
                                        </button>
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
        $(document).on('click', '#Simpan_status_I', function(e) {
            e.preventDefault();
            $('small').html('');

            var btn = $(this);
            var originalText = btn.html(); // Simpan isi tombol sebelum diubah
            btn.html(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...'
            );
            btn.prop('disabled', true); // Disable tombol

            var form = $('#Form_status_I');
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
                                window.location.href = '/installations/' + result.aktif.id;
                            }
                        });
                    } else {
                        btn.html(originalText).prop('disabled', false);
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                    }
                },
                error: function(result) {
                    const response = result.responseJSON;
                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');
                    btn.html(originalText).prop('disabled', false);
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

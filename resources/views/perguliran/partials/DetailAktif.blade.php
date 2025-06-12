@extends('Layout.base')

@section('content')
    <!-- Form -->
    <form action="/installations/{{ $installation->id }}" method="post" id="Form_status_A">
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
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="aktif">Tanggal Aktivasi</label>
                                            <input type="text" class="form-control date" name="aktif" id="aktif"
                                                value="{{ \Carbon\Carbon::parse($installation->aktif)->format('d-m-Y') }}"
                                                disabled>
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
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label for="biaya_instalasi">Status Pembayaran</label>
                                            @if (number_format($trx, 2) == number_format($installation->biaya_instalasi, 2))
                                                <input type="text" class="form-control" value="PAID" disabled>
                                                <small class="text-info" id="msg_biaya_instalasi"></small>
                                            @else
                                                <input type="text" class="form-control" value="UNPAID" disabled>
                                                <small class="text-info" id="msg_biaya_instalasi"></small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h4 class="card-title"><b>Detail Installation Aktif</b></h4>
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
                                            @if ($installation->status === 'A')
                                                <span class="badge bg-info">
                                                    Aktif
                                                </span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body pb-2 pt-2 pe-2 ps-2">
                                    <div class="d-flex gap-2">
                                        <button id="cetakBrcode" class="btn btn-info btn-icon-split flex-fill">
                                            <span class="text-white">Cetak Pemakaian</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body pb-2 pt-2 pe-2 ps-2">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <button type="button" id="btnCabut" class="btn btn-warning text-white">Cabut
                                            Pemakaian</button>
                                        <a href="/installations/aktif" class="btn btn-light btn-icon-split">
                                            <span class="text">Kembali</span>
                                        </a>
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
    </script>
    <script>
        const toast = Swal.mixin({
            toast: true,
            icon: 'success',
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        $(document).on('click', '#btnCabut', function(e) {
            e.preventDefault();
            const today = new Date();
            const formattedDate = today.toLocaleDateString('de-DE').replace(/\./g, '/');

            Swal.fire({
                title: 'Hentikan layanan ini?',
                html: `
                    <p style="text-align: justify;">
                        Setelah proses Cabut dilakukan, data akan dipindahkan ke status <b>Cabut</b> dan seluruh aktivitas pemakaian dihentikan.
                    </p>
                    <label>Tentukan Tanggal Akhir Pemakaian:</label>
                    <input type="text" id="tgl_akhir" class="form-control date" value="${formattedDate}">
                    <hr class="mb-0">`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, cabut!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                didOpen: () => {
                    $('#tgl_akhir').datetimepicker({
                        locale: 'de',
                        timepicker: false,
                        format: 'd/m/Y',
                        defaultDate: today
                    });
                },
                preConfirm: () => $('#tgl_akhir').val()
            }).then(res => {
                if (!res.isConfirmed) return;
                const formData = $('#Form_status_A').serialize() + '&tgl_akhir=' + encodeURIComponent(res
                    .value);
                $.post($('#Form_status_A').attr('action'), formData, function(result) {
                    if (result.success) {
                        toast.fire({
                            title: result.msg
                        });
                        setTimeout(() => {
                            window.location.href = '/installations/' + result.aktif.id;
                        }, 1500);
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                    }
                }).fail(() => {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                });
            });
        });
    </script>
@endsection

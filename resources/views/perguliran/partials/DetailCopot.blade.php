@extends('Layout.base')

@section('content')
    <!-- Form -->
    <form action="/installations/{{ $installation->id }}" method="post" id="Form_status_C">
        @csrf
        @method('PUT')
        <input type="text" name="status" id="status" value="{{ $installation->status }}" hidden>
        <input type="hidden" name="id" id="id" value="{{ $installation->id }}">
        <div class="page-heading">
            <br>
            <section class="section">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body p-4 pb-5">
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
                                            <label for="aktif">Tanggal Cabut</label>
                                            <input type="text" class="form-control date" name="aktif" id="aktif"
                                                value="{{ \Carbon\Carbon::parse($installation->cabut)->format('d-m-Y') }}"
                                                disabled>
                                            <small class="text-info" id="msg_aktif"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h4 class="card-title"><b>Detail Installation Cabut</b></h4>
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
                                            <span>Tgl Aktif</span>
                                            <span
                                                class="badge bg-info badge-pill badge-round ms-1">{{ \Carbon\Carbon::parse($installation->aktif)->format('d-m-Y') }}</span>
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
                                            @if ($installation->status === 'C')
                                                <span class="badge bg-danger">
                                                    CABUT !!
                                                </span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center p-2">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#default">
                                    Hapus Instalasi dan Pemakaian
                                </button>
                                <a href="/installations/cabut" class="btn btn-light btn-icon-split">
                                    <span class="text">Kembali</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
@section('modal')
    <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Peringatan Penghapusan!</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row justify-content-center text-center mb-4">
                        <div class="col-md-4">
                            <!-- Gambar lingkaran -->
                            <img src="/assets/static/images/logo/cabut.png" alt="Foto" class="rounded-circle mb-3"
                                width="120" height="120">

                            <!-- Informasi Pengguna -->
                            <h5 class="mb-1">{{ $installation->customer->nama }}</h5>
                            <p class="mb-0">{{ $installation->village->nama }} {{ $installation->alamat }}</p>
                            <small class="text-muted">{{ $installation->kode_instalasi }} Loan id
                                {{ $installation->id }}</small>
                        </div>
                        <div class="col-md-8">
                            <h4 class="mb-5">Tindakan ini bersifat permanen. Hapus Pemakaian ?</h4>
                            <p class="text-muted mb-5" style="text-align: justify;">
                                "Setelah proses penghapusan dilakukan, data yang terhapus tidak dapat dipulihkan
                                kembali. Hal ini dikarenakan sistem akan menghapus secara permanen seluruh data terkait,
                                termasuk data transaksi, pemakaian, serta informasi instalasi. Mohon pastikan
                                keputusan ini telah dipertimbangkan dengan matang sebelum melanjutkan."</p>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" id="Simpan_status_C" class="btn btn-danger ms-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Hapus Sekarang</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
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


        $(document).on('click', '#Simpan_status_C', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#Form_status_C');
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
                                window.location.href = '/installations/cabut';
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
@endsection

@extends('Layout.base')

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
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form action="/customers" method="post" id="FormCustommer">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="nik">NIK</label>
                                            <input autocomplete="off" maxlength="16" type="text" name="nik"
                                                id="nik" class="form-control" value="">
                                            <small class="text-danger" id="msg_nik"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="nama_lengkap">Nama lengkap</label>
                                            <input autocomplete="off" type="text" name="nama_lengkap" id="nama_lengkap"
                                                class="form-control">
                                            <small class="text-danger" id="msg_nama_lengkap"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="nama_panggilan">Nama Panggilan</label>
                                            <input autocomplete="off" type="text" name="nama_panggilan"
                                                id="nama_panggilan" class="form-control">
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input autocomplete="off" type="text" name="tempat_lahir" id="tempat_lahir"
                                                class="form-control" value="">
                                            <small class="text-danger" id="msg_tempat_lahir"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tgl_lahir">Tgl Lahir</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control date" name="tgl_lahir"
                                                    id="tgl_lahir" value="{{ date('d/m/Y') }}">
                                                <small class="text-danger"id="msg_tgl_lahir"></small>
                                            </div>
                                            <small class="text-danger"id="msg_tgl_lahir"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="form-control choices" name="jenis_kelamin" id="jenis_kelamin">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L">Laki Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                            <small class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="no_telp">No. Telepon</label>
                                            <input autocomplete="off" type="text" name="no_telp" id="no_telp"
                                                class="form-control">
                                            <small class="text-danger" id="msg_no_telp"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input autocomplete="off" type="email" name="email" id="email"
                                                class="form-control" placeholder="@gmail.com">
                                            <small class="text-danger" id="msg_email"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <input autocomplete="off" type="text" name="pekerjaan" id="pekerjaan"
                                                class="form-control">
                                            <small class="text-danger" id="msg_pekerjaan"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat Lengkap</label>
                                            <input autocomplete="off" type="text" name="alamat" id="alamat"
                                                class="form-control" value="">
                                            <small class="text-danger" id="msg_alamat"></small>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="reset" class="btn btn-light me-1 mb-1">Reset</button>
                                        <button type="submit" id="SimpanPenduduk"
                                            class="btn btn-primary me-1 mb-1">Simpan Pelanggan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
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

        //simpan
        $(document).on('click', '#SimpanPenduduk', function(e) {
            e.preventDefault();
            $('small').html('');
            var btn = $(this);
            var originalText = btn.html();
            btn.html(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...'
            );
            btn.prop('disabled', true);
            var form = $('#FormCustommer');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Tambahkan Customer  Baru?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Tambahkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/customers/';
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

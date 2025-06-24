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
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pengaturan !</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-3 mb-3">
                                <div class="nav nav-pills flex-md-column flex-row" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link active w-100 text-left" id="wellcome-tab" data-bs-toggle="pill"
                                        href="#wellcome" role="tab" aria-controls="wellcome" aria-selected="true">
                                        <dt class="the-icon">
                                            <span class="fa-fw select-all fas"></span>&nbsp; Wellcome
                                        </dt>
                                    </a>
                                    <a class="nav-link w-100 text-left" id="lembaga-tab" data-bs-toggle="pill"
                                        href="#lembaga" role="tab" aria-controls="lembaga" aria-selected="false">
                                        <dt class="the-icon">
                                            <span class="fa-fw select-all fas"></span>&nbsp; Identitas Lembaga
                                        </dt>
                                    </a>
                                    <a class="nav-link w-100 text-left" id="pasang-tab" data-bs-toggle="pill" href="#pasang"
                                        role="tab" aria-controls="pasang" aria-selected="false">
                                        <dt class="the-icon">
                                            <span class="fa-fw select-all fas"></span>&nbsp; Pasang Baru
                                        </dt>
                                    </a>
                                    {{-- <a class="nav-link w-100 text-left" id="tagihan-tab" data-bs-toggle="pill"
                                        href="#tagihan" role="tab" aria-controls="tagihan" aria-selected="false">
                                        <dt class="the-icon">
                                            <span class="fa-fw select-all fas"></span>&nbsp; Sistem Tagihan
                                        </dt>
                                    </a> --}}
                                    <a class="nav-link w-100 text-left" id="logo-tab" data-bs-toggle="pill" href="#logo"
                                        role="tab" aria-controls="logo" aria-selected="false">
                                        <dt class="the-icon">
                                            <span class="fa-fw select-all fas"></span>&nbsp;Logo
                                        </dt>
                                    </a>
                                    <a class="nav-link w-100 text-left" id="whasapp-tab" data-bs-toggle="pill"
                                        href="#whasapp" role="tab" aria-controls="whasapp" aria-selected="false">
                                        <dt class="the-icon">
                                            <span class="fa-fw select-all fas"></span>&nbsp; Whatsapp
                                        </dt>
                                    </a>
                                </div>
                            </div>

                            <div class="col-12 col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="wellcome" role="tabpanel"
                                        aria-labelledby="wellcome-tab">
                                        @include('sop.partials.profil')
                                    </div>
                                    <div class="tab-pane fade" id="lembaga" role="tabpanel" aria-labelledby="lembaga-tab">
                                        @include('sop.partials.lembaga')
                                    </div>
                                    <div class="tab-pane fade" id="pasang" role="tabpanel" aria-labelledby="pasang-tab">
                                        @include('sop.partials.pasang_baru')
                                    </div>
                                    <div class="tab-pane fade" id="tagihan" role="tabpanel" aria-labelledby="tagihan-tab">
                                        @include('sop.partials.sistem_instal')
                                    </div>
                                    <div class="tab-pane fade" id="logo" role="tabpanel" aria-labelledby="logo-tab">
                                        <h5 class="card-title font-weight-bold">
                                            Upload Logo
                                        </h5>
                                        @include('sop.partials.logo')
                                    </div>
                                    <div class="tab-pane fade" id="whasapp" role="tabpanel" aria-labelledby="whasapp-tab">
                                        <h5 class="card-title font-weight-bold">
                                            Pengaturan Pesan Whatsapp
                                        </h5>
                                        @include('sop.partials.whatsapp')

                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" id="ScanWhatsapp" class="btn btn-info ml-2">
                                                Scan Whatsapp
                                            </button>
                                            <button type="button" id="HapusWhatsapp" class="btn btn-danger ml-2"
                                                style="display: none;">
                                                Hapus Whatsapp
                                            </button>
                                            <button type="button" id="SimpanWhatsapp" class="btn btn-primary ml-2">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <form action="/pengaturan/whatsapp/{{ $token }}" method="post" id="FormWhatsapp">
        @csrf
    </form>
@endsection

@section('modal')
    <div class="modal fade" id="ModalScanWhatsapp" tabindex="-1" role="dialog"
        aria-labelledby="ModalScanWhatsappLabel" aria-modal="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalScanWhatsappLabel">Scan Whatsapp</h5>
                    <button type="button" class="close btn-modal-close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-5 col-lg-6 text-center">
                                    <img class="w-100 border-radius-lg shadow-lg mx-auto" src="/assets/img/no_image.png"
                                        id="QrCode" alt="chair">
                                </div>
                                <div class="col-lg-5 mx-auto">
                                    <h3 class="mt-lg-0 mt-4">Scan kode QR</h3>
                                    <ul class="list-group list-group-flush rounded" id="ListConnection">
                                        <li class="list-group-item">
                                            Membuat Kode QR
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary btn-modal-close">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '#EditLogo', function(e) {
            e.preventDefault();
            $('#logo_busines').trigger('click');
        });

        $(document).on('change', '#logo_busines', function(e) {
            e.preventDefault();

            var logo = $(this).get(0).files[0];
            if (logo) {
                var form = $('#FormLogo');
                var formData = new FormData(document.querySelector('#FormLogo'));

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {
                        if (result.success) {
                            var reader = new FileReader();

                            reader.onload = function() {
                                $("#previewLogo").attr("src", reader.result);
                                $(".colored-shadow").css('background-image', "url(" + reader
                                    .result + ")");
                            }

                            reader.readAsDataURL(logo);

                            toastMixin.fire({
                                icon: 'success',
                                title: result.msg
                            });
                        } else {
                            toastMixin.fire({
                                icon: 'error',
                                title: result.msg
                            });
                        }
                    },
                    error: function(xhr) {
                        toastMixin.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan saat mengunggah logo.'
                        });
                    }
                });
            }
        });
    </script>

    {{-- 
    <script>
        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script> --}}
    <script>
        //pasang baru
        $("#pasang_baru").maskMoney({
            allowNegative: true
        });
        $(document).on('click', '#SimpanSwit', function(e) {
            e.preventDefault();
            var form = $('#Fromswit');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'GET',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: 'Pembaruhan Pasang Baru Berhasil'
                        });
                        // setTimeout(() => window.location.reload(), 3000);
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');
                }
            });
        });
    </script>
    <script>
        //identitas lembaga
        $(document).on('click', '#SimpanLembaga', function(e) {
            e.preventDefault();
            var form = $('#FromLembaga');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'GET',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: 'Pembaruhan Identitas Lembaga Berhasil'
                        });
                        // setTimeout(() => window.location.reload(), 3000);
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');
                }
            });
        });
    </script>
    <script>
        // sistem instal
        $("#abodemen").maskMoney({
            allowNegative: true
        });
        $("#denda").maskMoney({
            allowNegative: true
        });
        $("#biaya_aktivasi").maskMoney({
            allowNegative: true
        });

        $(document).on('click', '#SimpanInstal', function(e) {
            e.preventDefault();
            var form = $('#FromInstal');
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
                            title: 'Pembaruhan Sistem Tagihan Berhasil'
                        });
                        // setTimeout(() => window.location.reload(), 3000);
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');
                }
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.5/socket.io.min.js"></script>
    <script>
        let ListContainer = $('#ListConnection')
        const API = '{{ $api }}'
        const form = $('#FormWhatsapp')
        const socket = io(API, {
            transports: ['polling']
        })

        var scan = 0
        var connect = 0
        const pesan = $('#Pesan')

        var socketId = 0;
        socket.on('connected', (res) => {
            console.log('Connected to the server. Socket ID:', res.id);
            socketId = res.id
        });

        $('#HapusWhatsapp').hide()
        $('#ScanWhatsapp').hide()
        $(document).ready(function() {
            $.get(API + '/api/client/{{ $token }}', function(result) {
                if (result.success && result.data) {
                    $('#HapusWhatsapp').show()
                    $('#ScanWhatsapp').hide()
                } else {
                    $('#ScanWhatsapp').show()
                    $('#HapusWhatsapp').hide()
                }

                console.log(result);

            })
        })

        var scanQr = 0;
        socket.on('QR', (result) => {
            $('#QrCode').attr('src', result.url)

            if (scanQr <= 0) {
                var List = $('<li class="list-group-item font-weight-bold">Scan QR</li>')
                ListContainer.append(List)
            }

            scanQr += 1;
        })

        socket.on('ClientConnect', (result) => {
            $('#QrCode').attr('src', result.url)
            var List = $('<li class="list-group-item list-group-item-success font-weight-bold">Whatsapp Aktif</li>')
            ListContainer.append(List)
        })

        $(document).on('click', '#ScanWhatsapp', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: API + '/api/client',
                data: {
                    nama: $('#nama').val(),
                    token: '{{ $token }}',
                    socketId
                },
                success: function(result) {
                    if (result.success) {
                        $('#ModalScanWhatsapp').modal('show');
                    } else {
                        Swal.fire('Error', "Whatsapp sudah terdaftar.", 'error')
                    }
                }
            })
        });

        $(document).on('click', '#HapusWhatsapp', function(e) {
            e.preventDefault()

            Swal.fire({
                title: 'Hapus Whatsapp',
                text: 'Hapus koneksi whatsapp.',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                icon: 'error'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: API + '/api/client/{{ $token }}',
                        success: function(result) {
                            if (result.success) {
                                Swal.fire('Whatsapp Dihapus',
                                    "Scan ulang untuk bisa menggunakan layanan pesan pemberitahuan otomatis.",
                                    'success')

                                $('#ScanWhatsapp').show()
                                $('#HapusWhatsapp').hide()
                            }
                        }
                    })
                }
            })
        })

        $(document).on('click', '#SimpanWhatsapp', function(e) {
            e.preventDefault();

            var form = $('#FormScanWhatsapp');
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: result.msg
                        });
                    }
                }
            })
        })
    </script>
@endsection

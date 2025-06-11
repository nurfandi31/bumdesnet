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
    <!-- Row tampil data -->
    <div class="page-heading">
        <section class="section">
            <div class="card">
                <div class="card-header p-2 pe-3 pb-2 ps-2 pt-3">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary block btn-create">
                            Tambah Paket Baru
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead class="thead-light">
                            <div>&nbsp;</div>
                            <tr>
                                <th>KELAS</th>
                                <th>HARGA</th>
                                <th>ABODEMEN</th>
                                <th>DENDA</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $paket)
                                <tr>
                                    <td>{{ $paket->kelas }}</td>
                                    <td>{{ number_format($paket->harga, 2) }}</td>
                                    <td>{{ number_format($paket->abodemen, 2) }}</td>
                                    <td>{{ number_format($paket->denda, 2) }}</td>
                                    <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                                        <a href="#" data-id="{{ $paket->id }}"
                                            class="btn btn-warning btn-sm btn-edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <a href="#" data-id="{{ $paket->id }}"
                                            class="btn-sm btn btn-danger mx-1 Hapus_paket">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <form action="" method="post" id="FormHapus">
        @method('DELETE')
        @csrf
    </form>

    @include('paket.modal')
@endsection

@section('script')
    <script>
        $("#harga").maskMoney({
            allowNegative: true
        });
        $("#abodemen").maskMoney({
            allowNegative: true
        });
        $("#denda").maskMoney({
            allowNegative: true
        });

        $(document).on('click', '#SimpanPaket', function(e) {
            e.preventDefault();
            $('small').html('');
            var form = $('#modalPaket');
            var actionUrl = form.attr('action');
            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: 'Pembaruhan Kelas & Biaya Berhasil'
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

        $(document).on('click', '.btn-create', (e) => {
            e.preventDefault()

            var form = $('#modalPaket')
            form[0].reset();

            form.attr('action', '/packages')
            form.find('input[name="_method"]').val('POST')
            $('#border-less').modal('toggle')
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            $.get('/packages/' + id + '/edit', function(result) {
                if (result.success) {
                    var data = result.data;
                    var form = $('#modalPaket');
                    form.attr('action', '/packages/' + id);
                    form.find('input[name="_method"]').val('PUT');

                    $('#kelas').val(data.kelas);
                    $('#harga').val(data.harga);
                    $('#abodemen').val(data.abodemen);
                    $('#denda').val(data.denda);

                    $('#border-less').modal('show');
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.Hapus_paket', function(e) {
            e.preventDefault();

            var hapus_paket = $(this).attr('data-id');
            var actionUrl = '/packages/' + hapus_paket;

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
                        type: form.attr('method'),
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
                                    window.location.reload()
                                } else {
                                    window.location.href = '/packages/';
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
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
        //endindex
    </script>
@endsection

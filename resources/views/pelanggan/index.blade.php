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
    <div class="page-heading">

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="customers">
                        <thead class="thead-light">
                            <tr>
                                <th>NIK</th>
                                <th>NAMA</th>
                                <th>ALAMAT</th>
                                <th>TELPON</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <form action="" method="post" id="FormHapusPelanggan">
        @method('DELETE')
        @csrf
    </form>
@endsection

@section('script')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastMixin.fire({
                    text: '{{ Session::get('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif
    <script>
        let table = setAjaxDatatable('#customers', '{{ url('customers') }}', [{
                data: 'nik',
                name: 'nik'
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data: 'hp',
                name: 'hp'
            },
            {
                data: 'aksi',
                name: 'aksi',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return `
                <div class="d-flex justify-content-center flex-wrap gap-1">
                    <a href="/customers/${data}/edit" class="btn btn-warning btn-sm">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="#" data-id="${data}" class="btn btn-danger btn-sm Hapus_pelanggan">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>

                `;
                }
            }
        ]);

        $(document).on('change', '.set-table', function() {
            table.ajax.reload();
        });
    </script>
    <script>
        //hapus pelangan
        $(document).on('click', '.Hapus_pelanggan', function(e) {
            e.preventDefault();

            var hapus_id = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/customers/' + hapus_id; // URL endpoint untuk proses hapus

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data akan dihapus secara permanen dari aplikasi dan tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#FormHapusPelanggan');
                    $.ajax({
                        type: form.attr('method'), // Gunakan metode HTTP DELETE
                        url: actionUrl,
                        data: form.serialize(),
                        success: function(result) {
                            if (result.success) {
                                Swal.fire({
                                    title: "Berhasil!",
                                    text: result.msg,
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then((res) => {
                                    if (res.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: "Gagal",
                                    text: result.msg,
                                    icon: "info",
                                    confirmButtonText: "OK"
                                });
                            }
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Error",
                                text: "Terjadi kesalahan pada server. Silakan coba lagi.",
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
    </script>
@endsection

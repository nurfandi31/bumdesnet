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
                    <div class="table-responsive responsive p-2 ">
                        <table class="table table-striped" id="cater">
                            <thead class="thead-light">
                                <tr>
                                    <th>NAMA</th>
                                    <th>ALAMAT</th>
                                    <th>TELPON</th>
                                    <th>USERNAME</th>
                                    <th style="text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <form action="" method="post" id="FormHapusCater">
        @method('DELETE')
        @csrf
    </form>
@endsection

@section('script')
    @if (session('jsedit'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastMixin.fire({
                    text: '{{ Session::get('jsedit') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif
    <script>
        let table = setAjaxDatatable('#cater', '{{ url('caters') }}', [{
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data: 'telpon',
                name: 'telpon'
            },
            {
                data: 'username',
                name: 'username'
            },
            {
                data: 'aksi',
                name: 'aksi',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return `
                    <div class="d-flex justify-content-center flex-wrap gap-1">
                        <a href="/caters/${data}/edit" class="btn btn-warning btn-sm">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="#" data-id="${data}" class="btn btn-danger btn-sm Hapus_cater">
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
        //hapus
        $(document).on('click', '.Hapus_cater', function(e) {
            e.preventDefault();

            var hapus_cater = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/caters/' + hapus_cater; // URL endpoint untuk proses hapus

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
                    var form = $('#FormHapusCater')
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
                                    window.location.reload()
                                } else {
                                    window.location.href = '/caters/';
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
    </script>
@endsection

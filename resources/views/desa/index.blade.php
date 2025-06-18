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
                    <div class="table-responsive responsive p-2">
                        <table class="table table-striped" id="desa">
                            <thead class="thead-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Desa/Kalurahan</th>
                                    <th>Dusun/Pedukuhan</th>
                                    <th>Alamat</th>
                                    <th>Telpon</th>
                                    <th style="text-align: center;">Aksi</th>
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

    <form action="" method="post" id="FormHapusDesa">
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
        let table = setAjaxDatatable('#desa', '{{ url('villages') }}', [{
                data: 'kode',
                name: 'kode'
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'dusun',
                name: 'dusun'
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
                <div style="display: flex; gap: 5px; justify-content: center;">
                    <a href="/villages/${data}/edit" class="btn btn-warning btn-sm btn-edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="#" data-id="${data}" class="btn btn-danger btn-sm Hapus_desa">
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
        $(document).on('click', '.Hapus_desa', function(e) {
            e.preventDefault();

            var hapus_desa = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/villages/' + hapus_desa; // URL endpoint untuk proses hapus

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
                    var form = $('#FormHapusDesa')
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
                                    window.location.href = '/villages/';
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

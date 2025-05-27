@extends('layout.base')

@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
@endphp

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
                <div class="card-header">
                    <div class="col-12 d-flex justify-content-end">
                        <a href="/packages/create" class="btn btn-primary btn-icon-split" id="SimpanPaket"
                            style="float: right; margin-left: 10px;">
                            <span class="text" style="float: right;"><b>Tambah Paket Baru</b></span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead class="thead-light">
                            <div>&nbsp;</div>
                            <tr>
                                <th>KELAS</th>
                                @for ($i = 0; $i < $jumlah_blok; $i++)
                                    <th>{{ $blok[$i]['nama'] }} .[ {{ $blok[$i]['jarak'] }} ]</th>
                                @endfor
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $paket)
                                @php
                                    $harga = json_decode($paket->harga, true);
                                @endphp
                                <tr>
                                    <td>{{ $paket->kelas }}</td>
                                    @for ($i = 0; $i < $jumlah_blok; $i++)
                                        <td>{{ number_format(isset($harga[$i]) ? $harga[$i] : '0', 2) }}
                                        </td>
                                    @endfor
                                    <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                                        <a href="/packages/{{ $paket->id }}/edit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="#"
                                            data-id="{{ $paket->id }}"class="btn-sm btn btn-danger mx-1 Hapus_paket">
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
@endsection

@section('script')
    <script>
        $(document).on('click', '.Hapus_paket', function(e) {
            e.preventDefault();

            var hapus_paket = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/packages/' + hapus_paket; // URL endpoint untuk proses hapus

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

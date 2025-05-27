@extends('layout.base')
@php
    use App\Utils\Tanggal;
@endphp
@section('content')
    @if (session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <li class="	fas fa-check-circle"></li>
            {{ session('success') }}
        </div>
    @endif


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

    <section class="basic-choices position-relative">
        <div class="row">
            <div class="col-12 position-relative">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body pb-0 pt-2 ps-2 pe-2">
                            <div class="row">
                                <div class="col-md-3 mb-0 p-0 pe-3 ps-3 pb-2">
                                    <div class="d-grid">
                                        <label for="bulan">Pilih Bulan Pemakaian</label>
                                        <select class="choices form-control" name="bulan" id="bulan">
                                            <option value="">Pilih Bulan</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option {{ date('m') == $i ? 'selected' : '' }}
                                                    value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                    {{ Tanggal::namaBulan(date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-01') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-0 p-0 pe-3 ps-3 pb-2">
                                    <div class="d-grid">
                                        <label for="caters">Cater</label>
                                        <select class="choices form-control" id="caters" name="caters">
                                            <option value="">Semua</option>
                                            @foreach ($caters as $cater)
                                                <option value="{{ $cater->id }}">{{ $cater->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-0 p-0 pe-3 ps-3 pb-2">
                                    <div class="d-grid">
                                        <label for="">&nbsp;</label>
                                        @if (auth()->user()->jabatan == 1)
                                            <button class="btn btn-danger" type="button" id="DetailCetakBuktiTagihan">
                                                Cetak Tagihan
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3 mb-0 p-0 pe-3 ps-3 pb-2">
                                    <div class="d-grid">
                                        <label for="">&nbsp;</label>
                                        <button class="btn btn-warning text-white" id="Registerpemakaian"
                                            @if (Session::get('jabatan') == 6) disabled @endif>
                                            Input Data Pemakaian
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div>&nbsp;</div>
                    <table class="table align-items-center table-flush" id="table1">
                        <thead class="thead-light" align="center">
                            <tr>
                                <th>Nama</th>
                                <th>No.Induk</th>
                                <th>Meter Awal</th>
                                <th>Meter Akhir</th>
                                <th>Pemakaian</th>
                                <th>Tagihan </th>
                                <th>Tanggal Akhir</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="CetakBuktiTagihan" tabindex="-1" aria-labelledby="CetakBuktiTagihanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="CetakBuktiTagihanLabel">
                    </h1>
                </div>
                <div class="modal-body">
                    <form action="/usages/cetak" method="post" id="FormCetakBuktiTagihan" target="_blank">
                        @csrf
                        <table id="TbTagihan" class="table table-striped midle">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <td align="center" width="40">
                                        <div class="form-check text-center ps-0 mb-0">
                                            <input class="form-check-input" type="checkbox" value="true" id="checked"
                                                name="checked" checked>
                                        </div>
                                    </td>
                                    <td align="center" width="100">Nama</td>
                                    <td align="center" width="100">Cater</td>
                                    <td align="center" width="100">No. Induk</td>
                                    <td align="center" width="100">Meter Awal</td>
                                    <td align="center" width="100">Meter Akhir</td>
                                    <td align="center" width="100">Pemakaian</td>
                                    <td align="center" width="100">Tagihan</td>
                                    <td align="center" width="100">Status</td>
                                    <td align="center" width="100">Tanggal Akhir Bayar</td>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </form>

                    <div class="d-none">
                        <form action="/usages/cetak_tagihan" method="post" id="FormCetakTagihan" target="_blank">
                            @csrf

                            <div id="form"></div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="BtnCetak1" class="btn btn-sm btn-dark">
                        Cetak Daftar Tagihan
                    </button>
                    <button type="button" id="BtnCetak" class="btn btn-sm btn-info">
                        Cetak Struk
                    </button>
                    <button type="button" id="kembali" class="btn btn-danger btn-sm">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="FormHapusPemakaian">
        @method('DELETE')
        @csrf
    </form>
@endsection

@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            $('#CetakBuktiTagihan').modal('hide');
        });

        $(document).on(' click', '#Registerpemakaian', function(e) {
            e.preventDefault();
            window.location.href = '/usages/create';
        });

        var cater = $('#caters').val()
        var bulan = $('#bulan').val()
        var table = $('#table1').DataTable({
            "ajax": {
                "url": "/usages?bulan=" + bulan + "&cater=" + cater,
                "type": "GET"
            },
            "language": {
                "emptyTable": "Tidak ada data yang tersedia",
                "search": "",
                "searchPlaceholder": "Pencarian...",
                "paginate": {
                    "next": "<i class='fas fa-angle-right'></i>",
                    "previous": "<i class='fas fa-angle-left'></i>"
                }
            },
            "columns": [{
                    "data": "customers.nama"
                },
                {
                    "data": "installation.kode_instalasi"
                },
                {
                    "data": "awal"
                },
                {
                    "data": "akhir"
                },
                {
                    "data": "jumlah"
                },
                {
                    "data": "nominal"
                },
                {
                    "data": "tgl_akhir"
                },
                {
                    "data": "status"
                },
                {
                    "data": "aksi",
                }
            ]
        });

        $('#caters').on('change', function() {
            cater = $(this).val()
            table.ajax.url("/usages?bulan=" + bulan + "&cater=" + cater).load();
        });

        $('#bulan').on('change', function() {
            bulan = $(this).val()
            table.ajax.url("/usages?bulan=" + bulan + "&cater=" + cater).load();
        });

        $(document).on('click', '#DetailCetakBuktiTagihan', function(e) {
            var data = table.data().toArray()
            var tbTagihan = $('#TbTagihan');

            tbTagihan.find('tbody').html('')
            data.forEach((item) => {
                var row = tbTagihan.find('tbody').append(`
                    <tr>
                        <td align="center">
                            <div class="form-check text-center ps-0 mb-0">
                                <input checked class="form-check-input" type="checkbox" value="${item.id}" id="${item.id}" name="cetak[]" data-input="checked" data-bulan="${item.bulan}">
                            </div>
                        </td>
                        <td align="left">${item.customers.nama}</td>
                        <td align="left">${item.users_cater.nama}</td>
                        <td align="left">${item.installation.kode_instalasi} ${item.installation.package.kelas.charAt(0)}</td>
                        <td align="right">${item.awal}</td>
                        <td align="right">${item.akhir}</td>
                        <td align="right">${item.jumlah}</td>
                        <td align="right">${item.nominal}</td>
                        <td align="center">${item.status}</td>
                        <td align="center">${item.tgl_akhir}</td>
                    </tr>
                `);
            })

            $('#CetakBuktiTagihan').modal('show');
        });

        $(document).on('click', '#BtnCetak', function(e) {
            e.preventDefault()

            if ($('#FormCetakBuktiTagihan').serializeArray().length > 1) {
                $('#FormCetakBuktiTagihan').submit();
            } else {
                Swal.fire('Error', "Tidak ada transaksi yang dipilih.", 'error')
            }
        })
        $(document).on('click', '#BtnCetak1', function(e) {
            e.preventDefault()

            var data = table.data().toArray()
            var formTagihan = $('#form');

            var bulan = $('#bulan').val()
            var caters = $('#caters').val()

            formTagihan.find('form').html('')
            var row = formTagihan.append(`
                <input type="hidden" name="bulan_tagihan" value="${bulan}">
                <input type="hidden" name="pemakaian_cater" value="${cater}">
            `);

            $('#FormCetakTagihan').submit();
        })
    </script>

    @if (Session::has('berhasil'))
        <script>
            toastMixin.fire({
                text: '{{ Session::get('berhasil') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
    <script>
        // Tunggu hingga DOM selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Pilih elemen notifikasi
            const alert = document.getElementById('success-alert');
            if (alert) {
                // Atur timer untuk menghilangkan notifikasi setelah 3 detik
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s'; // Animasi hilang
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500); // Hapus elemen setelah animasi selesai
                }, 3000);
            }
        });
        $(document).on('click', '.Hapus_pemakaian', function(e) {
            e.preventDefault();

            var hapus_pemakaian = $(this).attr('data-id'); // Ambil ID yang terkait dengan tombol hapus
            var actionUrl = '/usages/' + hapus_pemakaian; // URL endpoint untuk proses hapus

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
                    var form = $('#FormHapusPemakaian')
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
                                    window.location.href = '/usages/';
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

        $(document).ready(function() {
            // Filter baris berdasarkan bulan akhir
            $('#filter-bulan').on('change', function() {
                var selectedMonth = $(this).val();
                $('[data-input=checked]').each(function() {
                    var row = $(this).closest('tr');
                    var bulan = $(this).data('bulan');
                    if (!selectedMonth || bulan == selectedMonth) {
                        row.show();
                    } else {
                        row.hide();
                        $(this).prop('checked', false); // Uncheck jika disembunyikan
                    }
                });
            });

            // Centang semua baris yang terlihat saat checkbox utama diklik
            $('#checked').on('click', function() {
                var status = $(this).is(':checked');
                $('[data-input=checked]:visible').prop('checked', status);
            });
        });
    </script>
@endsection

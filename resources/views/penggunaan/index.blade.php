@extends('Layout.base')
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
                                <div class="col-md-4 mb-0 p-0 pe-3 ps-3 pb-2">
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
                                <div class="col-md-4 mb-0 p-0 pe-3 ps-3 pb-2">
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
                                <div class="col-md-4 mb-0 p-0 pe-3 ps-3 pb-2">
                                    <div class="d-grid">
                                        <label for="">&nbsp;</label>
                                        @if (auth()->user()->jabatan == 1)
                                            <button class="btn btn-danger" type="button" id="DetailCetakBuktiTagihan">
                                                Cetak Tagihan
                                            </button>
                                        @endif
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
        let table = '';
        let cater = $('#caters').val();
        let bulan = $('#bulan').val();
        console.log(cater, bulan);


        $(document).on('click', '#kembali', e => {
            e.preventDefault();
            $('#CetakBuktiTagihan').modal('hide');
        });

        $(document).on('click', '#Registerpemakaian', e => {
            e.preventDefault();
            const bulanTerpilih = `01/${$('#bulan').val()}/{{ date('Y') }}`;
            const caterId = $('#caters').val();
            if (bulanTerpilih && caterId) {
                window.location.href = `/usages/create?bulan=${bulanTerpilih}&cater_id=${caterId}`;
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih bulan dan cater terlebih dahulu.'
                });
            }
        });

        const columns = [{
                data: "customers.nama"
            },
            {
                data: "kode_instalasi_dengan_inisial"
            },
            {
                data: "awal"
            },
            {
                data: "akhir"
            },
            {
                data: "jumlah"
            },
            {
                data: "nominal"
            },
            {
                data: "tgl_akhir",
                render(data) {
                    if (!data) return '';
                    const [d, m, y] = data.split('/').map(Number);
                    const t = new Date(y, m - 1, d - 1);
                    return `${String(t.getDate()).padStart(2, '0')}/${String(t.getMonth() + 1).padStart(2, '0')}/${t.getFullYear()}`;
                }
            },
            {
                data: "status"
            },
            @if (Session::get('jabatan') != 5)
                {
                    data: "aksi"
                }
            @endif
        ];

        $('#caters, #bulan').on('change', function() {
            cater = $('#caters').val();
            bulan = $('#bulan').val();

            if (cater) {
                if (!table) {
                    table = $('#TbPemakain').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: `/usages?bulan=${bulan}&cater=${cater}`,
                        language: {
                            processing: `<i class="fas fa-spinner fa-spin"></i> Mohon Tunggu....`,
                            emptyTable: "Tidak ada data yang tersedia",
                            search: "",
                            searchPlaceholder: "Pencarian...",
                            paginate: {
                                next: "<i class='fas fa-angle-right'></i>",
                                previous: "<i class='fas fa-angle-left'></i>"
                            }
                        },
                        columns
                    });
                } else {
                    table.ajax.url(`/usages?bulan=${bulan}&cater=${cater}`).load();
                }
            }
        });

        function fetchAllDataFullAndShowModal() {
            $.get("/usages", {
                bulan: $('#bulan').val(),
                cater: $('#caters').val()
            }, response => {
                const data = response.data || response;
                if (data.length) {
                    const caterText = $('#caters option:selected').text();
                    const [d, m, y] = data[0].tgl_akhir.split('/');
                    $('#NamaCater').text(caterText);
                    $('#TanggalCetak').text(`${d - 1}/${m}/${y}`);
                    $('#InputCater').val($('#caters').val());
                    $('#InputTanggal').val(data[0].tgl_akhir);
                }
                setTableData(data);
                $('#CetakBuktiTagihan').modal('show');
            }).fail(() => alert('Gagal mengambil data lengkap'));
        }

        $(document).on('click', '#DetailCetakBuktiTagihan', fetchAllDataFullAndShowModal);

        function setTableData(data) {
            const tbody = $('#TbTagihan tbody').empty();
            const grouped = {};

            data.forEach(item => {
                const dusun = item.installation.village.dusun || '';
                (grouped[dusun] ||= []).push(item);
            });

            Object.keys(grouped).sort().forEach(dusun => {
                tbody.append(`<tr class="table-secondary fw-bold"><td colspan="11">Dusun : ${dusun}</td></tr>`);
                grouped[dusun].sort((a, b) => parseInt(a.installation.rt) - parseInt(b.installation.rt)).forEach(
                    item => {
                        tbody.append(`
                                <tr>
                                    <td align="center"><div class="form-check text-center ps-0 mb-0">
                                        <input checked class="form-check-input" type="checkbox" value="${item.id}" id="${item.id}" name="cetak[]" data-input="checked" data-bulan="${item.bulan}">
                                    </div></td>
                                    <td align="left">${item.customers.nama}</td>
                                    <td align="left">${item.installation.village.nama}</td>
                                    <td align="center">${item.installation.rt}</td>
                                    <td align="center">${item.installation.kode_instalasi} ${item.installation.package.kelas.charAt(0)}</td>
                                    <td align="center">${item.awal}</td>
                                    <td align="center">${item.akhir}</td>
                                    <td align="center">${item.jumlah}</td>
                                    <td align="right">${item.nominal}</td>
                                    <td align="center">${item.status}</td>
                                </tr>`);
                    });
            });
        }

        $('#BtnCetak').on('click', e => {
            e.preventDefault();
            if ($('#FormCetakBuktiTagihan').serializeArray().length > 1) {
                const form = $('#FormCetakBuktiTagihan');
                form.append(`<input type="hidden" name="bulan_tagihan" value="${$('#bulan').val()}">`);
                form.append(`<input type="hidden" name="pemakaian_cater" value="${$('#caters').val()}">`);
                form.submit();
            } else {
                Swal.fire('Error', "Tidak ada transaksi yang dipilih.", 'error');
            }
        });

        $('#BtnCetak1').on('click', e => {
            e.preventDefault();
            const form = $('#form');
            form.append(`<input type="hidden" name="bulan_tagihan" value="${$('#bulan').val()}">`);
            form.append(`<input type="hidden" name="cater" value="${$('#caters').val()}">`);
            $('#FormCetakTagihan').submit();
        });

        $('#BtnCetak2').on('click', e => {
            e.preventDefault();
            const form = $('#formbonggol').html('');
            form.append(`<input type="hidden" name="bulan_tagihan" value="${$('#bulan').val()}">`);
            form.append(`<input type="hidden" name="cater" value="${$('#caters').val()}">`);
            $('#FormCetakBonggol').submit();
        });

        @if (Session::has('berhasil'))
            toastMixin.fire({
                text: '{{ Session::get('berhasil') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif

        $(document).ready(function() {
            $('#filter-bulan').on('change', function() {
                const selectedMonth = $(this).val();
                $('[data-input=checked]').each(function() {
                    const row = $(this).closest('tr');
                    const bulan = $(this).data('bulan');
                    const show = !selectedMonth || bulan == selectedMonth;
                    row.toggle(show);
                    if (!show) $(this).prop('checked', false);
                });
            });

            $('#checked').on('click', function() {
                $('[data-input=checked]:visible').prop('checked', $(this).is(':checked'));
            });
        });

        $(document).on('click', '.Hapus_pemakaian', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data Akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: `/usages/${id}`,
                        data: $('#FormHapusPemakaian').serialize(),
                        success: r => Swal.fire("Berhasil!", r.message || "Data berhasil dihapus.",
                            "success").then(() => window.location.reload()),
                        error: () => Swal.fire("Error", "Terjadi kesalahan.", "error")
                    });
                } else {
                    Swal.fire("Dibatalkan", "Data tidak jadi dihapus.", "info");
                }
            });
        });

        document.getElementById('SearchTagihan').addEventListener('keyup', function() {
            const keyword = this.value.toLowerCase();
            const rows = document.querySelectorAll('#TbTagihan tbody tr');
            let currentGroup = null;
            let groupVisible = false;

            rows.forEach(row => {
                if (row.classList.contains('table-secondary')) {
                    currentGroup = row;
                    groupVisible = false;
                    return;
                }

                const match = row.textContent.toLowerCase().includes(keyword);
                row.style.display = match ? '' : 'none';
                if (match && currentGroup) groupVisible = true;

                const nextRow = row.nextElementSibling;
                if (!nextRow || nextRow.classList.contains('table-secondary')) {
                    if (currentGroup) {
                        currentGroup.style.display = groupVisible ? '' : 'none';
                        currentGroup = null;
                    }
                }
            });
        });
    </script>
@endsection

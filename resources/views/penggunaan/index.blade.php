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
    <div class="basic-choices position-relative">
        <div class="row">
            <div class="col-12 position-relative">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body pb-0 pt-2 ps-2 pe-2">
                            <div class="row">
                                <div class="col-md-4 mb-0 p-0 pe-3 ps-3 pb-2">
                                    <div class="d-grid">
                                        <label for="bulan">Pilih Bulan Pemakaian</label>
                                        <select class="choices set-table form-control" name="bulan" id="bulan">
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
                                        <select class="choices set-table form-control" id="caters" name="caters">
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
    </div>
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

    <!-- Modal -->
    <div class="modal fade" id="CetakBuktiTagihan" tabindex="-1" aria-labelledby="CetakBuktiTagihanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="/usages/cetak" method="post" id="FormCetakBuktiTagihan" target="_blank">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-1 small">
                                    <strong>Cater</strong>: <span id="NamaCater"></span>
                                </div>
                                <div class="small">
                                    <strong>Maksimal Bayar</strong>: <span id="TanggalCetak"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="TbTagihan" class="table table-bordered table-striped align-middle">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th class="align-middle text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox" id="checked"
                                                        name="checked" checked>
                                                </div>
                                            </th>
                                            <th>Nama</th>
                                            <th>Desa</th>
                                            <th>RT</th>
                                            <th>No. Induk</th>
                                            <th>Meter Awal</th>
                                            <th>Meter Akhir</th>
                                            <th>Pemakaian</th>
                                            <th>Tagihan Air</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </form>

                    <form action="/usages/cetak_input" method="post" id="FormCetakBonggol" target="_blank" class="d-none">
                        @csrf
                        <div id="formbonggol"></div>
                    </form>
                    <form action="/usages/cetak_tagihan" method="post" id="FormCetakTagihan" target="_blank"
                        class="d-none">
                        @csrf
                        <div id="form"></div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="text-muted small">
                        Total pelanggan: <span id="TotalPelanggan">0</span>
                    </div>
                    <div>
                        <button type="button" id="BtnCetak1" class="btn btn-sm btn-dark">Cetak Daftar Tagihan</button>
                        <button type="button" id="BtnCetak" class="btn btn-sm btn-info text-white">Cetak Struk</button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
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
        // Datatable
        let Table = setDataTable('#TbTagihan')
        let table = setAjaxDatatable('#table1', '{{ url('usages') }}', [{
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
                data: "tgl_akhir"
            },
            {
                data: "status",
                render: function(data, type, row) {
                    if (data == 'UNPAID') {
                        return '<span class="badge bg-warning">Unpaid</span>';
                    } else if (data == 'PAID') {
                        return '<span class="badge bg-success">Paid</span>';
                    }
                }
            }
        ])

        $(document).on('change', '.set-table', function() {
            const cater = $('#caters').val();
            const bulan = $('#bulan').val();

            table.ajax.url('/usages?cater=' + cater + '&bulan=' + bulan).load();
        })
    </script>
    <script>
        $(document).on('click', '#DetailCetakBuktiTagihan', function() {
            fetchAllDataFullAndShowModal();
        });
        $(document).on('change', '#checked', function() {
            const isChecked = $(this).is(':checked');
            $('#TbTagihan tbody input[type="checkbox"]').prop('checked', isChecked);
        });

        function fetchAllDataFullAndShowModal() {
            $.ajax({
                url: "/usages",
                type: "GET",
                data: {
                    bulan: $('#bulan').val(),
                    cater: $('#caters').val(),
                },
                success: function(response) {
                    const fullData = response.data || response;

                    if (fullData.length > 0) {
                        const caterText = $('#caters option:selected').text();
                        const tanggal = fullData[0].tgl_akhir;
                        const tgl = tanggal.split('/');
                        const hari = tgl[0] - 1;

                        $('#NamaCater').text(caterText);
                        $('#TanggalCetak').text(`${hari}/${tgl[1]}/${tgl[2]}`);
                        $('#TotalPelanggan').text(fullData.length);
                    }

                    setTableData('#TbTagihan', fullData);
                    $('#CetakBuktiTagihan').modal('show');
                },
                error: function() {
                    alert('Gagal mengambil data lengkap');
                }
            });
        }

        function setTableData(target, data) {
            Table.destroy();
            var $tbody = $(target).find('tbody');
            $tbody.empty();

            const groupedByDusun = {};
            data.forEach(item => {
                const dusun = item.installation.village.dusun || 'Lainnya';
                if (!groupedByDusun[dusun]) groupedByDusun[dusun] = [];
                groupedByDusun[dusun].push(item);
            });

            const sortedDusun = Object.keys(groupedByDusun).sort();

            sortedDusun.forEach(dusun => {
                groupedByDusun[dusun].forEach(item => {
                    $tbody.append(`
                <tr>
                    <td align="center">
                        <div class="form-check ps-5 mb-0">
                            <input checked class="form-check-input" type="checkbox" value="${item.id}" id="${item.id}" name="cetak[]" data-input="checked" data-bulan="${item.bulan}">
                        </div>
                    </td>
                    <td>${item.customers.nama}</td>
                    <td>${item.installation.village.nama}</td>
                    <td class="text-center">${item.installation.rt}</td>
                    <td class="text-center">${item.installation.kode_instalasi} ${item.installation.package.kelas.charAt(0)}</td>
                    <td class="text-center">${item.awal}</td>
                    <td class="text-center">${item.akhir}</td>
                    <td class="text-center">${item.jumlah}</td>
                    <td class="text-end">${item.nominal}</td>
                    <td class="text-center">${item.status}</td>
                </tr>
            `);
                });
            });

            Table = setDataTable(target);
        }
    </script>
@endsection

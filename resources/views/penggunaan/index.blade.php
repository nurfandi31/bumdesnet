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

    <form action="" method="post" id="FormHapusPemakaian">
        @method('DELETE')
        @csrf
    </form>
@endsection
@section('script')
    <script>
        let table;

        function loadTable() {
            const cater = $('#caters').val();
            const bulan = $('#bulan').val();

            if (table) {
                table.destroy();
                $('#table1 tbody').empty();
            }

            table = $('#table1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('usages') }}',
                    data: {
                        cater: cater,
                        bulan: bulan
                    }
                },
                columns: [{
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
                            if (data === 'UNPAID') {
                                return '<span class="badge bg-warning">Unpaid</span>';
                            } else if (data === 'PAID') {
                                return '<span class="badge bg-success">Paid</span>';
                            }
                        }
                    }
                ],
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                }
            });
        }

        $(document).on('change', '.set-table', function() {
            loadTable()
        })

        loadTable()
    </script>
@endsection

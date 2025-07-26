@extends('Layout.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped w-100" id="daftar-maintenance">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Instalasi</th>
                        <th>Customer</th>
                        <th>Tanggal Maintenance</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade text-left w-100" id="modal-daftar-maintenance" tabindex="-1" aria-labelledby="daftar-maintenance"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Maintenance</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 col-md-4">
                            Kode Maintenance
                        </div>
                        <div class="col-6 col-md-8">
                            <span id="kode_maintenance"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-4">
                            Kode Instalasi
                        </div>
                        <div class="col-6 col-md-8">
                            <span id="kode_instalasi"></span>
                        </div>
                    </div>

                    <table class="table table-bordered" id="daftar-barang-maintenance">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Barang Lama</th>
                                <th>Barang Baru</th>
                                <th class="text-center">Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <span>Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var table = $('#daftar-maintenance').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/maintenances',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'installations.kode_instalasi',
                    name: 'installations.kode_instalasi'
                },
                {
                    data: 'installations.customer.nama',
                    name: 'installations.customer.nama'
                },
                {
                    data: 'tgl_transaksi',
                    name: 'tgl_transaksi',
                    render: function(data, type, row, meta) {
                        return row.tgl_transaksi.split("-").reverse().join("/");
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        $(document).on('click', '.show-maintenance', function(e) {
            e.preventDefault();
            var data = table.row($(this).closest('tr')).data();

            console.log(data)

            $('#kode_maintenance').html(data.transaction_id);
            $('#kode_instalasi').html(data.installations.kode_instalasi);

            var tableDaftarBarang = $('#daftar-barang-maintenance')
            tableDaftarBarang.find('tbody').empty();
            data.maintenance.forEach((item, index) => {
                var namaProdukLama = '';
                if (item.pairing) {
                    namaProdukLama = item.pairing.product.name
                    if (item.pairing.product_variation) {
                        namaProdukLama += ' - ' + item.pairing.product_variation.name
                    }
                }

                var namaProdukBaru = item.product.name;
                if (item.product_variation) {
                    namaProdukBaru += ' - ' + item.product_variation.name
                }

                tableDaftarBarang.find('tbody').append(`
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${namaProdukLama}</td>
                        <td>${namaProdukBaru}</td>
                        <td class="text-center">${item.jumlah}</td>
                        <td>${item.catatan}</td>
                    </tr>
                `);
            })

            $('#modal-daftar-maintenance').modal('show');
        })
    </script>
@endsection

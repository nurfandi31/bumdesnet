@extends('Layout.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped w-100" id="daftar-pasang-baru">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Instalasi</th>
                        <th>Customer</th>
                        <th>Tanggal Pemasangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade text-left w-100" id="modal-daftar-pasang-baru" tabindex="-1" aria-labelledby="daftar-pasang-baru"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Pasanga Baru</h4>
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
                        <div class="col-md-4 mb-3">
                            <div class="card mb-0 h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center flex-column">
                                        <div class="avatar avatar-2xl">
                                            <img src="/assets/static/images/faces/profile.png" alt="Avatar">
                                        </div>

                                        <h3 class="mt-3" id="namaCustomer"></h3>
                                        <p class="text-small" id="nikCustomer"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="card mb-0 h-100">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Kode Instalasi</span>
                                            <span id="kodeInstalasi"></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Tanggal Registrasi</span>
                                            <span id="tanggalRegistrasi"></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Tanggal Pemasangan</span>
                                            <span id="tanggalPemasangan"></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Biaya Instalasi</span>
                                            <span id="biayaInstalasi"></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Alamat</span>
                                            <span id="alamat"></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">
                                                Lokasi
                                                <a href="" id="linkKoordinat" target="_blank"
                                                    class="text-decoration-none text-secondary">
                                                    <i class="fa fa-external-link"></i>
                                                </a>
                                            </span>
                                            <span id="koordinat"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h5>Daftar Barang</h5>
                                    <div class="table-responsive rounded-3">
                                        <table class="table table-striped" id="daftar-barang">
                                            <thead>
                                                <tr>
                                                    <th>Nama Barang</th>
                                                    <th>Kuantitas</th>
                                                    <th>Biaya</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <span>Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="form-delete-pairing">
        @method('DELETE')
        @csrf

    </form>
@endsection

@section('script')
    <script>
        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        });

        var table = $('#daftar-pasang-baru').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/pairings",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'kode_instalasi',
                    name: 'kode_instalasi',
                },
                {
                    data: 'customer.nama',
                    name: 'customer.nama'
                },
                {
                    data: 'tgl_pairing',
                    name: 'tgl_pairing',
                    render: function(data, type, row, meta) {
                        return row.tgl_pairing.split("-").reverse().join("/");
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row, meta) {
                        if (data == 'R') {
                            return '<span class="badge bg-success">Paid</span>';
                        }

                        if (data == '0') {
                            return 'span class="badge bg-danger">Unpaid</span>';
                        }

                        if (data == 'I') {
                            return '<span class="badge bg-success">Pasang</span>';
                        }

                        if (data == 'A') {
                            return '<span class="badge bg-success">Aktif</span>';
                        }

                        if (data == 'B') {
                            return '<span class="badge bg-danger">Menunggak</span>';
                        }

                        if (data == 'C') {
                            return '<span class="badge bg-warning">Cabut</span>';
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false
                }
            ],
            order: [
                [0, 'asc']
            ],
        });

        $(document).on('click', '.show-pairing', function(e) {
            e.preventDefault();
            var data = table.row($(this).closest('tr')).data();

            $('#namaCustomer').text(data.customer.nama);
            $('#nikCustomer').text(data.customer.nik);

            $('#kodeInstalasi').text(data.kode_instalasi);
            $('#tanggalRegistrasi').text(data.order.split("-").reverse().join("/"));
            $('#tanggalPemasangan').text(data.tgl_pairing.split("-").reverse().join("/"));
            $('#biayaInstalasi').text('Rp. ' + formatter.format(data.biaya_instalasi));
            $('#alamat').text(data.alamat);
            $('#koordinat').text(data.koordinate);

            $('#linkKoordinat').attr('href', 'https://www.google.com/maps/search/?api=1&query=' + data.koordinate);

            $('#daftar-barang tbody').empty();
            $.each(data.pairings, function(index, item) {
                $('#daftar-barang tbody').append(`
                    <tr>
                        <td>${item.product.name} ${item.product_variation ? '(' + item.product_variation.name + ')' : ''}</td>
                        <td>${item.jumlah}</td>
                        <td>Rp. ${formatter.format((item.product_variation ? item.product_variation.harga_jual : item.product.harga_jual))}</td>
                    </tr>
                `);
            })

            $('#modal-daftar-pasang-baru').modal('show');
        })

        $(document).on('click', '.delete-pairing', function(e) {
            e.preventDefault()
            var tr = $(this).closest('tr')
            var data = table.row(tr).data()

            Swal.fire({
                title: 'Hapus Pemasangan?',
                text: "Pemasangan akan dihapus! Apakah Anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#form-delete-pairing')
                    form.attr('action', '/pairings/' + data.id)

                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            if (response.success) {
                                toastMixin.fire({
                                    title: response.msg
                                });

                                table.ajax.reload();
                            }
                        },
                    })
                }
            })
        })
    </script>
@endsection

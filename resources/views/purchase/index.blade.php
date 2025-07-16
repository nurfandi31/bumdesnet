@extends('Layout.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped w-100" id="daftar-pembelian">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>No. Ref</th>
                        <th>Total</th>
                        <th>Dibayar</th>
                        <th>Status Pembelian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="modal fade text-left w-100" id="modal-detail-pembelian" tabindex="-1" aria-labelledby="detail-pembelian"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Pembelian</h4>
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
                    <div class="list-group">
                        <span class="list-group-item">
                            <span class="fw-bold">Tanggal</span>
                            <span> : </span>
                            <span id="tanggal-pembelian"></span>
                        </span>
                        <span class="list-group-item">
                            <span class="fw-bold">No. Ref</span>
                            <span> : </span>
                            <span id="no-ref-pembelian"></span>
                        </span>
                        <span class="list-group-item">
                            <span class="fw-bold">Status Pembelian</span>
                            <span> : </span>
                            <span id="status-pembelian" class="text-capitalize"></span>
                        </span>
                    </div>

                    <table class="table table-bordered w-100" id="daftar-barang-pembelian">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th class="text-center">Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Jumlah</th>
                                <th class="text-end" id="total-harga-pembelian">0</th>
                                <th class="text-end" id="total-subtotal-pembelian">0</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Dibayar</th>
                                <th class="text-end"></th>
                                <th class="text-end" id="total-pembayaran">0</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Kekurangan</th>
                                <th class="text-end"></th>
                                <th class="text-end" id="total-kekurangan">0</th>
                            </tr>
                        </tfoot>
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

    <form action="" method="post" id="form-hapus-pembelian">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('script')
    <script>
        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        });

        var table = $('#daftar-pembelian').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/purchases",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tgl_beli',
                    name: 'tgl_beli',
                    render: function(data, type, row) {
                        return row.tgl_beli.split("-").reverse().join("/");
                    }
                },
                {
                    data: 'no_ref',
                    name: 'no_ref'
                },
                {
                    data: 'total',
                    name: 'total',
                    render: function(data, type, row) {
                        return formatter.format(row.total);
                    }
                },
                {
                    data: 'dibayar',
                    name: 'dibayar',
                    render: function(data, type, row) {
                        return formatter.format(row.dibayar);
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        var badge = 'danger';
                        if (row.status == 'dibayar') {
                            badge = 'success';
                        }

                        if (row.status == 'sebagian') {
                            badge = 'warning';
                        }

                        return '<span class="text-capitalize badge bg-' + badge + '">' + row.status +
                            '</span>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        })

        $(document).on('click', '.show-purchase', function(e) {
            e.preventDefault()

            var tr = $(this).closest('tr')
            var data = table.row(tr).data()

            $('#tanggal-pembelian').html(data.tgl_beli.split("-").reverse().join("/"))
            $('#no-ref-pembelian').html(data.no_ref)
            $('#status-pembelian').html(data.status)

            $('#daftar-barang-pembelian tbody').html('')
            data.product_purchases.forEach((item, index) => {
                var productName = item.product.name
                if (item.variation) {
                    productName += ' (' + item.variation.name + ')'
                }

                $('#daftar-barang-pembelian tbody').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${productName}</td>
                        <td class="text-center">${item.qty}</td>
                        <td class="text-end">${formatter.format(item.harga_beli)}</td>
                        <td class="text-end">${formatter.format(item.total)}</td>
                    </tr>
                `)
            })

            $('#total-harga-pembelian').html(formatter.format(data.total_harga_beli))
            $('#total-subtotal-pembelian').html(formatter.format(data.total))

            var totalBayar = 0
            data.transactions.forEach((item) => {
                totalBayar += item.total
            })

            $('#total-pembayaran').html(formatter.format(totalBayar))
            $('#total-kekurangan').html(formatter.format(data.total - totalBayar))

            $('#modal-detail-pembelian').modal('show')
        })

        $(document).on('click', '.delete-purchase', function(e) {
            e.preventDefault()

            var tr = $(this).closest('tr')
            var data = table.row(tr).data()

            var form = $('#form-hapus-pembelian')
            form.attr('action', '/purchases/' + data.id)

            Swal.fire({
                title: 'Hapus Pembelian ' + data.no_ref + '?',
                text: "Pembelian akan dihapus dengan semua transaksi yang terkait! Apakah Anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            if (response.success) {
                                toastMixin.fire({
                                    title: response.msg
                                });

                                table.ajax.reload()
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection

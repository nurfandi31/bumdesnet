@extends('Layout.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="daftar-produk" style="width: 100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="modal fade text-left w-100" id="modal-detail-produk" tabindex="-1" aria-labelledby="detail-produk"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Produk</h4>
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
                        <div class="col-md-4">
                            <img src="" alt="Gambar Produk" class="w-100 rounded" id="gambar-produk">
                        </div>
                        <div class="col-md-8">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Nama Produk</span>
                                    <span id="nama-produk"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Kategori</span>
                                    <span id="kategori-produk"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Jumlah Stok</span>
                                    <span id="stok-produk"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Harga Beli</span>
                                    <span id="harga-beli-produk"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Harga Jual</span>
                                    <span id="harga-jual-produk"></span>
                                </li>
                                <li class="list-group-item d-flex flex-column">
                                    <span class="fw-bold">Deskripsi</span>
                                    <span id="deskripsi-produk" style="text-align: justify;"></span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <h5>Varian Produk</h5>
                            <table class="table table-bordered" id="daftar-varian">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Varian</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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

    <form action="" method="post" id="form-delete-product">
        @method('DELETE')
        @csrf

    </form>
@endsection

@section('script')
    <script>
        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });

        var table = $('#daftar-produk').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/products",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'gambar',
                    name: 'gambar',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<div class="avatar avatar-xl"><img src="/storage/product/${row.gambar}" width="100"></div>`
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'category.name',
                    name: 'category.name'
                },
                {
                    data: 'harga_beli',
                    name: 'harga_beli'
                },
                {
                    data: 'harga_jual',
                    name: 'harga_jual'
                },
                {
                    data: 'stok',
                    name: 'stok'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        })

        $(document).on('click', '.show-product', function(e) {
            e.preventDefault()

            var tr = $(this).closest('tr')
            var data = table.row(tr).data()

            $('#gambar-produk').attr('src', `/storage/product/${data.gambar}`)
            $('#nama-produk').html(data.name)
            $('#kategori-produk').html(data.category.name)
            $('#stok-produk').html(data.stok)
            $('#harga-beli-produk').html(data.harga_beli)
            $('#harga-jual-produk').html(data.harga_jual)
            $('#deskripsi-produk').html(data.deskripsi)

            $('#daftar-varian tbody').html('')
            if (data.variations.length > 0) {
                data.variations.forEach((item, i) => {
                    $('#daftar-varian tbody').append(`
                        <tr>
                            <td>${i+1}</td>
                            <td>${item.name}</td>
                            <td>Rp. ${formatter.format(item.harga_beli)}</td>
                            <td>Rp. ${formatter.format(item.harga_jual)}</td>
                            <td>${item.stok}</td>
                        </tr>
                    `)
                })
            }

            $('#modal-detail-produk').modal('show')
        })

        $(document).on('click', '.delete-product', function(e) {
            e.preventDefault()
            var tr = $(this).closest('tr')
            var data = table.row(tr).data()

            Swal.fire({
                title: 'Hapus Produk ' + data.name + '?',
                text: "Produk akan dihapus dengan semua varian yang terkait! Apakah Anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#form-delete-product')
                    form.attr('action', '/products/' + data.id)

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

@extends('Layout.base')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-end">
                <button type="button" id="TambahKategori" class="btn btn-primary">Tambah Kategori</button>
            </div>
            <div class="table-responsive responsive p-2">
                <table class="table table-striped" id="daftar-kategori">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jumlah Produk</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade text-left modal-borderless" id="modal-form-category" tabindex="-1"
        aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label"></h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="form-category">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" id="nama_kategori" class="form-control" name="nama_kategori"
                                placeholder="Nama Kategori">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger ms-1" id="btn-delete-category">
                        <span>Hapus</span>
                    </button>
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <span>Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ms-1" id="btn-save-category">
                        <span>Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var table = $('#daftar-kategori').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/category",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'product_count',
                    name: 'product_count'
                },
            ]
        })

        $(document).on('click', '#TambahKategori', function() {
            $('#form-category')[0].reset();
            $('#form-category').attr('action', '/category');
            $('#form-category').attr('method', 'POST');

            $('input[name="_method"]').val('POST');
            $('#btn-delete-category').hide()

            $('#modal-label').html('Tambah Kategori');
            $('#modal-form-category').modal('show');
        })

        $('#daftar-kategori').on('click', 'tbody tr', function(e) {
            var data = table.row(this).data();

            $('#form-category')[0].reset();
            $('#form-category').attr('action', '/category/' + data.id);
            $('#form-category').attr('method', 'PUT');

            $('input[name="_method"]').val('PUT');
            $('#nama_kategori').val(data.name);
            $('#btn-delete-category').show()

            $('#modal-label').html('Edit Kategori');
            $('#modal-form-category').modal('show');
        })

        $(document).on('click', '#btn-save-category', function(e) {
            e.preventDefault();

            var form = $('#form-category');
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Sukses', response.msg, 'success').then(() => {
                            $('#modal-form-category').modal('hide');
                            table.ajax.reload();
                        })
                    }
                },
                error: function(response) {
                    if (response.responseJSON.message) {
                        Swal.fire('Gagal', response.responseJSON.message, 'error');
                    }
                }
            })
        })

        $(document).on('click', '#btn-delete-category', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Hapus Kategori",
                text: "Kategori akan dihapus dengan semua produk yang terkait! Apakah Anda yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-category').attr('method', 'DELETE');
                    $('input[name="_method"]').val('DELETE');

                    var form = $('#form-category');
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Sukses', response.msg, 'success').then(() => {
                                    $('#modal-form-category').modal('hide');
                                    table.ajax.reload();
                                })
                            }
                        },
                        error: function(response) {
                            if (response.responseJSON.message) {
                                Swal.fire('Gagal', response.responseJSON.message, 'error');
                            }
                        }
                    })
                }
            });
        });
    </script>
@endsection

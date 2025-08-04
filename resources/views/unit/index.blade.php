@extends('Layout.base')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-end">
                <button type="button" id="TambahSatuan" class="btn btn-primary">Tambah Satuan</button>
            </div>
            <div class="table-responsive responsive p-2">
                <table class="table table-striped" id="daftar-unit">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Satuan</th>
                            <th>Satuan Singkat</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade text-left modal-borderless" id="modal-form-unit" tabindex="-1" aria-labelledby="myModalLabel1"
        style="display: none;" aria-hidden="true">
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
                    <form action="" method="post" id="form-unit">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label for="nama_satuan">Nama Satuan</label>
                            <input type="text" id="nama_satuan" class="form-control" name="nama_satuan"
                                placeholder="Nama Satuan">
                        </div>
                        <div class="form-group">
                            <label for="nama_singkat">Nama Singkat</label>
                            <input type="text" id="nama_singkat" class="form-control" name="nama_singkat"
                                placeholder="Nama Singkat">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger ms-1" id="btn-delete-unit">
                        <span>Hapus</span>
                    </button>
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <span>Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ms-1" id="btn-save-unit">
                        <span>Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var table = $('#daftar-unit').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/units",
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
                    data: 'short_name',
                    name: 'short_name'
                },
            ]
        })

        $(document).on('click', '#TambahSatuan', function() {
            $('#form-unit')[0].reset();
            $('#form-unit').attr('action', '/units');
            $('#form-unit').attr('method', 'POST');

            $('input[name="_method"]').val('POST');
            $('#btn-delete-unit').hide()

            $('#modal-label').html('Tambah Satuan');
            $('#modal-form-unit').modal('show');
        })

        $('#daftar-unit').on('click', 'tbody tr', function(e) {
            var data = table.row(this).data();

            $('#form-unit')[0].reset();
            $('#form-unit').attr('action', '/units/' + data.id);
            $('#form-unit').attr('method', 'PUT');

            $('input[name="_method"]').val('PUT');
            $('#nama_satuan').val(data.name);
            $('#nama_singkat').val(data.short_name);
            $('#btn-delete-unit').show()

            $('#modal-label').html('Edit Satuan');
            $('#modal-form-unit').modal('show');
        })

        $(document).on('click', '#btn-save-unit', function(e) {
            e.preventDefault();

            var form = $('#form-unit');
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Sukses', response.msg, 'success').then(() => {
                            $('#modal-form-unit').modal('hide');
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

        $(document).on('click', '#btn-delete-unit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Hapus Kategori",
                text: "Satuan akan dihapus dengan semua produk yang terkait! Apakah Anda yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-unit').attr('method', 'DELETE');
                    $('input[name="_method"]').val('DELETE');

                    var form = $('#form-unit');
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Sukses', response.msg, 'success').then(() => {
                                    $('#modal-form-unit').modal('hide');
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

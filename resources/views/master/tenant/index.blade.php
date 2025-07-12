@extends('master.layouts.base', [
    'pageTitle' => 'Daftar Tenant',
])

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive p-3">
                <table class="table table-striped" id="daftar-tenant">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Tenant</th>
                            <th>Domain</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade text-left modal-borderless" id="modal-edit-tenant" tabindex="-1" aria-labelledby="myModalLabel1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tenant-label"></h5>
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
                    <form action="" method="post" id="form-edit-tenant">
                        @csrf
                        @method('PUT')

                        <input type="hidden" class="tenant_id" name="tenant_id">
                        <div id="form-input">

                        </div>
                    </form>
                    <div class="d-grid" id="add-input-domain">
                        <button type="button" id="btn-add-domain" class="btn btn-primary">Tambah Domain</button>
                    </div>

                    <form action="" method="post" id="form-delete-tenant">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" class="tenant_id" name="tenant_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger ms-1" id="btn-delete-tenant">
                        <span>Hapus</span>
                    </button>
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <span>Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ms-1" id="btn-save-tenant">
                        <span>Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const table = $('#daftar-tenant').DataTable({
            language: {
                paginate: {
                    previous: "&laquo;",
                    next: "&raquo;"
                }
            },
            processing: true,
            serverSide: true,
            ajax: "/tenant",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'domain',
                    name: 'domain'
                },
            ]
        })

        $('#daftar-tenant').on('click', 'tbody tr', function(e) {
            var data = table.row(this).data();

            var label = data.id.split('_').join(' ');
            label = label.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });

            $('#tenant-label').text(label)
            $('.tenant_id').val(data.id)

            domainList = []
            data.domains.forEach((element, index) => {
                domainList.push({
                    id: element.id,
                    domain: element.domain,
                    readonly: (index == 0) ? true : false
                })
            })

            $('#form-edit-tenant').attr('action', '/tenant/' + data.id)
            $('#form-delete-tenant').attr('action', '/tenant/' + data.id)

            $('#form-input').empty()
            formInputDomain(domainList)
            $('#modal-edit-tenant').modal('show')
        })

        $(document).on('click', '#btn-save-tenant', function(e) {
            e.preventDefault()

            var form = $('#form-edit-tenant')
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Berhasil', response.msg, 'success').then((res) => {
                            $('#modal-edit-tenant').modal('hide')
                            table.ajax.reload()
                        })
                    }
                }
            })
        })

        $(document).on('click', '#btn-delete-tenant', function(e) {
            e.preventDefault()

            Swal.fire({
                title: "Hapus Tenant",
                text: "Tenant akan dihapus secara permanen dari aplikasi tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus",
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#form-delete-tenant')
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Berhasil', response.msg, 'success').then((res) => {
                                    $('#modal-edit-tenant').modal('hide')
                                    table.ajax.reload()
                                })
                            }
                        }
                    })
                }
            });
        })

        $(document).on('click', '#btn-add-domain', function(e) {
            e.preventDefault()

            domainList = [{
                id: '',
                domain: ''
            }];
            formInputDomain(domainList)
        })

        $(document).on('click', '.btn-delete-domain', function(e) {
            e.preventDefault()
            var id = $(this).attr('id')

            var container = $('#form-input')
            if (container.find(`input[type="url"]`).length > 1) {
                $(this).parent().remove()
            }
        })

        function formInputDomain(domainList) {
            domainList.forEach((element, index) => {
                var readonly = (element.readonly) ? 'readonly' : ''

                $('#form-input').append(`
                    <div class="input-group mb-3">
                        <input type="url" class="form-control" name="domain[${element.id}]"
                            aria-describedby="${element.id}" ${readonly} value="${element.domain}">
                        <button class="btn btn-danger btn-delete-domain" type="button" id="${element.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `)
            })
        }
    </script>
@endsection

@extends('Layout.base')

@section('content')
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

    <div class="app-main__inner">
        <div class="tab-content">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div id="akun">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="" method="post" id="formCoa">
        @csrf

        @method('POST')
        <input type="hidden" name="id_akun" id="id_akun">
        <input type="hidden" name="nama_akun" id="nama_akun">
    </form>
@endsection

@section('script')
    <script>
        $('#akun').jstree({
            'core': {
                'check_callback': true,
                'data': {
                    "url": "/pengaturan/akun_coa",
                    "dataType": "json"
                }
            },
            'plugins': ['contextmenu', 'dnd', 'crrm'],
            'contextmenu': {
                'items': function($node) {
                    var tree = $('#akun').jstree(true);

                    var node = tree.get_node(
                        $node
                    ) // Data dari baris yang diklik | {id: '1.1.01.00', text: 'test', children: []}
                    var kode_akun = node.id // Ambil data id | 1.1.01.00
                    var array_kode_akun = kode_akun.split('.') // Memecah id || ['1', '1', '01', '00']

                    var lev1 = parseInt(array_kode_akun[0]); // 1
                    var lev2 = parseInt(array_kode_akun[1]); // 1
                    var lev3 = parseInt(array_kode_akun[2]); // 01
                    var lev4 = parseInt(array_kode_akun[3]); // 00

                    var items = {};

                    // Pengecekan Akun Level 3
                    if (lev1 > 0 && lev2 > 0 && lev3 > 0 && lev4 == 0) {
                        var children = node.children

                        var child_kode_akun = children[children.length - 1].split('.')
                        var child_lev1 = parseInt(child_kode_akun[0]);
                        var child_lev2 = parseInt(child_kode_akun[1]);
                        var child_lev3 = parseInt(child_kode_akun[2]);
                        var child_lev4 = parseInt(child_kode_akun[3]) + 1;

                        child_lev4 = child_lev4.toString().padStart(2, '0');
                        items.Create = {
                            "separator_before": false,
                            "separator_after": false,
                            "label": "Tambah",
                            "action": function(obj) {
                                var id = `${child_lev1}.${child_lev2}.0${child_lev3}.${child_lev4}`
                                $node = tree.create_node($node, {
                                    "id": id,
                                    "text": id + ". Akun Baru",
                                });
                                tree.edit($node);
                            }
                        }

                        items.Rename = {
                            "separator_before": false,
                            "separator_after": false,
                            "label": "Edit",
                            "action": function(obj) {
                                tree.edit($node);
                            }
                        };
                    }

                    if ((lev1 > 0 && lev2 > 0 && lev3 > 0 && lev4 > 0) || tree.get_node($node).children
                        .length === 0) {
                        items.Rename = {
                            "separator_before": false,
                            "separator_after": false,
                            "label": "Edit",
                            "action": function(obj) {
                                tree.edit($node);
                            }
                        };

                        items.Remove = {
                            "separator_before": false,
                            "separator_after": false,
                            "label": "Hapus",
                            "action": function(obj) {
                                Swal.fire({
                                    title: 'Peringatan',
                                    text: 'Hapus akun ' + tree.get_node($node).text,
                                    showCancelButton: true,
                                    confirmButtonText: 'Hapus Kode Akun',
                                    cancelButtonText: 'Batal',
                                    icon: 'warning'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        tree.delete_node($node);
                                    }
                                })
                            }
                        };
                    }

                    return items;

                }
            }
        }).on('create_node.jstree', function(e, data) {
            var id = data.node.id
            var text = data.node.text

            $('#id_akun').val(id)
            $('#nama_akun').val(text)
            $('#formCoa input[name=_method]').val('POST')

            $('#formCoa').attr('action', '/pengaturan/coa')
            formSubmit('create', data)
        }).on('rename_node.jstree', function(e, data) {
            var id = data.node.id
            var text = data.node.text
            var old_text = data.old

            if (text != old_text) {
                $('#id_akun').val(id)
                $('#nama_akun').val(text)
                $('#formCoa input[name=_method]').val('PUT')

                $('#formCoa').attr('action', '/pengaturan/coa/' + id)
                formSubmit('update', data)
            }
        }).on('delete_node.jstree', function(e, data) {
            var id = data.node.id
            var text = data.node.text

            $('#id_akun').val(id)
            $('#nama_akun').val(text)
            $('#formCoa input[name=_method]').val('DELETE')

            $('#formCoa').attr('action', '/pengaturan/coa/' + id)
            formSubmit('delete', data)
        });

        function formSubmit(action, data = null) {
            var form = $('#formCoa')
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        if (action == 'create') {
                            data.instance.set_id(data.node, result.id);
                        }

                        if (action != 'delete') {
                            data.instance.set_text(data.node, result.nama_akun);
                        }

                        toastMixin.fire({
                            title: result.msg
                        });
                    } else {
                        if (action == 'create') {
                            data.instance.delete_node(data.node);
                        }

                        if (action == 'update') {
                            data.instance.set_text(data.node, data.old);
                            console.log(data)
                        }

                        toastMixin.fire({
                            title: result.msg
                        });
                    }
                }
            })
        }
    </script>
@endsection

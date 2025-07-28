@extends('Layout.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="/maintenances" method="post" id="form-maintenance">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="position-relative mb-3">
                            <label for="instalasi">Instalasi</label>
                            <select class="choices form-control" name="instalasi" id="instalasi">
                                <option value="">---</option>
                                @foreach ($installations as $installation)
                                    <option value="{{ $installation->id }}">
                                        {{ $installation->kode_instalasi }}. {{ $installation->customer->nama }}
                                        [{{ $installation->customer->nik }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggal_maintenance">Tanggal Maintenance</label>
                            <input type="text" id="tanggal_maintenance" class="form-control date"
                                name="tanggal_maintenance" placeholder="Tanggal Maintenance" autocomplete="off"
                                value="{{ date('d/m/Y') }}">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <table class="table" id="daftar-produk">
                        <thead>
                            <tr>
                                <th>Barang Lama</th>
                                <th>Barang Baru</th>
                                <th class="text-end">Harga Satuan</th>
                                <th width="5%" class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-end">
                                    <i class="fas fa-trash"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" id="penggantianProduk" class="btn btn-warning">
                        Penggantian Komponen
                    </button>
                    <button type="button" id="SimpanMaintenance" class="btn btn-primary ms-1">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade text-left" id="modal-maintenance" tabindex="-1" aria-labelledby="modal-maintenance"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Maintenance
                    </h4>
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
                        <div class="col-md-12" id="col_daftar_barang">
                            <div class="position-relative mb-3">
                                <label for="daftar_barang">Daftar Barang</label>
                                <select class="choices form-control" name="daftar_barang" id="daftar_barang">
                                    <option value="">---</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="text" id="cariProduk" class="form-control form-control-lg"
                                placeholder="Cari Produk..">
                            <input type="hidden" name="category" id="category">
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="text" id="harga" class="form-control" name="harga" placeholder="harga"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" id="jumlah" class="form-control" name="jumlah"
                                    placeholder="jumlah" min="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subtotal">Subtotal</label>
                                <input type="text" id="subtotal" class="form-control" name="subtotal"
                                    placeholder="subtotal" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="catatan">Catatan</label>
                                <textarea name="catatan" id="catatan" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <span>Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ms-1" id="tambahkanProduk">
                        <span>Tambahkan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var dataInstalasi = @json($installations);
        var dataPairings;
        var dataProduk;

        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        });

        $('.date').datetimepicker({
            timepicker: false,
            format: 'd/m/Y'
        });

        $(document).on('click', '#penggantianProduk', function() {
            var idInstalasi = $('#instalasi').val();
            if (idInstalasi) {
                if (!Array.isArray(dataPairings)) {
                    var instalasi = dataInstalasi.find(instalasi => instalasi.id == idInstalasi);
                    dataPairings = instalasi.pairings;
                }

                var selectDaftarBarang = [{
                    value: "",
                    label: "---"
                }];

                dataPairings.forEach(pairing => {
                    var label = pairing.product.name + (pairing.product_variation ? ' - ' + pairing
                        .product_variation.name : '');
                    selectDaftarBarang.push({
                        value: pairing.id,
                        label
                    });
                });

                choiceData['daftar_barang'].setChoices(selectDaftarBarang, 'value', 'label', true);
                choiceData['daftar_barang'].setChoiceByValue('');

                $('#cariProduk').attr('disabled', true);
                $("#col_daftar_barang").show()
            } else {
                $('#cariProduk').attr('disabled', false);
                $("#col_daftar_barang").hide()
            }

            $('#modal-maintenance').modal('show');
        })

        $(document).on('change', '#daftar_barang', function() {
            var id = $(this).val();

            if (id) {
                $('#cariProduk').attr('disabled', false);
                var pairing = dataPairings.find(pairing => pairing.id == id);

                $('#category').val(pairing.product.category_id);
            } else {
                $('#cariProduk').attr('disabled', true);
                $('#category').val('')
            }
        })

        $(document).on('change', '#jumlah', function() {
            var harga = parseInt($('#harga').val().split(',').join(''));
            var jumlah = $(this).val();

            dataProduk.jumlah = jumlah;
            dataProduk.subtotal = harga * jumlah;

            $('#subtotal').val(formatter.format(dataProduk.subtotal));
        })

        $(document).on('click', '#tambahkanProduk', function() {
            var id = $('#daftar_barang').val();
            if (id) {
                var pairing = dataPairings.find(pairing => pairing.id == id);

                var namaBarang = pairing.product.name + (pairing.product_variation ? ' - ' + pairing
                    .product_variation.name : '');

                dataProduk.barang_lama = namaBarang;
                dataProduk.pairing_id = id;

                dataPairings = dataPairings.filter(pairing => pairing.id != id);
            }

            dataProduk.catatan = $('#catatan').val();
            addProductRow(dataProduk);
            dataProduk = null;

            choiceData['daftar_barang'].clearChoices();
            choiceData['daftar_barang'].clearInput();

            $('.modal-body input').val('');
            $('#modal-maintenance').modal('hide');
        })

        $(document).on('click', '.btn-delete-product', function() {
            var parent = $(this).parent();
            var pairing_id = parent.find('input[name="pairing_id[]"]').val();

            var idInstalasi = $('#instalasi').val();
            var instalasi = dataInstalasi.find(instalasi => instalasi.id == idInstalasi);
            var pairings = instalasi.pairings;

            var pairing = pairings.find(pairing => pairing.id == pairing_id);
            dataPairings.push(pairing);

            var tr = parent.parent();
            tr.remove();
        })

        $(document).on('click', "#SimpanMaintenance", function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            form.submit();
        })

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func.apply(this, args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        $('#cariProduk').typeahead({
            classNames: {
                menu: 'w-100',
                dataset: 'list-group shadow',
            }
        }, {
            source: debounce(function(query, syncResults, asyncResults) {
                if (query.length < 2) return;

                $.get('/maintenances/search-product', {
                    query: query,
                    category: $('#category').val()
                }, function(result) {
                    const states = [];

                    result.map(function(item) {
                        states.push({
                            name: item.name,
                            value: item.id,
                            item
                        });
                    });

                    asyncResults(states);
                }).fail(function(xhr, status, error) {
                    console.log(error);
                    asyncResults([]);
                });
            }, 500),
            displayKey: 'name',
            templates: {
                empty: [
                    '<div class="list-group-item text-center">',
                    'Produk tidak ditemukan',
                    '</div>'
                ].join('\n'),
                suggestion: function(data) {
                    var harga_jual = formatter.format(data.item.harga_jual);
                    return `<a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${data.item.name}</h5>
                                    <small>${data.item.category_name}</small>
                                </div>
                                <p class="mb-1">${data.item.deskripsi}</p>
                                <div class="d-flex w-100 justify-content-between">
                                    <small>Harga Jual: Rp. ${harga_jual}</small>
                                    <small>Stok:${data.item.stok}</small>
                                </div>
                            </a>`;
                }
            },
            items: 10
        }).bind('typeahead:selected', function(event, selectedItem) {
            checkProduct(selectedItem.item);
        });

        function checkProduct(product) {
            if (dataProduk?.name == product.name) {
                dataProduk.jumlah += 1;
            } else {
                dataProduk = product;
                dataProduk.jumlah = 1;
            }

            $('#harga').val(formatter.format(dataProduk.harga_jual));
            $('#jumlah').val(dataProduk.jumlah);
            $('#subtotal').val(formatter.format(dataProduk.harga_jual * dataProduk.jumlah));

            $('#product_id').val(dataProduk.id);
            $('#product_variation_id').val(dataProduk.variation_id);

            $('#jumlah').attr('max', dataProduk.stok);

            dataProduk.subtotal = dataProduk.harga_jual * dataProduk.jumlah;
        }

        function addProductRow(product) {
            var table = $('#daftar-produk');
            var tbody = table.find('tbody');

            var newRow = `<tr>
                    <td>${product.barang_lama || '-'}</td>
                    <td>${product.name}</td>
                    <td class="text-end">${formatter.format(product.harga_jual)}</td>
                    <td class="text-center">${product.jumlah}</td>
                    <td class="text-end">${formatter.format(product.subtotal)}</td>
                    <td class="text-end">
                        <input type="hidden" name="product_id[]" value="${product.id}">
                        <input type="hidden" name="product_variation_id[]" value="${product.variation_id}">
                        <input type="hidden" name="pairing_id[]" value="${product.pairing_id || '0'}">
                        <input type="hidden" name="barang_lama[]" value="${product.barang_lama || ''}">
                        <input type="hidden" name="jumlah[]" value="${product.jumlah}">
                        <input type="hidden" name="harga_jual[]" value="${product.harga_jual}">
                        <input type="hidden" name="subtotal[]" value="${product.subtotal}">
                        <input type="hidden" name="catatan[]" value="${product.catatan}">
                        <button class="btn btn-danger btn-sm btn-delete-product" type="button">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;

            tbody.append(newRow);
        }
    </script>
@endsection

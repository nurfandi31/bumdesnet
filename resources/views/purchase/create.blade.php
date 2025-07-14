@extends('Layout.base')

@section('content')
    <style>
        .form-control-icon i,
        .form-control-icon i:before,
        .form-control-icon i:after {
            box-sizing: border-box;
            font-size: 16px;
        }
    </style>

    <div class="card">
        <div class="card-body">
            <form action="/purchases" method="post">
                @csrf


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggal_pembelian">Tanggal Pembelian</label>
                            <input type="text" id="tanggal_pembelian" class="form-control date" name="tanggal_pembelian"
                                placeholder="Tanggal Pembelian" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nomor_ref">Nomor Ref.</label>
                            <input type="text" id="nomor_ref" class="form-control" name="nomor_ref"
                                placeholder="Nomor Ref." autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <fieldset class="form-group">
                            <label for="status">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="dibayar">Dibayar</option>
                                <option value="sebagian">Sebagian</option>
                                <option value="belum_dibayar">Belum Dibayar</option>
                            </select>
                        </fieldset>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <input type="text" id="cariProduk" class="form-control form-control-lg"
                            placeholder="Cari Produk..">
                    </div>
                    <div class="col-12">
                        <table class="table" id="daftar-produk">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th width="5%" class="text-center">Jumlah</th>
                                    <th>Biaya Satuan</th>
                                    <th>Subtotal</th>
                                    <th class="text-end">
                                        <i class="fas fa-trash"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th class="text-center" id="total-qty">0</th>
                                    <th class="text-end" id="total-harga-beli">0</th>
                                    <th class="text-end" id="total-subtotal">0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <input type="hidden" name="total_qty" id="total_qty">
                        <input type="hidden" name="total_harga_beli" id="total_harga_beli">
                        <input type="hidden" name="total_subtotal" id="total_subtotal">

                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control" placeholder="Catatan" id="catatan" name="catatan" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <fieldset class="form-group">
                            <label for="sumber_dana">Sumber Dana</label>
                            <select class="form-select" id="sumber_dana" name="sumber_dana">
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->kode_akun }}. {{ $account->nama_akun }}
                                    </option>
                                @endforeach
                            </select>
                        </fieldset>

                        <div class="form-group">
                            <label for="jumlah_bayar">Jumlah Bayar</label>
                            <input type="text" id="jumlah_bayar" class="form-control text-end input-number"
                                name="jumlah_bayar" autocomplete="off" readonly="true" value="0">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var daftarProduk = [];
        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        });

        $('.date').datetimepicker({
            timepicker: false,
            format: 'd/m/Y'
        });

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

                $.get('/purchases/search-product', {
                    query: query
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
                    var harga_beli = formatter.format(data.item.harga_beli);
                    return `<a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${data.item.name}</h5>
                                    <small>${data.item.category_name}</small>
                                </div>
                                <p class="mb-1">${data.item.deskripsi}</p>
                                <small>Harga: Rp. ${harga_beli}</small>
                            </a>`;
                }
            },
            items: 10
        }).bind('typeahead:selected', function(event, selectedItem) {
            checkProductNameInList(selectedItem.item);
        });

        function checkProductNameInList(product) {
            if (daftarProduk.some(item => item.name === product.name)) {
                addQuantityProduct(product);
            } else {
                addProduct(product);
            }
        }

        function addProduct(product) {
            var table = $('#daftar-produk');
            var tbody = table.find('tbody');

            var newProduct = {
                id: product.id,
                variation_id: product.variation_id,
                name: product.name,
                harga_beli: product.harga_beli,
                jumlah: 1,
                subtotal: product.harga_beli
            }

            daftarProduk.push(newProduct);
            tbody.append(`
                <tr>
                    <td>${newProduct.name}</td>
                    <td>
                      <input type="number" name="jumlah[]" class="form-control quantity form-control-sm text-center" value="${newProduct.jumlah}" min="1">
                    </td>
                    <td>
                      <input type="text" name="harga_beli[]" class="form-control harga-beli form-control-sm text-end input-number" value="${formatter.format(newProduct.harga_beli)}">
                    </td>
                    <td class="text-end subtotal">${formatter.format(newProduct.subtotal)}</td>
                    <td class="text-end">
                        <input type="hidden" name="product_id[]" value="${newProduct.id}">
                        <input type="hidden" name="variation_id[]" value="${newProduct.variation_id}">
                        <input type="hidden" class="input-subtotal" name="subtotal[]" value="${newProduct.subtotal}">
                        <button class="btn btn-danger btn-sm btn-delete-product" type="button">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

            $('.input-number').maskMoney({
                allowNegative: true,
                allowZero: true,
                precision: 0
            })

            calculateTotal();
        }

        function addQuantityProduct(product) {
            const index = daftarProduk.findIndex(item => item.name === product.name);
            daftarProduk[index].jumlah += 1;
            daftarProduk[index].subtotal = daftarProduk[index].harga_beli * daftarProduk[index].jumlah;

            updateTableProduct(daftarProduk[index]);
        }

        function updateTableProduct(product) {
            const index = daftarProduk.findIndex(item => item.name === product.name);
            const row = $('#daftar-produk tbody tr').eq(index);

            row.find('.quantity').val(product.jumlah);
            row.find('.harga-beli').val(formatter.format(product.harga_beli));
            row.find('.subtotal').html(formatter.format(product.subtotal));
            row.find('.input-subtotal').val(product.subtotal);

            calculateTotal();
        }

        function calculateTotal() {
            var total_qty = 0;
            var total_harga_beli = 0;
            var total_subtotal = 0;

            daftarProduk.map(function(item) {
                total_qty += item.jumlah;
                total_harga_beli += item.harga_beli;
                total_subtotal += item.subtotal;
            });

            $('#total-qty').html(total_qty);
            $('#total-harga-beli').html(formatter.format(total_harga_beli));
            $('#total-subtotal').html(formatter.format(total_subtotal));

            $('#total_qty').val(total_qty);
            $('#total_harga_beli').val(total_harga_beli);
            $('#total_subtotal').val(total_subtotal);

            jumlahBayar()
        }

        function jumlahBayar() {
            var status = $('#status').val()
            if (status == 'dibayar' || status == 'belum_dibayar') {
                $('#jumlah_bayar').attr('readonly', true);

                var jumlah_bayar = 0;
                if (status == 'dibayar') {
                    jumlah_bayar = $('#total_subtotal').val();
                }

                $('#jumlah_bayar').val(formatter.format(jumlah_bayar))
            } else {
                $('#jumlah_bayar').attr('readonly', false);
            }
        }

        $(document).on('change', '#status', function(e) {
            jumlahBayar()
        })

        $(document).on('change', '.quantity', function(e) {
            var index = parseInt($(this).closest('tr').index());

            daftarProduk[index].jumlah = parseInt($(this).val());
            daftarProduk[index].subtotal = daftarProduk[index].harga_beli * daftarProduk[index].jumlah;

            updateTableProduct(daftarProduk[index]);
        });

        $(document).on('change', '.harga-beli', function(e) {
            var index = parseInt($(this).closest('tr').index());

            daftarProduk[index].harga_beli = parseInt($(this).val().split(',').join(''));
            daftarProduk[index].subtotal = daftarProduk[index].harga_beli * daftarProduk[index].jumlah;

            updateTableProduct(daftarProduk[index]);
        });

        $(document).on('click', '.btn-delete-product', function(e) {
            var index = parseInt($(this).closest('tr').index());

            daftarProduk.splice(index, 1);
            $(this).closest('tr').remove();

            calculateTotal();
        });
    </script>
@endsection

@extends('Layout.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="/pairings" method="post">
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
                            <label for="tanggal_pemasangan">Tanggal Pemasangan</label>
                            <input type="text" id="tanggal_pemasangan" class="form-control date"
                                name="tanggal_pemasangan" placeholder="Tanggal Pemasangan" autocomplete="off"
                                value="{{ date('d/m/Y') }}">
                        </div>
                    </div>
                </div>

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
                                    <th>Harga Satuan</th>
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
                                    <th class="text-end" id="total-harga-jual">0</th>
                                    <th class="text-end" id="total-subtotal">0</th>
                                    <th>
                                        <input type="hidden" name="total_qty" id="total_qty">
                                        <input type="hidden" name="total_harga_jual" id="total_harga_jual">
                                        <input type="hidden" name="total_subtotal" id="total_subtotal">
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
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

                $.get('/pairings/search-product', {
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
                harga_jual: product.harga_jual,
                jumlah: 1,
                subtotal: product.harga_jual,
                stok: product.stok
            }

            daftarProduk.push(newProduct);
            tbody.append(`
                <tr>
                    <td>${newProduct.name}</td>
                    <td>
                      <input type="number" name="jumlah[]" class="form-control quantity form-control-sm text-center" value="${newProduct.jumlah}" min="1" max="${newProduct.stok}">
                    </td>
                    <td>
                      <input type="text" name="harga_jual[]" class="form-control harga-jual form-control-sm text-end input-number" value="${formatter.format(newProduct.harga_jual)}">
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

            if (daftarProduk[index].stok < daftarProduk[index].jumlah + 1) {
                Swal.fire('Error', 'Stok tidak mencukupi', 'error')

                $('table tbody tr').eq(index).find('.quantity').val(daftarProduk[index].jumlah);
                return;
            }

            daftarProduk[index].jumlah += 1;
            daftarProduk[index].subtotal = daftarProduk[index].harga_jual * daftarProduk[index].jumlah;

            updateTableProduct(daftarProduk[index]);
        }

        function updateTableProduct(product) {
            const index = daftarProduk.findIndex(item => item.name === product.name);
            const row = $('#daftar-produk tbody tr').eq(index);

            row.find('.quantity').val(product.jumlah);
            row.find('.harga-jual').val(formatter.format(product.harga_jual));
            row.find('.subtotal').html(formatter.format(product.subtotal));
            row.find('.input-subtotal').val(product.subtotal);

            calculateTotal();
        }

        function calculateTotal() {
            var total_qty = 0;
            var total_harga_jual = 0;
            var total_subtotal = 0;

            daftarProduk.map(function(item) {
                total_qty += item.jumlah;
                total_harga_jual += item.harga_jual;
                total_subtotal += item.subtotal;
            });

            $('#total-qty').html(total_qty);
            $('#total-harga-jual').html(formatter.format(total_harga_jual));
            $('#total-subtotal').html(formatter.format(total_subtotal));

            $('#total_qty').val(total_qty);
            $('#total_harga_jual').val(total_harga_jual);
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

            if (daftarProduk[index].stok < daftarProduk[index].jumlah + parseInt($(this).val())) {
                Swal.fire('Error', 'Stok tidak mencukupi', 'error')

                $(this).val(daftarProduk[index].jumlah);
                return;
            }

            daftarProduk[index].jumlah = parseInt($(this).val());
            daftarProduk[index].subtotal = daftarProduk[index].harga_jual * daftarProduk[index].jumlah;

            updateTableProduct(daftarProduk[index]);
        });

        $(document).on('change', '.harga-jual', function(e) {
            var index = parseInt($(this).closest('tr').index());

            daftarProduk[index].harga_jual = parseInt($(this).val().split(',').join(''));
            daftarProduk[index].subtotal = daftarProduk[index].harga_jual * daftarProduk[index].jumlah;

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

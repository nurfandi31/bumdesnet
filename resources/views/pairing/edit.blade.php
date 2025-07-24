@extends('Layout.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="/pairings/{{ $pairing->id }}" method="post" id="formPairing">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="position-relative mb-3">
                            <label for="edit-instalasi">Instalasi</label>
                            <input type="hidden" id="instalasi" name="instalasi" value="{{ $pairing->id }}">
                            <input type="text" id="edit-instalasi" class="form-control" name="edit-instalasi" readonly
                                value="{{ $pairing->kode_instalasi }}. {{ $pairing->customer->nama }} [{{ $pairing->customer->nik }}]">
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
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-end">
                                        <i class="fas fa-trash"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_qty = 0;
                                    $total_harga_jual = 0;
                                    $total_subtotal = 0;
                                    $products = [];
                                @endphp
                                @foreach ($pairing->pairings as $pair)
                                    @php
                                        $products[] = [
                                            'id' => $pair->product_id,
                                            'variation_id' => $pair->product_variation_id,
                                            'name' =>
                                                $pair->product->name .
                                                ($pair->productVariation ? ' - ' . $pair->productVariation->name : ''),
                                            'harga_jual' => $pair->harga,
                                            'jumlah' => $pair->jumlah,
                                            'subtotal' => $pair->total,
                                            'stok' => $pair->productVariation
                                                ? $pair->productVariation->stok
                                                : $pair->product->stok,
                                        ];

                                        $total_qty += $pair->jumlah;
                                        $total_harga_jual += $pair->harga;
                                        $total_subtotal += $pair->total;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $pair->product->name }}
                                            {{ $pair->productVariation ? ' - ' . $pair->productVariation->name : '' }}
                                        </td>
                                        <td>
                                            <input type="number" name="jumlah[]"
                                                class="form-control quantity form-control-sm text-center"
                                                value="{{ $pair->jumlah }}" min="1" max="{{ $pair->product->stok }}">
                                        </td>
                                        <td class="text-end harga-jual">{{ number_format($pair->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end subtotal">{{ number_format($pair->total, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            <input type="hidden" name="product_id[]" value="{{ $pair->product_id }}">
                                            <input type="hidden" name="variation_id[]"
                                                value="{{ $pair->product_variation_id }}">
                                            <input type="hidden" class="input-harga-jual" name="harga_jual[]"
                                                value="{{ $pair->harga }}">
                                            <input type="hidden" class="input-subtotal" name="subtotal[]"
                                                value="{{ $pair->total }}">
                                            <button class="btn btn-danger btn-sm btn-delete-product" type="button">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th class="text-center" id="total-qty">
                                        {{ $total_qty }}
                                    </th>
                                    <th class="text-end" id="total-harga-jual">
                                        {{ number_format($total_harga_jual, 0, ',', '.') }}
                                    </th>
                                    <th class="text-end" id="total-subtotal">
                                        {{ number_format($total_subtotal, 0, ',', '.') }}
                                    </th>
                                    <th>
                                        <input type="hidden" name="total_qty" id="total_qty" value="{{ $total_qty }}">
                                        <input type="hidden" name="total_harga_jual" id="total_harga_jual"
                                            value="{{ $total_harga_jual }}">
                                        <input type="hidden" name="total_subtotal" id="total_subtotal"
                                            value="{{ $total_subtotal }}">
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" id="simpanPairing" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var daftarProduk = @json($products);
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
            var productName = product.name + (product.variation ? ' (' + product.variation.name + ')' : '');
            if (daftarProduk.some(item => item.name === productName)) {
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
                name: product.name + (product.variation ? ' (' + product.variation.name + ')' : ''),
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
                    <td class="text-end harga-jual">${formatter.format(newProduct.harga_jual)}</td>
                    <td class="text-end subtotal">${formatter.format(newProduct.subtotal)}</td>
                    <td class="text-end">
                        <input type="hidden" name="product_id[]" value="${newProduct.id}">
                        <input type="hidden" name="variation_id[]" value="${newProduct.variation_id}">
                        <input type="hidden" class="input-harga-jual" name="harga_jual[]" value="${newProduct.harga_jual}">
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
            var productName = product.name + (product.variation ? ' (' + product.variation.name + ')' : '');
            const index = daftarProduk.findIndex(item => item.name === productName);

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
            var productName = product.name + (product.variation ? ' (' + product.variation.name + ')' : '');
            const index = daftarProduk.findIndex(item => item.name === productName);
            const row = $('#daftar-produk tbody tr').eq(index);

            row.find('.quantity').val(product.jumlah);
            row.find('.harga-jual').html(formatter.format(product.harga_jual));
            row.find('.input-harga-jual').val(product.harga_jual);
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

            if (daftarProduk[index].stok < parseInt($(this).val())) {
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

        $(document).on('click', '#simpanPairing', function(e) {
            e.preventDefault();

            if (daftarProduk.length === 0) {
                Swal.fire('Error', 'Daftar produk tidak boleh kosong', 'error');
                return;
            }

            $('form#formPairing').submit();
        });
    </script>
@endsection

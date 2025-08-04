@extends('Layout.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="/products" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="position-relative mb-3">
                                    <label for="kategori">Kategori</label>
                                    <select class="choices form-control" name="kategori" id="kategori">
                                        <option value="">---</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="position-relative mb-3">
                                    <label for="satuan">Satuan</label>
                                    <select class="choices form-control" name="satuan" id="satuan">
                                        <option value="">---</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input type="text" id="nama_produk" class="form-control" name="nama_produk"
                                        placeholder="Nama Produk" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <label for="gambar">Gambar</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="gambar" name="gambar">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="harga_beli">Harga</label>
                                    <input type="text" id="harga_beli" class="form-control input-number"
                                        name="harga_beli" placeholder="Harga" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group d-none">
                                    <label for="harga_jual">Harga Jual</label>
                                    <input type="text" id="harga_jual" class="form-control input-number"
                                        name="harga_jual" placeholder="Harga Jual" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-column">
                        <div class="form-group flex-grow-1 d-flex flex-column h-100">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control flex-grow-1"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table" id="daftar-varian">
                            <thead>
                                <tr>
                                    <th>Nama Varian</th>
                                    <th>Harga</th>
                                    {{-- <th>Harga Jual</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" id="varian1" class="form-control" name="nama_varian[]"
                                            placeholder="Varian" autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" id="harga_beli1" class="form-control input-number"
                                            name="harga_beli_varian[]" placeholder="Harga" autocomplete="off">
                                    </td>
                                    {{-- <td>
                                        <input type="text" id="harga_jual1" class="form-control input-number"
                                            name="harga_jual_varian[]" placeholder="Harga Jual" autocomplete="off">
                                    </td> --}}
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="TambahVarian" class="btn btn-warning">Tambah Varian</button>
                            <button type="submit" id="SimpanProduk" class="btn ms-1 btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '#TambahVarian', function(e) {
            e.preventDefault()

            var table = $('#daftar-varian')
            var row = table.find('tbody tr:last').clone()
            row.find('input').val('')
            table.find('tbody').append(row)

            $('.input-number').maskMoney({
                allowNegative: true,
                allowZero: true,
                precision: 0
            })
        })
    </script>
@endsection

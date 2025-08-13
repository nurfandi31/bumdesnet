@include('pelaporan.layouts.style')
<title>{{ $title }}</title>

<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>DAFTAR PERSEDIAAN</b>
            </div>
            <div style="font-size: 16px;">
                <b>{{ strtoupper($sub_judul) }}</b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="3"></td>
    </tr>
</table>

<table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
    <thead>
        <tr style="background: rgb(235, 234, 234);">
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr class="{{ $loop->iteration % 2 == 1 ? 'row-white' : 'row-black' }}">
                <td>{{ $product->name }}</td>
                <td>{{ $product->stok }}</td>
                <td>{{ $product->unit->name }}</td>
                <td>{{ number_format($product->harga_jual) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

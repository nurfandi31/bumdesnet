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
            <th align="center" width="5%">No</th>
            <th align="center" width="55%">Nama Barang</th>
            <th align="center" width="10%">Stok</th>
            <th align="center" width="10%">Satuan</th>
            <th align="center" width="20%">Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr class="{{ $loop->iteration % 2 == 1 ? 'row-white' : 'row-black' }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->name }}</td>
                <td align="center">{{ $product->stok }}</td>
                <td align="center">{{ $product->unit->name }}</td>
                <td align="right">
                    Rp. {{ number_format($product->harga_jual) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

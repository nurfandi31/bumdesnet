@php
    use App\Utils\Tanggal;
@endphp

@include('pelaporan.layouts.style')
<title>{{ $title }} {{ $sub_judul }}</title>

<table>
    <tr>
        <td colspan="7" align="center">
            <div style="font-size: 18px;">
                <b>JURNAL TRANSAKSI</b>
            </div>
            <div style="font-size: 16px;">
                <b>{{ strtoupper($sub_judul) }}</b>
            </div>
        </td>
    </tr>
</table>

<table border="0" width="100%">
    <thead>
        <tr>
            <th align="center" width="4%">No</th>
            <th align="center" width="10%">Tanggal</th>
            <th align="center" width="8%">Ref ID.</th>
            <th align="center" width="10%">Kd. Rek</th>
            <th align="center" width="33%">Keterangan</th>
            <th align="center" width="15%">Debit</th>
            <th align="center" width="15%">Kredit</th>
            <th align="center" width="5%">Ins</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($transactions as $transaction)
            @php
                $rowClass = $loop->iteration % 2 == 0 ? 'row-black' : 'row-white';
            @endphp
            <tr class="{{ $rowClass }}">
                <td rowspan="2" align="center">{{ $loop->iteration }}</td> <!-- Cetak nomor -->
                <td rowspan="2" align="center">{{ Tanggal::tglIndo($transaction->tgl_transaksi) }}</td>
                <td rowspan="2" align="left">{{ $transaction->id }}</td>
                <td align="center">{{ $transaction->acc_debit->kode_akun }}</td>
                <td align="left">{{ $transaction->acc_debit->nama_akun }}</td>
                <td align="right">{{ number_format($transaction->total, 2, ',', '.') }}</td>
                <td align="right">0</td>
                <td rowspan="2" align="center">&nbsp;</td>
            </tr>
            <tr class="{{ $rowClass }}">
                <td align="center">{{ $transaction->acc_kredit->kode_akun }}</td>
                <td align="left">{{ $transaction->acc_kredit->nama_akun }}</td>
                <td align="right">0</td>
                <td align="right">{{ number_format($transaction->total, 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

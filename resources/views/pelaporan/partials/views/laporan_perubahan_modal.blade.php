@include('pelaporan.layouts.style')
<title>{{ $title }} {{ $sub_judul }}</title>
@php
    $nomor = 1;
@endphp

<table>
    <tr>
        <td colspan="3" align="center">
            <div style="font-size: 18px;">
                <b>LAPORAN PERUBAHAN MODAL</b>
            </div>
            <div style="font-size: 16px;">
                <b>{{ strtoupper($sub_judul) }}</b>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="8"></td>
    </tr>
</table>
<table class="with-border"style="font-size: 12px;">
    <tr>
        <th class="t l b" width="5%">No</th>
        <th class="t l b" width="55%">Rekening Modal</th>
        <th class="t l b r" width="20%">&nbsp;</th>
    </tr>
    @php
        $total_saldo = 0;
    @endphp
    @foreach ($accounts as $rek)
        @php
            $saldo_debit = 0;
            $saldo_kredit = 0;
            foreach ($rek->amount as $amount) {
                $saldo_debit += $amount->debit;
                $saldo_kredit += $amount->kredit;
            }

            $saldo = $saldo_kredit - $saldo_debit;
            $total_saldo += $saldo;
        @endphp
        <tr>
            <td class="t l b" align="center">{{ $nomor++ }}</td>
            <td class="t l b">{{ $rek->nama_akun }}</td>
            <td class="t l b r" align="right">
                {{ $saldo < 0 ? '(' . number_format(abs($saldo), 2) . ')' : number_format($saldo, 2) }}
            </td>
        </tr>
    @endforeach
    <tr>
        <td class="t l b b" colspan="2" height="15">Total Saldo</td>
        <td class="t l b b r" align="right">
            {{ $total_saldo < 0 ? '(' . number_format(abs($total_saldo), 2) . ')' : number_format($total_saldo, 2) }}
        </td>
    </tr>
</table>

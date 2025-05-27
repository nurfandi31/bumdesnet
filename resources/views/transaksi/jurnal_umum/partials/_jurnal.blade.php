@php
    use App\Utils\Tanggal;
    $total_saldo = 0;

    if ($rek->jenis_mutasi == 'debet') {
        $saldo_awal_tahun = $saldo['debit'] - $saldo['kredit'];
        $saldo_awal_bulan = $d_bulan_lalu - $k_bulan_lalu;
        $total_saldo = $saldo_awal_tahun + $saldo_awal_bulan;
    } else {
        $saldo_awal_tahun = $saldo['kredit'] - $saldo['debit'];
        $saldo_awal_bulan = $k_bulan_lalu - $d_bulan_lalu;
        $total_saldo = $saldo_awal_tahun + $saldo_awal_bulan;
    }

    $total_debit = 0;
    $total_kredit = 0;
@endphp

<form action="/transactions/dokumen/cetak" method="post" id="FormCetakDokumenTransaksi" target="_blank">
    @csrf

    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="table table-striped midle">
        <thead style="background-color: #6c757d;">
            <tr>
                <th width="80" style="color: #fff; text-align: center;">
                    <div class="form-check" style="display: inline-block; margin-bottom: 0;">
                        <input class="form-check-input" type="checkbox" value="true" id="checked" name="checked">
                    </div>
                </th>
                <th width="5">No</th>
                <th height="40" width="100" style="color: #fff; text-align: center;">Tanggal</th>
                <th width="100" style="color: #fff; text-align: center;">Kode Akun</th>
                <th style="color: #fff; text-align: center;">Keterangan</th>
                <th width="70" style="color: #fff; text-align: center;">ID Trx.</th>
                <th width="140" style="color: #fff; text-align: center;">Debit</th>
                <th width="140" style="color: #fff; text-align: center;">Kredit</th>
                <th width="150" style="color: #fff; text-align: center;">Saldo</th>
            </tr>
        </thead>


        <tbody>
            <tr>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center">{{ Tanggal::tglIndo($tahun . '-01-01') }}</td>
                <td align="center"></td>
                <td>Komulatif Transaksi Awal Tahun {{ $tahun }}</td>
                <td>&nbsp;</td>
                <td align="right">{{ number_format($saldo['debit'], 2) }}</td>
                <td align="right">{{ number_format($saldo['kredit'], 2) }}</td>
                <td align="right">{{ number_format($saldo_awal_tahun, 2) }}</td>
            </tr>
            <tr>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center">{{ Tanggal::tglIndo($tahun . '-' . $bulan . '-01') }}</td>
                <td align="center"></td>
                <td>Komulatif Transaksi s/d Bulan Lalu</td>
                <td>&nbsp;</td>
                <td align="right">{{ number_format($d_bulan_lalu, 2) }}</td>
                <td align="right">{{ number_format($k_bulan_lalu, 2) }}</td>
                <td align="right">{{ number_format($total_saldo, 2) }}</td>
            </tr>

            @foreach ($transaksi as $trx)
                @php
                    if ($trx->rekening_debit == $rek->id) {
                        $ref = $trx->rek_debit->kode_akun;
                        $debit = $trx->total;
                        $kredit = 0;
                    } else {
                        $ref = $trx->kode_akun;
                        $kredit = $trx->total;
                        $debit = 0;
                    }

                    if ($rek->jenis_mutasi == 'debet') {
                        $_saldo = $debit - $kredit;
                    } else {
                        $_saldo = $kredit - $debit;
                    }

                    $total_saldo += $_saldo;
                    $total_debit += $debit;
                    $total_kredit += $kredit;

                    $kuitansi = false;
                    $files = 'bm';
                    if (
                        $keuangan->startWith($trx->rekening_debit, '1.1.01') &&
                        !$keuangan->startWith($trx->rekening_kredit, '1.1.01')
                    ) {
                        $files = 'bkm';
                        $kuitansi = true;
                    }
                    if (
                        !$keuangan->startWith($trx->rekening_debit, '1.1.01') &&
                        $keuangan->startWith($trx->rekening_kredit, '1.1.01')
                    ) {
                        $files = 'bkk';
                        $kuitansi = true;
                    }
                    if (
                        $keuangan->startWith($trx->rekening_debit, '1.1.01') &&
                        $keuangan->startWith($trx->rekening_kredit, '1.1.01')
                    ) {
                        $files = 'bm';
                        $kuitansi = false;
                    }
                    if (
                        $keuangan->startWith($trx->rekening_debit, '1.1.02') &&
                        !(
                            $keuangan->startWith($trx->rekening_kredit, '1.1.01') ||
                            $keuangan->startWith($trx->rekening_kredit, '1.1.02')
                        )
                    ) {
                        $files = 'bkm';
                        $kuitansi = true;
                    }
                    if (
                        $keuangan->startWith($trx->rekening_debit, '1.1.02') &&
                        $keuangan->startWith($trx->rekening_kredit, '1.1.02')
                    ) {
                        $files = 'bm';
                        $kuitansi = false;
                    }
                    if (
                        $keuangan->startWith($trx->rekening_debit, '5.') &&
                        !(
                            $keuangan->startWith($trx->rekening_kredit, '1.1.01') ||
                            $keuangan->startWith($trx->rekening_kredit, '1.1.02')
                        )
                    ) {
                        $files = 'bm';
                        $kuitansi = false;
                    }
                    if (
                        !(
                            $keuangan->startWith($trx->rekening_debit, '1.1.01') ||
                            $keuangan->startWith($trx->rekening_debit, '1.1.02')
                        ) &&
                        $keuangan->startWith($trx->rekening_kredit, '1.1.02')
                    ) {
                        $files = 'bm';
                        $kuitansi = false;
                    }
                    if (
                        !(
                            $keuangan->startWith($trx->rekening_debit, '1.1.01') ||
                            $keuangan->startWith($trx->rekening_debit, '1.1.02')
                        ) &&
                        $keuangan->startWith($trx->rekening_kredit, '4.')
                    ) {
                        $files = 'bm';
                        $kuitansi = false;
                    }
                @endphp

                <tr>
                    <td align="center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $trx->id }}"
                                id="{{ $trx->id }}" name="cetak[]" data-input="checked">
                        </div>
                    </td>
                    <td align="center">{{ $loop->iteration }}.</td>
                    <td align="center">{{ Tanggal::tglIndo($trx->tgl_transaksi) }}</td>
                    <td align="center">{{ $ref }}</td>
                    <td>{{ $trx->keterangan }}</td>
                    <td align="center">{{ $trx->id }}</td>
                    <td align="right">{{ number_format($debit, 2) }}</td>
                    <td align="right">{{ number_format($kredit, 2) }}</td>
                    <td align="right">{{ number_format($total_saldo, 2) }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="6">
                    <b>Total Transaksi {{ ucwords($sub_judul) }}</b>
                </td>
                <td align="right">
                    <b>{{ number_format($total_debit, 2) }}</b>
                </td>
                <td align="right">
                    <b>{{ number_format($total_kredit, 2) }}</b>
                </td>
                <td colspan="2" rowspan="3" align="center" style="vertical-align: middle">
                    <b>{{ number_format($total_saldo, 2) }}</b>
                </td>
            </tr>

            <tr>
                <td colspan="6">
                    <b>Total Transaksi sampai dengan {{ ucwords($sub_judul) }}</b>
                </td>
                <td align="right">
                    <b>{{ number_format($d_bulan_lalu + $total_debit, 2) }}</b>
                </td>
                <td align="right">
                    <b>{{ number_format($k_bulan_lalu + $total_kredit, 2) }}</b>
                </td>
            </tr>

            <tr>
                <td colspan="6">
                    <b>Total Transaksi Komulatif sampai dengan Tahun {{ $tahun }}</b>
                </td>
                <td align="right">
                    <b>{{ number_format($saldo['debit'] + $d_bulan_lalu + $total_debit, 2) }}</b>
                </td>
                <td align="right">
                    <b>{{ number_format($saldo['kredit'] + $k_bulan_lalu + $total_kredit, 2) }}</b>
                </td>
            </tr>
        </tbody>

    </table>
</form>

<script>
    $(document).on('click', '#checked', function() {
        if ($(this)[0].checked == true) {
            $('[data-input=checked]').prop('checked', true)
        } else {
            $('[data-input=checked]').prop('checked', false)
        }
    })
</script>

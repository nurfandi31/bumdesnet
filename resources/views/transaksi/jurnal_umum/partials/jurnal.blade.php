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

<table border="0" width="100%" cellspacing="0" cellpadding="0" class="table table-striped midle">
    <thead class="bg-secondary">
        <tr>
            <th height="40" class="text-center"style="color: #fff;" width="40">No</th>
            <th class="text-center" width="100"style="color: #fff;">Tanggal</th>
            <th class="text-center" width="100"style="color: #fff;">Kode Akun</th>
            <th class="text-center"style="color: #fff;">Keterangan</th>
            <th class="text-center" width="70"style="color: #fff;">ID Trx</th>
            <th class="text-center" width="140"style="color: #fff;">Debit</th>
            <th class="text-center" width="140"style="color: #fff;">Kredit</th>
            <th class="text-center" width="150"style="color: #fff;">Saldo</th>
            <th class="text-center" width="170"style="color: #fff;">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td align="center"></td>
            <td align="center">{{ Tanggal::tglIndo($tahun . '-01-01') }}</td>
            <td align="center"></td>
            <td>Komulatif Transaksi Awal Tahun {{ $tahun }}</td>
            <td>&nbsp;</td>
            <td align="right">{{ number_format($saldo['debit'], 2) }}</td>
            <td align="right">{{ number_format($saldo['kredit'], 2) }}</td>
            <td align="right">{{ number_format($saldo_awal_tahun, 2) }}</td>
            <td align="center"></td>
        </tr>
        <tr>
            <td align="center"></td>
            <td align="center">{{ Tanggal::tglIndo($tahun . '-' . $bulan . '-01') }}</td>
            <td align="center"></td>
            <td>Komulatif Transaksi s/d Bulan Lalu</td>
            <td>&nbsp;</td>
            <td align="right">{{ number_format($d_bulan_lalu, 2) }}</td>
            <td align="right">{{ number_format($k_bulan_lalu, 2) }}</td>
            <td align="right">{{ number_format($total_saldo, 2) }}</td>
            <td align="center"></td>
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
                    $keuangan->startWith($trx->rek_debit->kode_akun, '1.1.01') &&
                    !$keuangan->startWith($trx->rek_kredit->kode_akun, '1.1.01')
                ) {
                    $files = 'bkm';
                    $kuitansi = true;
                }
                if (
                    !$keuangan->startWith($trx->rek_debit->kode_akun, '1.1.01') &&
                    $keuangan->startWith($trx->rek_kredit->kode_akun, '1.1.01')
                ) {
                    $files = 'bkk';
                    $kuitansi = true;
                }
                if (
                    $keuangan->startWith($trx->rek_debit->kode_akun, '1.1.01') &&
                    $keuangan->startWith($trx->rek_kredit->kode_akun, '1.1.01')
                ) {
                    $files = 'bm';
                    $kuitansi = false;
                }
                if (
                    $keuangan->startWith($trx->rek_debit->kode_akun, '1.1.02') &&
                    !(
                        $keuangan->startWith($trx->rek_debit->kode_akun, '1.1.01') ||
                        $keuangan->startWith($trx->rek_kredit->kode_akun, '1.1.02')
                    )
                ) {
                    $files = 'bkm';
                    $kuitansi = true;
                }

            @endphp

            <tr>
                <td align="center">{{ $loop->iteration }}.</td>
                <td align="center">{{ Tanggal::tglIndo($trx->tgl_transaksi) }}</td>
                <td align="center">{{ $ref }}</td>
                <td>{{ $trx->keterangan }}</td>
                <td align="center">{{ $trx->id }}</td>
                <td align="right">{{ number_format($debit, 2) }}</td>
                <td align="right">{{ number_format($kredit, 2) }}</td>
                <td align="right">{{ number_format($total_saldo, 2) }}</td>
                <td align="center">
                    <div class="dropdown dropleft">
                        <div class="btn-group mb-1">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle me-1" type="button"
                                    id="{{ $trx->id }}" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="{{ $trx->id }}">
                                    <a class="dropdown-item" target="_blank"
                                        href="/transactions/dokumen/kuitansi/{{ $trx->id }}">
                                        Kuitansi
                                    </a>
                                    <a class="dropdown-item" target="_blank"
                                        href="/transactions/dokumen/kuitansi_thermal/{{ $trx->id }}">
                                        Kuitansi Thermal
                                    </a>
                                    <a class="dropdown-item btn-link" target="_blank"
                                        href="/transactions/dokumen/{{ $files }}/{{ $trx->id }}">
                                        @if ($files == 'bkm')
                                            Bukti Kas Masuk
                                        @elseif ($files == 'bkk')
                                            Bukti Kas Keluar
                                        @else
                                            Bukti Memorial
                                        @endif
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item btn-reversal" href="#" data-id="{{ $trx->id }}">
                                        Reversal
                                    </a>
                                </div>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $trx->id }}">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="5">
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
            <td colspan="5">
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
            <td colspan="5">
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

<script>
    $(document).ready(function() {
        initializeBootstrapTooltip()
    })
</script>

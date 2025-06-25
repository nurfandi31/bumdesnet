@php
    use App\Utils\Tanggal;
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        * {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background-color: #eee;
        }

        .no-border td {
            border: none;
            padding: 2px 4px;
        }
    </style>
</head>
@php
    // Kelompokkan usages berdasarkan dusun
    $usagesByDusun = $usages->groupBy(function ($usage) {
        return $usage->installation->village->dusun ?? '-';
    });
@endphp

@foreach ($usagesByDusun as $dusun => $usagesGroup)

    <body>

        <!-- HEADER - letakkan di luar table -->
        <div style="text-align: center; max-width: 100%;">
            <div style="font-size: 14px; margin-bottom: 2px;"><b>DAFTAR TAGIHAN PEMAKAIAN WIFI</b></div>
            <div style="font-size: 18px; margin-bottom: 2px;"><b>"{{ strtoupper($bisnis->nama) }}" BUMDes BANGUN
                    KENCANA</b>
            </div>
            <div style="font-size: 14px; margin-bottom: 5px;">KALURAHAN MULO KAPANEWON WONOSARI</div>
        </div>
        <div style="border-bottom: 2px solid #000; margin: 4px 0;"></div>

        @php
            $lastUsageInGroup = $usagesGroup->sortByDesc('tgl_akhir')->first();
            $tglAkhirFormatted = $lastUsageInGroup
                ? \Carbon\Carbon::parse($lastUsageInGroup->tgl_akhir)->subDay()->translatedFormat('F d Y')
                : '-';
        @endphp

        <table style="width: 100%; margin-top: 10px; font-size: 12px; border-collapse: collapse; border: none;">
            <table style="width: 100%; margin-top: 10px; font-size: 12px; border-collapse: collapse;">
                <tr>
                    <td style="width: 15%; border: none; padding: 2px 4px; line-height: 1.1;">Bulan Pemakaian</td>
                    <td style="width: 1%; border: none; padding: 2px 4px; line-height: 1.1;">:</td>
                    <td style="width: 40%; border: none; padding: 2px 4px; line-height: 1.1;"><b>{{ $bulan }}</b>
                    </td>

                    <td style="width: 17%; border: none; padding: 2px 4px; line-height: 1.1;">Tgl Akhir Pembayaran</td>
                    <td style="width: 1%; border: none; padding: 2px 4px; line-height: 1.1;">:</td>
                    <td style="width: 15%; border: none; padding: 2px 4px; line-height: 1.1;">
                        <b>{{ $tglAkhirFormatted }}</b>
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 2px 4px; line-height: 1.1;">Sales</td>
                    <td style="border: none; padding: 2px 4px; line-height: 1.1;">:</td>
                    <td style="border: none; padding: 2px 4px; line-height: 1.1;"><b>{{ $pemakaian_cater ?? '-' }}</b>
                    </td>

                    <td style="border: none; padding: 2px 4px; line-height: 1.1;"> Dusun</td>
                    <td style="border: none; padding: 2px 4px; line-height: 1.1;">:</td>
                    <td style="border: none; padding: 2px 4px; line-height: 1.1;"><b>{{ $dusun }}</b></td>
                </tr>
            </table>
        </table><br>
        <table>
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Nama</th>
                    <th style="text-align: center;">No. Induk</th>
                    <th style="text-align: center;">RT</th>
                    <th style="text-align: center;">Awal</th>
                    <th style="text-align: center;">Akhir</th>
                    <th style="text-align: center;">Pemakaian</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usagesGroup->sortBy([['installation.rt', 'asc'], ['tgl_akhir', 'asc']]) as $i => $usage)
                    @php
                        $dendaPemakaianLalu = 0;
                        foreach ($usage->installation->transaction as $trx_denda) {
                            if ($trx_denda->tgl_transaksi < $usage->tgl_akhir) {
                                $dendaPemakaianLalu = $trx_denda->total;
                            }
                        }

                        $abodemen = $usage->installation->abodemen ?? 0;
                        $total = $usage->nominal + $abodemen + $dendaPemakaianLalu;
                    @endphp
                    <tr>
                        <td align="center">{{ $i + 1 }}</td>
                        <td>{{ $usage->customers->nama }}</td>
                        <td class="text-center">
                            {{ $usage->installation->kode_instalasi }}
                            {{ substr($usage->installation->package->kelas, 0, 1) }}
                        </td>
                        <td align="center">{{ $usage->installation->rt ?? '00' }}</td>
                        <td align="center">{{ $usage->awal }}</td>
                        <td align="center">{{ $usage->akhir }}</td>
                        <td align="center">{{ $usage->jumlah }}</td>
                        <td align="center">{{ $usage->status }}</td>
                        <td align="right"><b>{{ number_format($total, 2, ',', '.') }}</b></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
@endforeach

</html>

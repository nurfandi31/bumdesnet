@php
    $bulanIndo = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember',
    ];
    $carbonDate = \Carbon\Carbon::parse($tgl_kondisi);
    $bulan = $bulanIndo[$carbonDate->format('F')];
    $tahun = $carbonDate->format('Y');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-size: 12px;
            margin: 20px;
            font-family: Arial, Helvetica, sans-serif;
            /* Tambahkan baris ini */
        }

        table {
            border-collapse: collapse;
            width: 90%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>

</head>
<table style="border: none; width: 100%;">
    <tr>
        <td colspan="7" align="center" style="border: none;">
            <div style="font-size: 18px;"><b>DAFTAR CETAK TAGIHAN</b></div>
            <div style="font-size: 16px;"><b> BULAN {{ strtoupper($bulan . ' ' . $tahun) }}</b></div>
        </td>
    </tr>
</table>


<body>
    <div>


        <table align="center">
            <thead>
                <tr style="background-color: #e0e0e0; color: #000;">
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama</th>
                    <th style="width: 15%;">No. Induk</th>
                    <th style="width: 15%;">Bulan Lalu</th>
                    <th style="width: 15%;">Bulan Ini</th>
                    <th style="width: 15%;">Jumlah Tagihan</th>
                    <th style="width: 10%;">Kategori</th>
                </tr>

            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($Tagihan as $ins)
                    @php
                        $bulan_lalu = 0;
                        $bulan_ini = 0;
                        $jumlah_menunggak = 0;
                        $bayar = 0;

                        foreach ($ins->usage as $usage) {
                            foreach ($usage->transaction as $trx) {
                                $bulan_tagihan = date('Y-m', strtotime($usage->tgl_akhir)) . '-01';
                                $bulan_kondisi = date('Y-m', strtotime($tgl_kondisi)) . '-01';
                                $bulan_kondisi_lalu =
                                    date('Y-m', strtotime('-1 month', strtotime($bulan_kondisi))) . '-01';

                                if ($trx->rekening_debit == $akun_piutang->id) {
                                    if ($bulan_tagihan < $bulan_kondisi_lalu) {
                                        // skip
                                    } elseif ($bulan_tagihan < $bulan_kondisi) {
                                        $bulan_lalu += $trx->total;
                                    } else {
                                        $bulan_ini += $trx->total;
                                    }
                                } else {
                                    $bayar += $trx->total;
                                }
                            }
                            $jumlah_menunggak++;
                        }

                        $tunggakan = $bulan_lalu + $bulan_ini;

                        $status = 'Lancar';
                        if ($jumlah_menunggak > 0) {
                            $status = 'Menunggak';
                        }
                        if ($jumlah_menunggak > 1) {
                            $status = 'SP';
                        }
                        if ($jumlah_menunggak > 2) {
                            $status = 'SPS';
                        }
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td style="text-align: left;">{{ $ins->customer->nama ?? '-' }}</td>
                        <td>{{ $ins->kode_instalasi }}</td>
                        <td style="text-align: right;">{{ number_format($bulan_lalu, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($bulan_ini, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($tunggakan, 2) }}</td>
                        <td>{{ $ins->status_tunggakan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

<script>
    window.onload = function() {
        window.print();
    };
</script>

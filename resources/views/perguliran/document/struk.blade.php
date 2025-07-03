@php
    use App\Utils\Tanggal;
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Tagihan Pemakaian Internet</title>
    <style>
        * {
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        body {
            font-size: 10px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .page {
            width: 100%;
            padding: 10px;
        }

        .box {
            page-break-inside: avoid;
            break-inside: avoid;
            /* Fixing height ensures all fit properly */
            min-height: 8.5cm;
            margin-bottom: 10px;
            border: 1px solid #000;
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header img {
            height: 50px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-top: 6px;
            margin-bottom: 4px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td,
        .table th {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        .no-border td {
            border: none;
            padding: 2px 4px;
            font-size: 10px;
        }

        .footer {
            font-size: 9px;
            text-align: center;
            margin-top: 4px;
        }

        .page-break {
            page-break-after: always;
        }

        .signature {
            margin-top: 8px;
        }

        .terbilang {
            font-style: italic;
        }
    </style>
</head>

<body>

    @foreach ($usage->chunk(3) as $chunk)
        <div class="page">
            @foreach ($chunk as $use)
                <div class="box">
                    <table
                        width="100%"style="border-bottom: 2px solid #686666; padding-bottom: 6px; margin-bottom: 10px;">
                        <tr>
                            <td width="20%" align="right">
                                <img src="assets/img/cetak1.png">
                            </td>
                            <td width="60%" align="center">
                                <div class="fw-bold" style="font-size: 13px;"><b>STRUK TAGIHAN INTERNET</b></div>
                                <div style="font-size: 11px;"> "{{ $bisnis->nama }}"</div>
                            </td>
                            <td width="20%" align="right">
                                No urut : {{ $use->installation->id }}
                            </td>
                        </tr>
                    </table>

                    <div class="section-title">DATA PEMAKAIAN</div>
                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <th>No Induk</th>
                            <th>Awal</th>
                            <th>Akhir</th>
                            <th>Pemakaian</th>
                        </tr>
                        <tr>
                            <td>{{ $use->customers->nama }}</td>
                            <td>{{ $use->installation->kode_instalasi }}{{ substr($use->installation->package->kelas, 0, 1) }}
                            </td>
                            <td>{{ $use->awal }}</td>
                            <td>{{ $use->akhir }}</td>
                            <td>{{ $use->jumlah }}</td>
                        </tr>
                    </table>

                    <div class="section-title">RINCIAN TAGIHAN</div>
                    <table class="no-border" width="100%">
                        <tr>
                            <td width="35%">Pemakaian Internet</td>
                            <td>: Rp {{ number_format($use->nominal, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Beban Tetap</td>
                            <td>: Rp {{ number_format($use->installation->abodemen, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Denda</td>
                            <td>: Rp 0.00</td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong>: Rp
                                    {{ number_format($use->nominal + $use->installation->abodemen, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Terbilang</td>
                            <td class="terbilang">:
                                {{ ucwords($keuangan->terbilang($use->nominal + $use->installation->abodemen)) }}
                                Rupiah</td>
                        </tr>
                    </table>

                    <div class="signature">
                        <table class="no-border" width="100%">
                            <tr>
                                <td width="50%">{{ ucwords($bisnis->desa) }},
                                    {{ Tanggal::tglLatin($use->tgl_pemakaian) }}</td>
                                <td width="50%" align="right">{{ ucwords($jabatan->nama) }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td align="right">TTD</td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer">
                        Terlambat 1 bulan → Surat Peringatan | 2 bulan → Pemutusan
                    </div>
                </div>
            @endforeach
        </div>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>

</html>

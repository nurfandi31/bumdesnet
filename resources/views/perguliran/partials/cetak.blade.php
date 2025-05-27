@php
    use App\Utils\Tanggal;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pemakaian</title>
    <style>
        body {
            font-size: 10px;
            font-family: Arial, sans-serif;
            width: 10cm;
            height: 15cm;
            margin: 0 auto;
            padding: 0;
            text-align: center;
            position: relative;
        }

        .container {
            width: 100%;
            padding: 5px;
            border: 1px solid rgb(255, 255, 255);
            box-sizing: border-box;
        }

        .header img {
            width: 30px;
            height: 30px;
        }

        .header,
        .footer {
            text-align: center;
            font-weight: bold;
        }

        .content {
            text-align: center;
            margin-top: 5px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content th,
        .content td {
            border: 1px solid #000;
            padding: 1px;
            font-size: 9px;
            text-align: center;
        }

        .border {
            border-top: 1px dashed black;
            border-bottom: 1px dashed black;
            margin: 5px 0;
            padding: 5px 0;
        }

        .footer {
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 2px;
        }

        thead tr th:first-child {
            border-top-left-radius: 10px;
            text-align: center;
        }

        thead tr th:not(:first-child) {
            text-align: left;
        }

        tbody tr td:first-child {
            text-align: center;
        }

        tbody tr td:not(:first-child) {
            text-align: left;
        }

        tbody tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        .content tbody td:nth-child(2) {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        img {
            max-height: 40px !important;
        }

        .content tbody tr {
            height: 7.5mm;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="header">
            <div style="font-size: 12px"></div>
            <div></div>
        </div><br>

        <div style="position: relative;">
            <div style="position: relative; text-align: center;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td colspan="3" style="text-align: left; border: none;">
                            <div style="font-size: 12px;">KARTU METER PENGGUNAAN AIR</div>
                            <div style="font-size: 14px;"><b>UNIT AIR {{ strtoupper($bisnis->nama) }}</b></div>
                            <div style="font-size: 11px;">(BUMDes) BANGUN KENCANA KALURAHAN
                                {{ strtoupper($bisnis->desa) }}</div>
                        </td>
                        <td style="text-align: right; border: none; white-space: nowrap;">
                            <img src="../../assets/img/cetak2.png" style="vertical-align: middle; margin-right: 2px;"
                                alt="Logo 2">
                            <img src="{{ '/storage/logo/' . $gambar }}" style="vertical-align: middle;" alt="Logo 1">
                        </td>
                    </tr>
                </table>
            </div>

            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <tr>
                    <td colspan="3" style="border: none;">&nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border: none;">
                        <div style="border-top: 2px solid rgb(88, 86, 86); margin-bottom: 3px; width: 100%;"></div>
                    </td>
                </tr>
                <tr>
                    <td rowspan="3" style="width: 60px; vertical-align: top; border: none;">
                        <div style="width: 50px;">
                            {!! $qr !!}
                        </div>
                    </td>
                    <td style="width: 30%; text-align: left; border: none;">NAMA PELANGGAN</td>
                    <td style="border: none;">: {{ $installation->customer->nama }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; border: none;">NO. INDUK</td>
                    <td style="border: none;">: {{ $installation->kode_instalasi }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; border: none;">ALAMAT</td>
                    <td style="border: none;">: {{ $installation->village->nama }}</td>
                </tr>
            </table>
        </div>
        <tr>
            <td colspan="3" style="border: none;">&nbsp;
            </td>
        </tr>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th rowspan="2"
                            style="text-align: center; vertical-align: middle; padding-top: 14px; padding-bottom: 10px;">
                            NO</th>
                        <th rowspan="2"
                            style="text-align: center; vertical-align: middle; padding-top: 10px; padding-bottom: 10px;">
                            BULAN</th>
                        <th rowspan="2" style="text-align: center; vertical-align: middle;">ANGKA METER</th>
                        <th rowspan="2" style="text-align: center; vertical-align: middle;">TTD CATER</th>
                        <th rowspan="2" style="text-align: center; vertical-align: middle;">KETERANGAN</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach (['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'] as $i => $bulan)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $bulan }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <table style="width: 100%; border-collapse: collapse; text-align: center; margin: 5px 0;">
                <tr>
                    <td colspan="5" style="border: none; font-size: 11px; padding-top: 3px; padding-bottom: 3px;">
                        <br>
                        <b>INFORMASI DAN KELUHAN HUBUNGI</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="border: none; font-size: 11px; padding-bottom: 8px;">
                        <b>Heru Endaryanto: 087838758555 / Widiyarto: 087878715088</b>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</body>

</html>

@php
    use App\Utils\Tanggal;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-size: 10px;
            font-family: Arial, sans-serif;
            width: 8cm;
            margin: 1px;
            padding: 1px;
            text-align: center;
        }

        .container {
            width: 100%;
            padding: 10px;
            border: 2px solid rgb(154, 154, 154);
        }

        .header img {
            width: 40px;
            height: 40px;
        }

        .header,
        .footer {
            text-align: center;
            font-weight: bold;
        }

        .content {
            text-align: left;
            margin-top: 5px;
        }

        .content table {
            width: 100%;
        }

        .border {
            border-top: 1px dashed black;
            border-bottom: 1px dashed black;
            margin: 5px 0;
            padding: 5px 0;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 10px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="header">
            <div style="font-size: 14px">{{ strtoupper($bisnis->nama) }}</div>
            <div>{{ 'SK Kemenkumham RI No. ' . $bisnis->nomor_bh }}</div>
            <div>{{ $bisnis->alamat }}</div>
            <div>Telp: {{ $bisnis->telpon }}</div>
        </div><br>
        <div class="border">
            STRUK PASANG BARU
        </div><br>

        <div class="content">
            <table>
                <tr>
                    <td>No Ref</td>
                    <td class="text-right">{{ $trx->Installations->id }}</td>
                </tr>
                <tr>
                    <td>Nomor</td>
                    <td class="text-right">{{ $trx->id . '/' . $jenis }}</td>
                </tr>
                <tr>
                    <td>Pelanggan</td>
                    <td class="text-right">{{ $trx->Installations->customer->nama }}</td>
                </tr>
                </tr>
                <tr>
                    <td>Tgl Bayar</td>
                    <td class="text-right">{{ Tanggal::tglLatin($trx->tgl_transaksi) }}</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td class="text-right">{{ $trx->keterangan }}</td>
                </tr>

                <tr>
                    <td>Package</td>
                    <td class="text-right">{{ $trx->Installations->package->kelas }}</td>
                </tr>
                <tr>
                    <td>Kode Instalasi</td>
                    <td class="text-right">{{ $trx->Installations->kode_instalasi }}</td>
                </tr>
            </table>

            <div class="border">
                <table>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Biaya Instalasi</td>
                        <td class="text-right">Rp
                            {{ number_format($trx->Installations->biaya_instalasi, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><b>Total Bayar</b></td>
                        <td class="text-right"><b>Rp {{ number_format($trx->total, 2, ',', '.') }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="footer">
            <div>Terima Kasih!</div>
            <div>Harap simpan struk ini sebagai bukti pembayaran</div>
            <div>{{ date('Y-m-d H:i:s') }}</div>
        </div>
    </div>
</body>

</html>

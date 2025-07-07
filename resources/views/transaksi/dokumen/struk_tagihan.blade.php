@php
    use App\Utils\Tanggal;
    $totalAbodemen = 0;
    $totalTagihan = 0;
@endphp

@foreach ($trx->transaction as $transaksi)
    @php
        $keterangan = $transaksi->keterangan;
        $total = $transaksi->total;

        if ($transaksi->rekening_kredit == $kode_abodemen->id) {
            $totalAbodemen += $total;
        }

        if ($transaksi->rekening_kredit == $kode_pemakaian->id) {
            $totalTagihan += $total;
        }
    @endphp
@endforeach
@php
    $total = $totalAbodemen + $totalTagihan;
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 10px;
            font-family: Verdana, Arial, Helvetica, sans-serif;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .container {
            width: 9cm;
            height: 540px;
            border: 1px solid rgb(255, 255, 255);
            box-sizing: border-box;
        }

        .inner-content {
            padding: 8px 10px;
            height: 100%;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .logo-area img {
            height: 45px;
            width: auto;
        }

        .invoice-text {
            text-align: right;
        }

        .invoice-text div:first-child {
            font-size: 16px;
            font-weight: bold;
        }

        .invoice-text div:last-child {
            font-size: 10px;
        }

        .content {
            margin-top: 5px;
        }

        .bold {
            font-weight: bold;
        }

        .border {
            border-top: 1px solid #000;
            margin: 5px 0;
            padding: 5px 0;
        }

        .text-right {
            text-align: right;
        }

        .section-header {
            background-color: #e0e2e4;
            color: black;
            padding: 4px 6px;
            font-size: 12px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        table {
            width: 100%;
        }

        .footer {
            text-align: center;
            margin-top: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="inner-content">
            <div class="header">
                <div class="logo-area">
                    <img src="/assets/static/images/logo/indotel01.png" alt="Logo 1">
                    <img src="/assets/static/images/logo/indotel.png" alt="Logo 2">
                </div>
                <div class="invoice-text">
                    <div>INVOICE</div>
                    <div>No. {{ $trx->id }}</div>
                </div>
            </div>
            <div>

                <div class="content"
                    style="margin-top: 1px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="max-width: 60%;">

                        <div style="font-size: 18px" class="bold">DESMANET</div>
                        <div class="bold">{{ strtoupper($bisnis->nama) }}</div>
                        <div class="content">
                            <div><strong>Powered by</strong></div>
                            <div>PT.INDO TELEMEDIA SOLUSI</div>
                        </div>
                        <div><strong>Address:
                            </strong></div>
                        <div>{{ $bisnis->alamat }}</div>
                        <div><strong>Phone:
                            </strong></div>
                        <div>{{ $bisnis->telpon }}</div>
                    </div>
                    <div style="text-align: right;">
                        <div>Invoice Date <br> {{ Tanggal::tglLatin($trx->Usages->tgl_pemakaian) }}</div>
                        <br>
                        <div>Due Date <br> {{ Tanggal::tglLatin($trx->Usages->tgl_akhir) }}</div>
                    </div>
                </div>
                <div class="border"></div>
                <div class="content" style="margin-top: 5px; display: flex; justify-content: space-between;">
                    <div style="max-width: 80%;">
                        <div style="font-size: 16px">Bill To:</div><br>
                        <div>
                            {{ $trx->usages->kode_instalasi }}<br>
                            <strong style="font-size: 16px">{{ $trx->Installations->customer->nama }}</strong>
                        </div>
                        <div>
                            Address:<br>
                            {{ $trx->Installations->customer->alamat }}
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div>Total (Rp)<br> <strong style="font-size: 16px">{{ number_format($total) }}</strong>
                        </div>
                        <div>status<br><strong style="font-size: 16px"> {{ $trx->Usages->status }}</strong></div>
                    </div>
                </div><br>
                <div class="content"
                    style="display: flex; justify-content: space-between; align-items: flex-start; text-align: center;">
                    <div style="width: 33.3%; text-align: left;">
                        <strong>Phone</strong><br>
                        {{ $trx->Installations->customer->hp }}
                    </div>
                    <div style="width: 33.3%; text-align: center;">
                        <strong>Email</strong><br>
                        {{ $trx->Installations->customer->email }}
                    </div>
                    <div style="width: 33.3%; text-align: right;">
                        Paid Date<br>
                        <strong style="font-size: 12px">{{ Tanggal::tglLatin($trx->tgl_transaksi) }}</strong>
                    </div>
                </div>
                <div class="section-header">
                    Discription
                </div>
                <div class="content"
                    style="margin-top: 1px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="max-width: 80%;">
                        <div>
                            Internet: <strong>{{ $trx->Installations->package->kelas }}, Rp.
                                {{ number_format($trx->Installations->package->harga) }} / month
                            </strong>
                        </div>
                        <div>
                            Subscribe Period: <strong>{{ Tanggal::bulan($trx->Usages->tgl_akhir) }}
                                {{ Tanggal::namaBulan($trx->Usages->tgl_akhir) }}</strong>
                        </div>
                    </div>
                </div>
                <div class="border"></div>
                <div class="content" style="margin-top: 1px; display: flex; justify-content: space-between;">
                    <div style="max-width: 60%;">
                        &nbsp;
                    </div>
                    <div style="text-align: right;">
                        <table>
                            <tr>
                                <td>Sub Total</td>
                                <td class="text-right">{{ number_format($totalTagihan) }}</td>
                            </tr>
                            <tr>
                                <td>PPN 11%</td>
                                <td class="text-right">{{ number_format(($totalTagihan * 11) / 100) }}</td>
                            </tr>
                            <tr>
                                <td>Diskon</td>
                                <td class="text-right">0</td>
                            </tr>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td><strong>{{ number_format($total) }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="footer">
                </div>
            </div>
        </div>
</body>

</html>

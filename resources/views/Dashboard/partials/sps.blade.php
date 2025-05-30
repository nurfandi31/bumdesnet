@php
    use App\Utils\Tanggal;
    use Carbon\Carbon;

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-size: 12px;
            font-family: Arial, sans-serif;
            width: 10cm;
            height: 15cm;
            margin: 1px auto;
            padding: 1px;
            text-align: center;
            position: relative;
        }

        .container {
            width: 200%;
            padding: 10px;
            border: 2px solid rgb(255, 255, 255);
            position: relative;
            left: 50%;
            transform: translateX(-50%);
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
            padding: 2px;
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
            padding: 5px;
        }

        /* Header */
        thead tr th:first-child {
            border-top-left-radius: 10px;
            text-align: center;
        }

        thead tr th:not(:first-child) {
            text-align: left;
        }

        /* Isi kolom */
        tbody tr td:first-child {
            text-align: center;
        }

        tbody tr td:not(:first-child) {
            text-align: left;
        }

        /* Pojok kiri bawah */
        tbody tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        .content tbody td:nth-child(2) {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            font-family: Arial, sans-serif;
            font-size: 13px;
        }
    </style>

</head>

<body onload="window.print()">
    <div class="container">
        <div class="header">
            <div style="font-size: 14px"></div>
            <div></div>
        </div><br>

        <div style="position: relative;">
            <!-- Tabel utama: QR + Data Pelanggan -->
            <div style="position: relative; text-align: center;">
                <table style="width: 100%;">
                    <tr>
                        <td width="20%" style="border: none; text-align: right; padding-right: 0;">
                            <img src="../../assets/img/cetak1.png" style="max-height: 70px;"
                                class="img-fluid d-none d-lg-block">
                        </td>
                        <td width="60%" align="center" style="height: 50px; border: none;">
                            <!-- Placeholder kosong agar posisi tetap -->
                        </td>
                        <td width="20%" style="border: none; text-align: left; padding-left: 0;">
                            <img src="../../assets/img/cetak2.png" style="max-height: 70px;"
                                class="img-fluid d-none d-lg-block">
                        </td>
                    </tr>
                </table>
                <div
                    style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); text-align: center; max-width: 100%;">

                    <div style="font-size: 14px; margin-bottom: 2px;"><b>BADAN USAHA MILIK DESA</b></div>
                    <div style="font-size: 18px; margin-bottom: 2px;"><b>PERUSAHAAN AIR BERSIH
                            {{ strtoupper($bisnis->nama) }}</b></div>
                    <div style="font-size: 14px; margin-bottom: 5px;">KALURAHAN MULO KAPANEWON WONOSARI</div>
                    <!-- jarak lebih besar -->

                    <div style="font-size: 11px; word-wrap: break-word;">
                        <i>Sekretariat: {{ $bisnis->alamat }}</i>
                    </div>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <tr>
                    <td colspan="3" style="border: none; padding: 0;">
                        <div style="border-top: 2px solid rgb(70, 70, 70); width: 100%;"></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 15%; text-align: left; border: none;"></td>
                </tr>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 50px; padding-top: 1px; padding-bottom: 1px;">
                        Nomor
                    </td>
                    <td style="border: none; padding-top: 1px; padding-bottom: 1px;">
                        : ....................

                    </td>
                </tr>

                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 50px; padding-top: 1px; padding-bottom: 1px;">
                        Perihal
                    </td>
                    <td style="border: none; padding-top: 1px; padding-bottom: 1px;">
                        : <b><u>Surat Pemutusan Sementara</u></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="padding: 7px 0; border: none;"></td>
                </tr>
                <td style="text-align: left; border: none; padding-left: 70px; padding-top: 2px; padding-bottom: 2px;">
                </td>
                <td style="border: none; padding-top: 1px; padding-bottom: 1px;">Kepada Yth.</td>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 1px; padding-bottom: 1px;">
                    </td>
                    <td style="border: none; padding-top: 1px; padding-bottom: 1px;">
                        Bpk/Ibu/Sdr <b>{{ $tunggakan->customer->nama }}</b>
                    </td>
                </tr>
                <tr>
                    <td
                        style="text-align: left; border: none; padding-left: 70px; padding-top: 1px; padding-bottom: 1px;">
                    </td>
                    <td style="border: none; padding-top: 1px; padding-bottom: 1px;">Di tempat</td>
                </tr>
            </table>
            <div style="width: 100%; display: flex; justify-content: center;">
                <table style="width: 70%; margin-top: 5px; border-collapse: collapse; border: none;">
                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">
                            Berdasarkan data administrasi kami, hingga saat surat ini diterbitkan, Saudara belum
                            memenuhi kewajiban pembayaran langganan air untuk periode sebagai berikut :
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td colspan="3" style="padding: 4px 0; border: none;"></td>
                    </tr>
                    </tr>
                </table>
            </div>
        </div>
        <div class="content">
            <div style="width: 100%; display: flex; justify-content: center;">
                <table style="width: 69%; border-collapse: collapse; text-align: center; margin-top: 5px;">
                    <thead>
                        <tr>
                            <th style="text-align: center; padding-top: 10px; padding-bottom: 10px;">NO</th>
                            <th style="text-align: center; padding-top: 10px; padding-bottom: 10px;">PERIODE TAGIHAN
                            </th>
                            <th style="text-align: center; padding-top: 10px; padding-bottom: 10px;">NOMINAL</th>
                            <th style="text-align: center; padding-top: 10px; padding-bottom: 10px;">PEMAKAIAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($tunggakan->usage as $i => $u)
                            @php
                                $abodemen = $tunggakan->settings->abodemen ?? 0;
                                $denda = $tunggakan->settings->denda ?? 0;
                                $nominalTotal = $u->nominal + $abodemen + $denda;
                                $total += $nominalTotal;
                            @endphp
                            <tr>
                                <td style="text-align: center;">{{ $i + 1 }}</td>
                                <td style="text-align: left;">&nbsp;
                                    {{ Tanggal::namaBulan($u->tgl_akhir) }} {{ Tanggal::tahun($u->tgl_akhir) }}
                                </td>
                                <td style="text-align: right;">
                                    {{ number_format($nominalTotal, 2, ',', '.') }}&nbsp;
                                </td>
                                <td style="text-align: left;">&nbsp;{{ Tanggal::namaBulan($u->tgl_pemakaian) }}
                                    {{ Tanggal::tahun($u->tgl_pemakaian) }}
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="2"><b>JUMLAH</b></td>
                            <td style="text-align: right;"><b>{{ number_format($total, 2, ',', '.') }}&nbsp;</b></td>
                            <td></td>
                        </tr>
                </table>
            </div>

            <div style="width: 100%; display: flex; justify-content: center;">
                <table style="width: 70%; margin-top: 5px; border-collapse: collapse; border: none;">
                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;"></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">
                            Dengan ini, kami akan melakukan pemutusan sementara terhadap pelanggan
                            sebagai berikut:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 4px 0; border: none;"></td>
                    </tr>
                    <tr>
                        <td width="15%" style="text-align: justify; border: none;">Nama</td>
                        <td width="2%"
                            style="text-align: center; vertical-align: top; padding: 2px 4px 2px 0; border: none;"> :
                        </td>
                        <td style="text-align: justify; border: none;"><b>{{ $tunggakan->customer->nama }}</b></td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; border: none;"> Nomer Induk</td>
                        <td style="text-align: center; vertical-align: top; padding: 2px 4px 2px 0; border: none;">:
                        </td>
                        <td style="text-align: justify; border: none;"><b>{{ $tunggakan->kode_instalasi }}</b></td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; border: none;">Alamat</td>
                        <td style="text-align: center; vertical-align: top; padding: 2px 4px 2px 0; border: none;">:
                        </td>
                        <td style="text-align: justify; border: none;"><b>{{ $tunggakan->alamat }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 4px 0; border: none;"></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">
                            Penyambungan kembali akan dilaksanakan setealah pelanggan melunasi tunggakan dan membayar
                            biaya penyambungan kembali sebesar Rp.
                            {{ number_format($tunggakan->settings->biaya_aktivasi, 2, ',', '.') }},- dengan batas
                            toleransi 7 hari setelah pemutusan sementara. Apabila setelah 7 (tujuh) hari pelanggan tidak
                            memenuhi kewajiban maka akan dilaksanakan pemutusan total sedangkan tunggakan akan tetap
                            sebagai hutang yang harus dibayar/ dilunasi.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 4px 0; border: none;"></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">
                            Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya kami sampaikan terima
                            kasih. </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: justify; border: none;">
                        </td>
                    </tr>
                </table>
            </div>
            <div style="width: 100%; display: flex; justify-content: center;">
                <table style="width: 69%; border-collapse: collapse; margin-top: 5px; border: none;">
                    <tr>
                        <td width="33%" align="center" style="border: none; text-align: center;"></td>
                        <td width="33%" style="border: none;"></td>
                        <td width="33%" style="border: none; text-align: center;">
                            @php
                                $bulanInggris = [
                                    'January',
                                    'February',
                                    'March',
                                    'April',
                                    'May',
                                    'June',
                                    'July',
                                    'August',
                                    'September',
                                    'October',
                                    'November',
                                    'December',
                                ];
                                $bulanIndonesia = [
                                    'Januari',
                                    'Februari',
                                    'Maret',
                                    'April',
                                    'Mei',
                                    'Juni',
                                    'Juli',
                                    'Agustus',
                                    'September',
                                    'Oktober',
                                    'November',
                                    'Desember',
                                ];
                                $tanggalIndo = str_replace(
                                    $bulanInggris,
                                    $bulanIndonesia,
                                    date('d F Y', strtotime(date('Y-m-t'))),
                                );
                            @endphp
                            {{ $bisnis->desa }}, {{ $tanggalIndo }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none;">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="border: none;">
                            <p style="margin-bottom: 0;">Mengetahui,<br>Direktur Bumdes</p>
                            <img src="../../assets/img/ttd2.png" style="max-height: 100px; margin-top: -27px;"
                                class="img-fluid d-none d-lg-block">
                            <p style="margin-top: -5px;"><b>{{ $dir->nama ?? '' }}</b></p>
                        </td>
                        <td style="border: none;"></td>
                        <td align="left" style="border: none; padding-left: 40px;">
                            <p style="margin-bottom: 0; text-indent: 15px;">Ketua<br>Ketua Unit Air</p>
                            <img src="../../assets/img/ttd1.png" style="max-height: 100px; margin-top: -27px;"
                                class="img-fluid d-none d-lg-block">
                            <p style="margin-top: -5px;"><b>{{ $ket->nama ?? '-' }}</b></p>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3" style="border: none; padding: 20px 0;"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

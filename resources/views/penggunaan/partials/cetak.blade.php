@php
    use App\Utils\Tanggal;

    $data_id = [];
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Tagihan Pemakaian Air</title>
    <style>
        body {
            font-size: 10px;
            color: rgba(0, 0, 0, 0.8);
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 200%;
            overflow: auto;
            margin: auto;
        }

        .box {
            display: inline-block;
            box-sizing: border-box;
            vertical-align: top;
            width: 50%;
            height: 8cm;
            border: 2px solid #000;
            padding: 10px;
            margin-bottom: 4px;
        }

        .keterangan {
            padding: 4px;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .border-b {
            border-bottom: 1px dashed rgba(0, 0, 0, 0.4);
        }

        .fw-medium {
            font-weight: 100;
        }

        .terbilang {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .jajargenjang {
            background-color: rgb(204, 204, 204);
            -ms-transform: skew(-20deg);
            -webkit-transform: skew(-20deg);
            transform: skew(-20deg);
            text-align: center;
        }

        .fs-12 {
            font-size: 12px;
        }

        .text-left {
            padding-left: 6px;
            padding-right: 6px;
            padding-top: 2px;
            padding-bottom: 4px;
            text-align: left;
        }

        .tanggal {
            font-size: 8px;
            margin-left: 10px;
        }

        .flex {
            display: flex;
        }
    </style>

</head>

<body>
    <div class="container">
        @foreach ($usage as $use)
            <div class="box">
                <table border="0" width="100%">
                    <tr>
                        <td width="50" align="right">
                            {{-- <img src="../storage/app/public/logo/{{ $gambar }}" width="50" height="50"> --}}
                            <img src="assets/img/cetak1.png"
                                style="max-height: 50px; margin-right: 15px; margin-left: 10px;"
                                class="img-fluid  d-none d-lg-block">

                        </td>
                        <td width="100" align="center">
                            <div class="fw-bold" style="font-size: 14px;">STRUK TAGIHAN PEMAKAIAN AIR</div>
                            <div style="font-size: 11px;">BADAN USAHA MILIK DESA (BUMDes)</div>
                            <div class="fw-bold">UNIT AIR</div>
                        </td>
                        <td width="50" align="left">
                            {{-- <img src="../storage/app/public/logo/{{ $gambar }}" width="50" height="50"> --}}
                            <img src="assets/img/cetak2.png" style="max-height: 50px;"
                                class="mb-3 img-fluid  d-none d-lg-block">

                        </td>
                    </tr>
                    <tr>
                        <td width="50" align="left">
                            <div style="font-size: 11px;">BULAN : {{ Tanggal::bulan($use->tgl_pemakaian) }}
                                {{ Tanggal::tahun($use->tgl_pemakaian) }}</div>
                        </td>
                        <td width="100" align="center">
                            <div style="font-size: 11px;">POS BAYAR : {{ $use->usersCater->nama }}</div>
                        </td>
                        <td width="50" align="right">
                            <div style="font-size: 11px;">NO URUT : {{ $use->installation->id }}</div>
                        </td>
                    </tr>
                </table>
                <table border="1" width="100%" style="border-collapse: collapse; border: 1px solid #000;">
                    <tr>
                        <td width="20%" align="center">NAMA PELANGGAN</td>
                        <td width="13%" align="center">NO INDUK</td>
                        <td width="20%" align="center">ALAMAT</td>
                        <td width="14%" align="center">METER AWAL</td>
                        <td width="14%" align="center">METER AKHIR</td>
                        <td width="15%" align="center">PEMAKAIAN</td>
                    </tr>
                    <tr>
                        <td align="center">{{ $use->customers->nama }}</td>
                        <td align="center">{{ $use->installation->kode_instalasi }}
                            {{ substr($use->installation->package->kelas, 0, 1) }}</td>
                        <td align="center">{{ $use->installation->alamat }}</td>
                        <td align="center">{{ $use->awal }}</td>
                        <td align="center">{{ $use->akhir }}</td>
                        <td align="center">{{ $use->jumlah }}</td>
                    </tr>
                </table>
                <table border="0" width="100%" style="font-size: 11px;">
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="font-size: 12px">RINCIAN BIAYA</td>
                    </tr>
                    <tr>
                        <td width="10%" align="left">Pemakaian Air</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp. {{ number_format($use->nominal, 2) }}</td>
                        <td width="14%" align="center">&nbsp;</td>
                        <td width="14%" align="left">
                            {{ strtoupper($bisnis->desa) }}, {{ Tanggal::tglLatin($use->tgl_pemakaian) }}</td>
                    </tr>
                    <tr>
                        <td width="10%" align="left">Beban Tetap</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp. {{ number_format($use->installation->abodemen, 2) }}</td>
                        <td width="14%" align="center">&nbsp;</td>
                        <td width="14%" align="left">Bendahara</td>
                    </tr>
                    <tr>
                        <td width="10%" align="left">Denda</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp. 0.00</td>
                        <td width="14%" align="center">&nbsp;</td>
                        <td width="14%" align="left">ttd,</td>
                    </tr>
                    <tr>
                        <td width="10%" align="left">Total</td>
                        <td width="2%" align="right">:</td>
                        <td width="20%" align="left">Rp.
                            {{ number_format($use->nominal + $use->installation->abodemen, 2) }}</td>
                        <td width="14%" align="center">&nbsp;</td>
                        <td width="14%" align="left"></td>
                    </tr>
                    <tr>
                        <td width="10%" align="left">Terbilang</td>
                        <td width="2%" align="right">:</td>
                        <td width="14%" class="keterangan fw-medium terbilang">
                            <span>{{ ucwords($keuangan->terbilang($use->nominal + $use->installation->abodemen)) }}
                                Rupiah</span>
                        </td>
                        <td width="14%" align="center">&nbsp;</td>
                        <td width="14%" align="left">{{ strtoupper($jabatan->nama) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center" style="font-size: 10px;">SELURUH PELANGGAN AIR
                            "{{ $bisnis->nama }}" WAJIB MEMATUHI
                            SEGALA
                            KETENTUAN MANAJEMEN
                            PENGELOLAAN OLEH BUMDes BANGUN KENCANA MULO, SESUAI DENGAN PERATURAN DESA MULO NOMOR 3 TAHUN
                            2018.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center" style="font-size: 10px;">KELUHAN PELANGGAN HUBUNGI WA
                            0882-1673-8479 (ISWANTO)
                            0878-0484-5880 (NURUL) NB: TERLAMBAT 2 BULAN AKAN DITERBITKAN SURAT PERINGATAN,
                            TERLAMBAT 3 BULAN
                            AKAN DITERBITKAN
                            SURAT PEMUTUSAN SEMENTARA
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>
</body>

</html>

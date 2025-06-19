@php
    use App\Utils\Tanggal;

    $no = 1;
    $totalNominal = 0;
@endphp
<title>{{ $title }}</title>
<table width="100%" style="border-bottom: 2px solid #000; padding-bottom: 6px; margin-bottom: 10px;">
    <tr>
        <td width="10%" rowspan="2" style="vertical-align: top;">
            <img src="{{ public_path('images/logo-lkm.png') }}" width="60">
        </td>
        <td colspan="2" style="text-align: left;">
            <div style="font-size: 16px; ">{{ $bisnis->nama }}</div>
        </td>
    </tr>
    <tr>
        <td width="45%" style="font-size: 12px; font-style: italic; text-align: left;">
            Jl. {{ $bisnis->alamat }}. {{ $bisnis->desa }}, Telp.{{ $bisnis->telpon }}
        </td>
    </tr>
</table>
<style>
    * {
        font-family: 'Arial', sans-serif;
        line-height: 1.5;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .meta-table td {
        padding: 4px 0;
    }

    .content-table {
        margin-top: 15px;
    }

    .content-table th,
    .content-table td {
        border: 1px solid #000;
        padding: 6px;
        text-align: center;
    }

    .signature-space {
        height: 40px;
    }

    .spacer {
        height: 15px;
    }

    .indent {
        padding-left: 8px;
    }

    .justify {
        text-align: justify;
    }
</style>

<table class="meta-table" border="0">
    <tr>
        <td width="15%">Nomor</td>
        <td width="45%">: ______________________</td>
        <td width="40%"></td>
    </tr>
    <tr>
        <td>Lampiran</td>
        <td>: 1 Bendel</td>
        <td></td>
    </tr>
    <tr>
        <td>Perihal</td>
        <td>: Laporan Keuangan</td>
        <td></td>
    </tr>
</table>

<div class="spacer"></div>

<table border="0">
    <tr>
        <td width="15%">&nbsp;</td>
        <td class="indent" colspan="2">
            <strong>Kepada Yth.</strong><br>
            <strong>Bpk/Ibu/Sdr {{ $installation->customer->nama }}</strong><br>
        </td>
    </tr>
</table>

<div class="spacer"></div>

<table border="0">
    <tr>
        <td width="15%">&nbsp;</td>
        <td class="indent justify" colspan="2">
            <p>Dengan Hormat,</p>
            <p>
                Berdasarkan data administrasi kami, hingga saat surat ini diterbitkan, pelanggan atas nama
                <strong>{{ $installation->customer->nama }}</strong> dengan Nomor Induk Pelanggan:
                <strong>{{ $installation->kode_instalasi }} {{ substr($installation->package->kelas, 0, 1) }}</strong>
                belum memenuhi kewajiban pembayaran langganan internet untuk periode sebagai berikut:
            </p>

            <table class="content-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Awal Pemakaian</th>
                        <th>Akhir Pemakaian</th>
                        <th>Jumlah Tagihan</th>
                        <th>Nominal Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usages as $usage)
                        @php
                            $totalNominal += $usage->nominal;
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ Tanggal::namaBulan($usage->tgl_akhir) }} - {{ Tanggal::tahun($usage->tgl_akhir) }}
                            </td>
                            <td>{{ $usage->awal }}</td>
                            <td> {{ $usage->akhir }}</td>
                            <td>{{ $usage->jumlah }}</td>
                            <td>Rp {{ number_format($usage->nominal, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5"><strong>Total Nominal Tagihan</strong></td>
                        <td><strong>Rp {{ number_format($totalNominal, 2, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>

            <p>
                Daftar di atas merupakan tagihan dengan status <strong>UNPAID</strong> yang harus dilunasi
                sejak diterbitkannya surat ini untuk melunasi seluruh tagihan kepada Bendahara.
            </p>

            <p>
                Demikian laporan ini kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.
            </p>
        </td>
    </tr>
</table>

<div class="spacer"></div>

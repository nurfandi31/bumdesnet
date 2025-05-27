@php
    use App\Utils\Tanggal;
@endphp
@if ($usages->isEmpty())
    <div class="w-100">
        <div class="card rounded-3 shadow-sm w-100" style="height: auto;">
            <div class="card-body p-3 d-flex flex-column flex-md-row align-items-start">
                <div class="mb-3 mb-md-0 me-md-3" style="flex-shrink: 0;">
                    <img src="../assets/static/images/logo/usagenotifikasi.png"
                        style="width: 250px; height: 250px; cursor: zoom-in;" alt="Notifikasi">
                </div>
                <div class="flex-grow-1 d-flex flex-column justify-content-between" style="min-height: 250px;">
                    <div class="mb-2 text-md-end text-center">
                        <h4 class="alert-heading"><b>Pemberitahuan!</b></h4>
                    </div>
                    <div class="flex-grow-1 d-flex align-items-center justify-content-center text-center px-2">
                        <p class="mb-1 fs-4">
                            Customer an. <b class="mb-1 fs-4">{{ $installations->customer->nama }}</b> - kode instalasi
                            <b class="mb-1 fs-4">{{ $installations->kode_instalasi }}</b><br>
                            Tidak ada data <b class="mb-1 fs-4 text-warning">tagihan</b> untuk ditampilkan.
                        </p>
                    </div>
                    <div class="text-md-end text-center mt-3">
                        <a href="/usages" class="btn btn-danger btn-sm">Cek Pemakaian</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="basic-choices position-relative">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pb-0 pt-2 ps-2 pe-2">
                        <div class="border p-2 rounded mb-2">
                            <div class="row align-items-start">
                                <div class="col-12 col-md-12 order-md-1 order-last">
                                    <h4>Pelanggan. {{ $installations->customer->nama ?? '-' }}</h4>
                                </div>
                                <div class="col-12 col-md-12 order-md-1 order-last">
                                    <div class="badges">
                                        <span class="badge bg-danger">Nomor Induk.
                                            {{ $installations->kode_instalasi ?? '-' }}-{{ $installations->package->inisial ?? '-' }}</span>
                                        <span class="badge bg-danger">Cater.
                                            {{ $installations->users->nama ?? '-' }}</span>
                                        <span class="badge bg-danger">Desa.
                                            {{ $installations->village->nama ?? '-' }}</span>
                                        <span class="badge bg-danger">Dusun.
                                            {{ $installations->village->dusun ?? '-' }}</span>
                                        <span class="badge bg-danger">Rt. {{ $installations->rt ?? '00' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($usages as $usage)
        @php
            $blok = json_decode($trx_settings->block, true);
            $jumlah_blok = count($blok);

            $harga = 0;
            $daftar_harga = json_decode($installations->package->harga, true);

            $denda = 0;
            if (date('Y-m-d') >= $usage->tgl_akhir) {
                $denda = $installations->package->denda;
            }
        @endphp
        <div class="basic-choices position-relative">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pb-0 pt-2 pe-2 ps-2">
                            <div class="card mb-2">
                                <div class="card-header py-2 px-2" id="Judul-{{ $usage->id }}">
                                    <h5 class="mb-0 pb-0 pe-0 pt-0 ps-0 alert alert-light bg-white"
                                        data-bs-toggle="collapse" data-bs-target="#Body-{{ $usage->id }}"
                                        aria-expanded="true" aria-controls="Body-{{ $usage->id }}">
                                        Tagihan Bulan {{ Tanggal::namaBulan($usage->tgl_akhir) }}
                                        {{ Tanggal::tahun($usage->tgl_akhir) }}
                                    </h5>
                                </div>
                                <hr>
                                <div id="Body-{{ $usage->id }}" class="collapse"
                                    aria-labelledby="Judul-{{ $usage->id }}" data-bs-parent="#accordion">
                                    <div class="card-body pt-2">
                                        <form action="/transactions" method="post"
                                            id="FormTagihan-{{ $usage->id }}">
                                            @csrf
                                            <input type="hidden" name="clay" value="TagihanBulanan">
                                            <input type="hidden" name="id_instal" value="{{ $installations->id }}">
                                            <input type="hidden" name="id_usage" value="{{ $usage->id }}">
                                            <input type="hidden" name="tgl_akhir" value="{{ $usage->tgl_akhir }}">
                                            <input type="hidden" name="denda"
                                                value="{{ $installations->package->denda }}">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label for="tgl_transaksi">Tanggal Transaksi</label>
                                                            <input type="text"
                                                                class="form-control date tgl_transaksi"
                                                                data-id="{{ $usage->id }}" name="tgl_transaksi"
                                                                value="{{ date('d/m/Y') }}"
                                                                id="tgl_transaksi-{{ $usage->id }}">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label for="kode_instalasi">Kode Instalasi</label>
                                                            <input type="text" class="form-control"
                                                                id="kode_instalasi-{{ $usage->id }}"
                                                                value="{{ $installations->kode_instalasi }}"
                                                                name="kode_instalasi" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <label for="keterangan">Keterangan</label>
                                                            <input type="text" class="form-control"
                                                                id="keterangan-{{ $usage->id }}"
                                                                value="Pembayaran Tagihan Bulanan Atas Nama {{ $installations->customer->nama }}"
                                                                name="keterangan">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 mb-2">
                                                            <label for="tagihan">Tagihan</label>
                                                            <input type="text" class="form-control" name="tagihan"
                                                                id="tagihan-{{ $usage->id }}"
                                                                value="{{ number_format($usage->nominal, 2) }}"
                                                                readonly>
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <label for="abodemen">Abodemen</label>
                                                            <input type="text" class="form-control abodemen"
                                                                name="abodemen"
                                                                id="abodemen-bulanan-{{ $usage->id }}" readonly
                                                                placeholder="0.00"
                                                                value="{{ number_format($trx_settings->abodemen, 2) }}">
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <label for="denda">Denda</label>
                                                            <input type="text" class="form-control denda"
                                                                name="denda" id="denda-bulanan-{{ $usage->id }}"
                                                                readonly placeholder="0.00"
                                                                value="{{ number_format($denda, 2) }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <label for="pembayaran">Pembayaran</label>
                                                            <input type="text"
                                                                class="form-control total perhitungan"
                                                                name="pembayaran" id="pembayaran-{{ $usage->id }}"
                                                                data-id="{{ $usage->id }}"
                                                                value="{{ number_format($usage->nominal + $trx_settings->abodemen + $denda, 2) }}"
                                                                {!! $trx_settings->swit_tombol_trx == '1' ? 'readonly' : '' !!}>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end mt-3">
                                                        <button class="btn btn-warning btn-icon-split me-2"
                                                            type="button"
                                                            data-bs-target="#DetailTRX-{{ $usage->id }}"
                                                            data-bs-toggle="modal">
                                                            <span class="text-white">Detail Pelanggan</span>
                                                        </button>
                                                        <button class="btn btn-secondary btn-icon-split SimpanTagihan"
                                                            type="submit"
                                                            data-form="#FormTagihan-{{ $usage->id }}">
                                                            <span class="text">Simpan Pembayaran</span>
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="DetailTRX-{{ $usage->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="row">
                        <div class="col-lg-12 ps-4 pe-4 pt-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card mb-2">
                                        <!-- Detail Tagihan  -->
                                        <div class="alert alert-info" role="alert">
                                            <div class="row align-items-center">
                                                <div class="col-md-3 text-center">
                                                    <div
                                                        class="d-inline-block p-3 border border-2 rounded bg-light shadow-sm">
                                                        {!! $qr !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-7">
                                                    <h4 class="text-center mb-2"><b>Nama Pelanggan.
                                                            {{ $installations->customer->nama }} </b></h4>
                                                    <hr class="my-2">
                                                    <table>
                                                        <tr>
                                                            <td style="width: 30%;">NIK</td>
                                                            <td style="width: 5%;">:</td>
                                                            <td>{{ $installations->customer->nik }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Alamat</td>
                                                            <td>:</td>
                                                            <td>{{ $installations->customer->alamat }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nomor Induk</td>
                                                            <td>:</td>
                                                            <td>{{ $installations->kode_instalasi }}
                                                                {{ substr($installations->package->kelas, 0, 1) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tagihan Bulan</td>
                                                            <td>:</td>
                                                            <td>{{ Tanggal::tglLatin($usage->tgl_akhir) }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label for="awal">Awal Pemakaian</label>
                                                <input type="text" class="form-control awal"
                                                    id="awal-{{ $usage->id }}" value="{{ $usage->awal }}"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="akhir">Akhir Pemakaian</label>
                                                <input type="text" class="form-control akhir"
                                                    id="akhir-{{ $usage->id }}" value="{{ $usage->akhir }}"
                                                    disabled>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="selisih">Pemakaian Periode ini</label>
                                                <input type="text" class="form-control selisih"
                                                    id="selisih-{{ $usage->id }}" value="{{ $usage->jumlah }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                            Info</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
<script>
    //angka 00,000,00
    $("#tagihan").maskMoney({
        allowNegative: true
    });

    $(".total").maskMoney({
        allowNegative: true
    });
    $(".denda").maskMoney({
        allowNegative: true
    });

    $(".awal").maskMoney({
        allowNegative: true
    });

    $(".akhir").maskMoney({
        allowNegative: true
    });

    $(".selisih").maskMoney({
        allowNegative: true
    });

    //tanggal
    jQuery.datetimepicker.setLocale('de');
    $('.date').datetimepicker({
        i18n: {
            de: {
                months: [
                    'Januar', 'Februar', 'März', 'April',
                    'Mai', 'Juni', 'Juli', 'August',
                    'September', 'Oktober', 'November', 'Dezember',
                ],
                dayOfWeek: [
                    "So.", "Mo", "Di", "Mi",
                    "Do", "Fr", "Sa.",
                ]
            }
        },
        timepicker: false,
        format: 'd/m/Y'
    });
</script>

@php
    use App\Utils\Tanggal;
@endphp
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
        $denda = 0;
        if (date('Y-m-d') >= $usage->tgl_akhir) {
            $denda = $installations->package->denda;
        }
        $abodemen = $installations->package->abodemen;
        $total = $usage->nominal + $denda + $abodemen;

    @endphp
    <div class="basic-choices position-relative">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2 pb-2 pe-3 pt-3 ps-3">
                        <div class="card mb-2">
                            <div class="accordion">
                                <div class="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button">
                                                <h5 class="mb-0 pb-0 pe-0 pt-0 ps-0">
                                                    Tagihan Bulan {{ Tanggal::namaBulan($usage->tgl_akhir) }}
                                                    {{ Tanggal::tahun($usage->tgl_akhir) }}
                                                </h5>
                                            </button>
                                        </h2>
                                        <div class="accordion-body ">
                                            <form action="/transactions" method="post"
                                                id="FormTagihan-{{ $usage->id }}">
                                                @csrf
                                                <input type="hidden" name="clay" value="TagihanBulanan">
                                                <input type="hidden" name="id_instal"
                                                    value="{{ $installations->id }}">
                                                <input type="hidden" name="id_usage" value="{{ $usage->id }}">
                                                <input type="hidden" name="tgl_akhir" value="{{ $usage->tgl_akhir }}">
                                                <input type="hidden" name="denda"
                                                    value="{{ $installations->package->denda }}">

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-md-3 mb-2">
                                                                <label for="tgl_transaksi">Tanggal Transaksi</label>
                                                                <input type="text"
                                                                    class="form-control date tgl_transaksi"
                                                                    data-id="{{ $usage->id }}" name="tgl_transaksi"
                                                                    value="{{ date('d/m/Y') }}"
                                                                    id="tgl_transaksi-{{ $usage->id }}">
                                                            </div>
                                                            <div class="col-md-3 mb-2">
                                                                <label for="kode_instalasi">Kode Instalasi</label>
                                                                <input type="text" class="form-control"
                                                                    id="kode_instalasi-{{ $usage->id }}"
                                                                    value="{{ $installations->kode_instalasi }}"
                                                                    name="kode_instalasi" readonly>
                                                            </div>
                                                            <div class="col-md-3 mb-2">
                                                                <label for="awal">Tanggal Awal Pemakaian</label>
                                                                <input type="text" class="form-control "
                                                                    id="awal-{{ $usage->id }}"
                                                                    value="{{ $usage->awal }}" readonly>
                                                            </div>
                                                            <div class="col-md-3 mb-2">
                                                                <label for="akhir">Tanggal Akhir Pemakaian</label>
                                                                <input type="text" class="form-control "
                                                                    id="akhir-{{ $usage->id }}"
                                                                    value="{{ $usage->akhir }}" readonly>
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
                                                                <input type="text" class="form-control"
                                                                    name="tagihan" id="tagihan-{{ $usage->id }}"
                                                                    value="{{ number_format($usage->nominal, 2) }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label for="abodemen">Abodemen</label>
                                                                <input type="text" class="form-control abodemen"
                                                                    name="abodemen"
                                                                    id="abodemen-bulanan-{{ $usage->id }}"
                                                                    placeholder="0.00"
                                                                    value="{{ number_format($installations->package->abodemen, 2) }}"readonly>
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label for="denda">Denda</label>
                                                                <input type="text" class="form-control denda"
                                                                    name="denda"
                                                                    id="denda-bulanan-{{ $usage->id }}"
                                                                    placeholder="0.00"
                                                                    value="{{ number_format($denda, 2) }}"readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mb-2">
                                                                <label for="pembayaran">Pembayaran</label>
                                                                <input type="text"
                                                                    class="form-control total perhitungan"
                                                                    name="pembayaran"
                                                                    id="pembayaran-{{ $usage->id }}"
                                                                    data-id="{{ $usage->id }}"
                                                                    value="{{ number_format($total, 2) }}"readonly>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-3">
                                                            <button
                                                                class="btn btn-secondary btn-icon-split SimpanTagihan"
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
        </div>
    </div>
@endforeach
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

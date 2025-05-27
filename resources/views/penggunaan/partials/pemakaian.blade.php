<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-2">
            <div class="modal-body">
                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ asset('assets/img/man.png') }}" alt="Admin"
                                        class="rounded-circle avatar-customer" width="150">
                                    <div class="mt-3">
                                        <h4 class="text-dark font-weight-bold namaCustomer"></h4>
                                        <p class="text-secondary mb-1 NikCustomer"></p>
                                        <p class="text-muted font-size-sm AlamatCustomer"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-dark font-weight-bold">No. Induk</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <span class="KdInstallasi"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-dark font-weight-bold">Cater</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <span class="CaterInstallasi"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-dark font-weight-bold">Paket</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <span class="PackageInstallasi"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-dark font-weight-bold">Alamat</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <span class="AlamatInstallasi"></span>
                                    </div>
                                </div>
                                <hr class="mb-0">
                            </div>
                        </div>

                        <div class="row gutters-sm">
                            <div class="col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-group mb-1">
                                            <label for="awal">Meter Awal</label>
                                            <input type="text" class="form-control AkhirUsage input-nilai-awal"
                                                name="awal_" id="awal_" placeholder="Awal Pemakaian" readonly>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="awal">Meter Awal</label>
                                            <input type="text" class="form-control AkhirUsage input-nilai-akhir""
                                                name="akhir_" id="akhir_" placeholder="Akhir Pemakaian">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <canvas id="tmpImage" style="display:none;"></canvas>
                                                <canvas id="previewImage" style="display:none;"></canvas>
                                                <div class="camera-container">
                                                    <video id="video" autoplay playsinline></video>
                                                    <div class="scan-overlay top"></div>
                                                    <div class="scan-overlay bottom"></div>
                                                    <div class="scan-overlay left"></div>
                                                    <div class="scan-overlay right"></div>
                                                    <div class="scan-area"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <button type="button" id="scanMeter"
                                                    class="btn btn-block btn-primary h-100 mt-0">
                                                    Scan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2">
                <input type="hidden" id="tgl_akhir" class="TglAkhirUsage">
                <input type="hidden" id="tgl_pemakaian" class="PemakaianUsage">
                <input type="hidden" name="customer" class="customer" id="customer">
                <input type="hidden" name="jumlah_" class="jumlah_" id="jumlah_">
                <input type="hidden" name="id_instalasi" class="id_instalasi" id="id_instalasi">

                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Kembali</button>
                <button type="button" id="SimpanPemakaian" class="btn btn-info">Simpan Pemakaian</button>
            </div>
        </div>
    </div>
</div>
<script>
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

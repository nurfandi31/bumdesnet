@extends('layout.base')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $title ?? 'x' }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">DataTable</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="container-wrapper">
        <form action="/transactions" method="post" id="FormPembayaran">
            @csrf
            <input type="hidden" name="clay" id="clay" value="pelunasaninstalasi">
            <input type="hidden" name="istallation_id" id="installation">
            <input type="hidden" id="rek_debit">
            <input type="hidden" id="rek_kredit">
            <div class="basic-choices position-relative">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-2 pb-0">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control border-danger"
                                        placeholder="Installations (Kode Installasi / Nama Custommers)"
                                        id="PelunasanInstalasi">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="tgl_transaksi">Tanggal Pelunasan</label>
                                        <input type="text" class="form-control date" name="tgl_transaksi"
                                            id="tgl_transaksi"value=" {{ date('d/m/Y') }}">
                                        <small class="text-danger" id="msg_tgl_transaksi"></small>
                                    </div>
                                </div>
                                <div class="d-none">
                                    <div class="position-relative mb-3">
                                        <label for="abodemen">Abodemen</label>
                                        <input type="text" class="form-control" id="abodemen" name="abodemen" readonly>
                                        <small class="text-danger" id="msg_abodemen"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="biaya_sudah_dibayar">Biaya sudah dibayar</label>
                                        <input type="text" class="form-control" name="biaya_sudah_dibayar"
                                            id="biaya_sudah_dibayar" readonly>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="tagihan">Tagihan</label>
                                        <input type="text" class="form-control" name="tagihan" id="tagihan" readonly>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="pembayaran">Pembayaran</label>
                                        <input type="text" class="form-control total" name="pembayaran" id="pembayaran"
                                            {!! $setting->swit_tombol_trx == '1' ? 'readonly' : '' !!} value="0.00">
                                        <small class="text-danger" id="msg_pembayaran"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="total">Total</label>
                                        <input type="text" class="form-control" id="_total" readonly>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-warning" type="button" id="BtndetailTransaksi">
                                    <span class="text">Detail</span>
                                </button>
                                <button class="btn btn-secondary btn-icon-split btn-struk" type="submit"
                                    id="simpanpembayaran" style="float: right; margin-left: 10px;">
                                    <span class="text" style="float: right;">Simpan Pembayaran</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Detail An. <b>
                                    <div id="nama_customer" class="d-inline"></div>
                                </b>
                            </h6>

                            <div class="position-relative ps-4 border-start">
                                <div class="mb-4 position-relative">
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="me-2 position-relative" style="width: 10px; height: 1px;">
                                            <div
                                                class="position-absolute top-0 start-0 translate-middle bg-white border border-primary rounded-circle p-1">
                                                📅
                                            </div>
                                        </div>
                                        <div class="fw-semibold"><b>Tanggal Order</b></div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="text-muted small">
                                        <span id="order"></span>
                                    </div>
                                </div>
                                <div class="mb-4 position-relative">
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="me-2 position-relative" style="width: 10px; height: 1px;">
                                            <div
                                                class="position-absolute top-0 start-0 translate-middle bg-white border border-primary rounded-circle p-1">
                                                📝
                                            </div>
                                        </div>
                                        <div class="fw-semibold"><b>No. Induk</b></div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="text-muted small">
                                        <span id="kode_instalasi"></span>
                                    </div>
                                </div>
                                <div class="mb-4 position-relative">
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="me-2 position-relative" style="width: 10px; height: 1px;">
                                            <div
                                                class="position-absolute top-0 start-0 translate-middle bg-white border border-primary rounded-circle p-1">
                                                🏠
                                            </div>
                                        </div>
                                        <div class="fw-semibold"><b>Alamat</b></div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="text-muted small">
                                        <span id="alamat">
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-4 position-relative">
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="me-2 position-relative" style="width: 10px; height: 1px;">
                                            <div
                                                class="position-absolute top-0 start-0 translate-middle bg-white border border-primary rounded-circle p-1">
                                                📦
                                            </div>
                                        </div>
                                        <div class="fw-semibold"><b>Package</b></div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="text-muted small">
                                        <span id="package">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Modal detailTransaksi  tagihan-->
        <div class="modal fade" id="detailTransaksi" tabindex="-1" role="dialog"
            aria-labelledby="detailTransaksiLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-scrollable"
                style="max-width: 100%; margin: 0; height: 100%;" role="document">
                <div class="modal-content" style="height: 100%; border-radius: 0;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailTransaksiLabel">Detail Transaksi Pasang Baru</h5>
                    </div>
                    <div class="modal-body" style="overflow-y: auto;">
                        <div id="LayoutdetailTransaksi"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div>&nbsp;</div>
        <form action="/transactions/hapus" method="post" id="formHapus">
            @csrf
            <input type="hidden" name="del_id" id="del_id">
            <input type="hidden" name="del_istal_id" id="del_istal_id">
        </form>
    @endsection

    @section('script')
        <script>
            //angka 00,000,00
            $("#abodemen").maskMoney({
                allowNegative: true
            });

            $("#biaya_instalasi").maskMoney({
                allowNegative: true
            });

            $("#tagihan").maskMoney({
                allowNegative: true
            });

            $(".total").maskMoney({
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


            //hitung _total
            $(document).on('change', '#pembayaran', function() {
                function cleanNumber(value) {
                    let cleanNumber = value.toString().replace(/,/g, ''); // Remove commas
                    return parseFloat(cleanNumber); // Convert back to number
                }

                var jumlah = cleanNumber($(this).val());
                var jumlah_bayar = cleanNumber($("#biaya_sudah_dibayar").val());
                var tagihan = cleanNumber($("#tagihan").val());
                var total = tagihan - (jumlah + jumlah_bayar);

                $("#_total").val(numFormat.format(Math.abs(total)));
            });

            //isi search tagihan to pelunasan
            var installation_id = "";

            if (installation_id > 0) {

                $.get('/transaksi/pelunasan_instalasi/' + installation_id, function(result) {
                    installtaion(false, result)

                    $('#id_instal').html(installation_id)
                })
            }

            //simpan
            $(document).on('click', '#simpanpembayaran', function(e) {
                e.preventDefault();
                $('small').html('');
                var form = $('#FormPembayaran');
                var actionUrl = form.attr('action');
                $.ajax({
                    type: 'POST',
                    url: actionUrl,
                    data: form.serialize(),
                    success: function(result) {
                        if (result.success) {
                            Swal.fire({
                                title: "Berhasil",
                                text: "Simpan Data Instalasi Berhasil",
                                icon: "success",
                                showDenyButton: true,
                                confirmButtonText: "Tambahkan Pembayaran Baru",
                                denyButtonText: "Kembali"
                            }).then((res) => {
                                if (res.isConfirmed) {
                                    window.location.reload();
                                } else if (res.isDenied) {
                                    window.location.href = '#';
                                }
                            });
                            window.open('/transactions/dokumen/struk_instalasi/' + result.transaction_id)
                        }
                    },
                    error: function(result) {
                        const response = result.responseJSON;
                        Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');
                        if (response && typeof response === 'object') {
                            $.each(response, function(key, message) {
                                $('#' + key)
                                    .closest('.input-group.input-group-static')
                                    .addClass('is-invalid');
                                $('#msg_' + key).html(message);
                            });
                        }
                    }
                });
            });

            //detail transaksi
            $(document).on('click', '#BtndetailTransaksi', function(e) {
                var id = $('#installation').val();
                var rek_debit = $('#rek_debit').val();
                var rek_kredit = $('#rek_kredit').val();

                if (id != '') {
                    $.ajax({
                        url: '/transactions/detail_transaksi_instalasi',
                        type: 'get',
                        data: {
                            id,
                            rek_debit,
                            rek_kredit
                        },
                        success: function(result) {
                            $('#detailTransaksi').modal('show')

                            $('#detailTransaksiLabel').html(result.label)
                            $('#LayoutdetailTransaksi').html(result.view)
                        }
                    })
                }
            })

            //hapus detail transaksi
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault()
                var id = $(this).attr('data-id')
                $.get('/transactions/data/' + id, function(result) {
                    $('#del_id').val(result.id)
                    $('#del_instal_id').val(result.installation_id)
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Setelah menekan tombol Hapus Transaksi dibawah, maka transaksi ini akan dihapus dari aplikasi secara permanen.',
                        showCancelButton: true,
                        confirmButtonText: 'Hapus Transaksi',
                        cancelButtonText: 'Batal',
                        icon: 'warning'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var form = $('#formHapus')
                            $.ajax({
                                type: form.attr('method'),
                                url: form.attr('action'),
                                data: form.serialize(),
                                success: function(result) {
                                    if (result.success) {
                                        Swal.fire('Berhasil!', result.msg, 'success')
                                            .then(() => {
                                                window.location.href =
                                                    '/transactions/pelunasan_instalasi';
                                            });
                                    }

                                }
                            })
                        }
                    })
                })
            })
        </script>
    @endsection

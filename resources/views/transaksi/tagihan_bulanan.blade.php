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
    <div>&nbsp;</div>
    <div class="container-fluid" id="container-wrapper">
        <div class="basic-choices position-relative">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-2 pb-2">
                            <div class="row">
                                <div class="col-12 col-md-9 order-md-1 order-last">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control border-warning" id="TagihanBulanan"
                                            placeholder="Usages (Kode Installasi / Nama Custommers)">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 order-md-1 order-last">
                                    <div class="form-group mb-0">
                                        <a href="#"
                                            class="btn btn-warning w-100 d-flex justify-content-center align-items-center"
                                            style="height: 34px;" type="button" id="BtndetailTransaksi">
                                            <span class="text-white fw-bold">Detail Transaksi</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div id="accordion">
            <div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
                <div class="d-flex flex-row align-items-center">
                    <div>
                        <img src="../../assets/static/images/logo/log.png" style="max-height: 200px;">
                    </div>
                    <div class="me-4 text-start">
                        <h3 class="text-gray-800 font-weight-bold">Tagihan!</h3>
                        <p class="lead text-gray-800">Search untuk melakukan pembayaran</p>
                        <a href="/">&larr; Back to Dashboard</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal detailTransaksi  tagihan-->
    <div class="modal fade" id="detailTransaksi" tabindex="-1" role="dialog" aria-labelledby="detailTransaksiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable" style="max-width: 100%; margin: 0; height: 100%;"
            role="document">
            <div class="modal-content" style="height: 100%; border-radius: 0;">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailTransaksiLabel">Detail Transaksi Tagihan</h5>
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

    <form action="/transactions/hapus" method="post" id="formHapus">
        @csrf

        <input type="hidden" name="del_id" id="del_id">
        <input type="hidden" name="del_istal_id" id="del_istal_id">
    </form>
@endsection
@section('script')
    <script>
        //hitung total (tagihan bulanan)
        $(document).on('change', '#pembayaran', function() {
            function cleanNumber(value) {
                let cleanNumber = value.toString().replace(/,/g, '');
                return parseFloat(cleanNumber);
            }
            var jumlah = cleanNumber($(this).val());
            var jumlah_bayar = cleanNumber($("#tagihan").val());
            var total = (jumlah - jumlah_bayar);

            $("#total").val(numFormat.format(Math.abs(total)));
        });

        //detail transaksi
        $(document).on('click', '#BtndetailTransaksi', function(e) {
            var id = dataCustomer.item.id;
            var rek_debit = dataCustomer.rek_debit;
            var rek_kredit = dataCustomer.rek_kredit;

            if (id != '') {
                $.ajax({
                    url: '/transactions/detail_transaksi_tagihan',
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
                    text: 'Setelah menekan tombol Hapus Transaksi dibawah, maka transaksi ini akan dihapus dari aplikasi secara permanen. Dan mengubah status (UNPAID) di pemakaian',
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
                                                '/transactions/tagihan_bulanan';
                                        });
                                }

                            }
                        })
                    }
                })
            })
        })

        //simpan data pembayaran tagihan bulanan
        $(document).on('click', '.SimpanTagihan', function(e) {
            e.preventDefault();
            $('small').html('');

            var target = $(this).attr('data-form'); // narget button
            var form = $(target); // narget form = id
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            icon: "success",
                            draggable: true
                        });

                        formTagihanBulanan(result.installation)
                        window.open('/transactions/dokumen/struk_tagihan/' + result.transaksi)
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

        //simpan pembayaran installations
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
                            title: result.msg,
                            text: "Lanjut Pembayaran Tagihan?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Lanjutkan",
                            denyButtonText: `Tidak`
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

        function cleanNumber(value) {
            let cleanNumber = value.toString().replace(/,/g, '');
            return parseFloat(cleanNumber);
        }

        //form input denda
        $(document).on('change', '.tgl_transaksi', function() {
            var tglTransaksi = $(this).val();

            var id = $(this).attr('data-id');
            var tglAkhir = new Date($('#tgl-akhir-' + id).val()).getTime();
            var denda = $('#denda-' + id).val();

            let tgl = tglTransaksi.split('/');
            let hari = tgl[0];
            let bulan = tgl[1];
            let tahun = tgl[2];

            var tanggal = new Date(`${tahun}-${bulan}-${hari}`).getTime();
            if (tanggal >= tglAkhir) {
                denda = denda;
            } else {
                denda = 0;
            }

            var denda_tagihan = numFormat.format(Math.abs(denda))
            var abodemen = cleanNumber($("#abodemen-bulanan-" + id).val());
            var tagihan = cleanNumber($("#tagihan-" + id).val());
            var denda = cleanNumber(denda_tagihan);

            $("#denda-bulanan-" + id).val(denda_tagihan);
            $('#pembayaran-' + id).val(numFormat.format(Math.abs(denda + abodemen + tagihan)))
        })

        $(document).on('change', '.perhitungan', function() {
            var jumlah = cleanNumber($(this).val());

            var id = $(this).attr('data-id');
            var tagihan = cleanNumber($("#tagihan-" + id).val());
            var pembayaran = cleanNumber($("#pembayaran-" + id).val());

            if (pembayaran > tagihan) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran tidak valid',
                    text: 'Pembayaran tidak boleh melebihi tagihan.',
                    confirmButtonText: 'Coba lagi'
                });
                $('#pembayaran-' + id).val('');
                return;
            }
        });
    </script>
@endsection

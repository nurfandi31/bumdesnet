@extends('Layout.base')
@php
    $label_search = 'Nama/Kode Installasi';
@endphp
@section('content')
    <style>
        .card-custom {
            border: none;
            border-radius: 5px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            background-color: #ffb300;
            margin-top: -40px;
            margin-bottom: -10px;
            margin-left: 12px;
            margin-right: 12px;
        }

        .icon-box {
            width: 58px;
            height: 58px;
            background: linear-gradient(135deg, #555, #555);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-box img {
            width: 32px;
            height: 32px;
        }
    </style>
    <form action="/usages" method="post" id="FormInputPemakaian">
        @csrf
        <input type="hidden" id="tgl_toleransi" value="{{ $settings->tanggal_toleransi }}">

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
        <section class="basic-choices position-relative ">
            <div class="row">
                <div class="col-12 position-relative">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body pb-0 pt-2 ps-2 pe-2">
                                <div class="row">
                                    <div class="col-md-9 mb-0">
                                        <div class="form-group">
                                            <select class="choices form-control" name="caters" id="caters">
                                                <option value="">Pilih Caters</option>
                                                @foreach ($caters as $cater)
                                                    <option value="{{ $cater->id }}">{{ $cater->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-0 p-0 pe-3 ps-3 pb-2">
                                        <div class="d-grid">
                                            <input type="text" name="tanggal" id="tanggal"
                                                class="form-control tanggal date" value="{{ date('d/m/Y') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div>&nbsp;</div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="container mt-4">
                            <div class="card card-custom p-3">
                                <div class="row align-items-center">
                                    <!-- Kiri: Icon dan Judul -->
                                    <div class="col-12 col-md-4 d-flex align-items-center mb-2 mb-md-0">
                                        <div class="icon-box me-2">
                                            <img src="https://img.icons8.com/ios-filled/30/ffffff/document.png"
                                                alt="Icon Proposal" />
                                        </div>
                                        <h4 class="mb-2 text-white" style="font-family: serif;">Daftar Pemakaian</h4>
                                    </div>

                                    <!-- Kanan: Tombol dan Input -->
                                    <div class="col-12 col-md-8">
                                        <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-end">
                                            @if (auth()->user()->jabatan == 1)
                                                <button type="button" class="btn btn-primary" id="btnScanKartu">
                                                    <span class="text">Scan Barcode</span>
                                                </button>
                                            @endif

                                            <input type="text" id="tanggal" class="form-control tanggal date"
                                                style="max-width: 200px;" value="{{ date('d/m/Y') }}">

                                            <input type="text" id="searchInput" class="form-control"
                                                style="max-width: 200px;" placeholder="Search ...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Datatables -->
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div class="table-responsive p-3">
                                            <table
                                                class="table align-items-center table-flush table-center table-hover mb-0"
                                                id="TbPemakain">
                                                <thead class="table-secondary" align="center">
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>No.Induk</th>
                                                        <th>Meter Awal</th>
                                                        <th>Meter Akhir</th>
                                                        <th>Pemakaian</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="DaftarInstalasi">
                                                    <!-- Data akan ditambahkan di sini -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div
                                class="col-12  justify-content-end {{ auth()->user()->jabatan == '5' ? 'd-none' : 'd-flex' }}">
                                <a href="/usages" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>

    <div style="display: none;" id="print"></div>
    @include('penggunaan.partials.pemakaian')
    @include('penggunaan.barcode')
@endsection

@section('script')
    <script>
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
    <script>
        let dataInstallation;
        let dataSearch;
        let indexInput;
        let dataPemakaian = [];

        var id_user = '{{ auth()->user()->id }}'
        $(document).ready(function() {
            $('#caters').val(id_user).change()
        })
        var startScan, scanningEnabled = true;
        var html5QrcodeScanner;

        $(document).ready(function() {
            scanningEnabled = true

            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                false);

            html5QrcodeScanner.render((result) => {
                if (scanningEnabled) {
                    $('tr[data-id=' + result + '] td:first-child').click()
                    $('#scanQrCode').modal('hide')
                }
            });

            $('#html5-qrcode-button-camera-start').hide()
            $('#html5-qrcode-button-camera-stop').hide()
            $('#html5-qrcode-anchor-scan-type-change').hide()

            $('#html5-qrcode-button-camera-start').trigger('click')

            startScan = true
            $('#stopScan').html('Stop')
        })

        $(document).on('click', '#stopScan', function(e) {
            e.preventDefault()

            if (startScan) {
                $(this).html('Scan Ulang')
                $('#html5-qrcode-button-camera-stop').trigger('click')
            } else {
                scanningEnabled = true;
                $(this).html('Stop')
                $('#html5-qrcode-button-camera-start').trigger('click')
            }

            startScan = !startScan
        })

        $(document).on('click', '#scanQrCodeClose', function(e) {
            $('#scanQrCode').modal('hide')
            $('#html5-qrcode-button-camera-stop').trigger('click')
            $('#stopScan').html('Stop')
        })

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);
        }

        function onScanFailure(error) {
            console.warn(`Code scan error = ${error}`);
        }

        const video = document.getElementById('video');
        navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: {
                        ideal: "environment"
                    }
                }
            })
            .then(stream => {
                video.srcObject = stream;

                const track = stream.getVideoTracks()[0];
                const settings = track.getSettings();

                if (settings.facingMode === "user") {
                    video.classList.add("mirror");
                } else {
                    video.classList.remove("mirror");
                }
            });

        $(document).on('click', '#scanMeter', function(e) {
            const canvas = document.getElementById('tmpImage');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const context = canvas.getContext('2d');
            context.filter = "contrast(250%) brightness(125%)";
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const scanX = canvas.width * 0.20;
            const scanY = canvas.height * 0.40;
            const scanWidth = canvas.width * 0.60;
            const scanHeight = canvas.height * 0.20;

            const previewImage = document.getElementById("previewImage");
            previewImage.width = scanWidth;
            previewImage.height = scanHeight;

            const previewContex = previewImage.getContext("2d");
            const imageData = context.getImageData(scanX, scanY, scanWidth, scanHeight);
            previewContex.putImageData(imageData, 0, 0);

            setTimeout(() => {
                Tesseract.recognize(
                    previewImage,
                    'eng', {
                        logger: m => console.log(m),
                        tessedit_char_whitelist: '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ ',
                        preserve_interword_spaces: 1,
                        oem: 3,
                        psm: 4,
                    }
                ).then(({
                    data: {
                        text
                    }
                }) => {
                    const hasilMatch = text.match(/\d+/);
                    const angka = hasilMatch ? hasilMatch[0] : "0";

                    console.log(text, angka);
                    $('.input-nilai-akhir').val(angka);
                });
            }, 500);
        })

        $('#btnScanKartu').on('click', function(e) {
            e.preventDefault();
            $('#scanQrCode').modal('show');
        });
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.add(
                        'd-none'); // Menyembunyikan notifikasi dengan menambahkan class 'd-none'
                }, 5000); // Notifikasi hilang setelah 5 detik
            }
        });

        $(document).on('change', '.hitungan', function() {
            var awal = $('#awal').val()
            var akhir = $('#akhir').val()

            if (akhir - awal < 0 || akhir == '') {
                return;
            }
        });


        $(document).on('change', '.tanggal', function(e) {
            $('.tanggal').val($(this).val());
        })

        $(document).on('change', '#caters, .tanggal', function(e) {
            e.preventDefault()

            var id_cater = $('#caters').val();
            var tanggal = $('#tanggal').val();
            $.get('/installations/cater/' + id_cater + '?tanggal=' + tanggal, function(result) {
                if (result.success) {
                    dataInstallation = result.installations;
                    dataSearch = dataInstallation
                    setTable(dataInstallation)
                }
            })
        })

        $(document).on('click', '#TbPemakain #DaftarInstalasi tr td', function() {
            var parent = $(this).parent()
            var allowInput = parent.attr('data-allow-input')
            var index = parent.attr('data-index')

            var installation = dataSearch[index]

            if (installation.customer.jk == 'P') {
                $('.avatar-customer').attr('src', '{{ asset('assets/img/woman.png') }}')
            } else {
                $('.avatar-customer').attr('src', '{{ asset('assets/img/man.png') }}')
            }

            var inisialPaket = installation.package.kelas.charAt(0).toUpperCase()
            $('.namaCustomer').html(installation.customer.nama)
            $('.customer').val(installation.customer_id)
            $('.NikCustomer').html(installation.customer.nik)
            $('.id_instalasi').val(installation.id)
            $('.AlamatCustomer').html(installation.customer.alamat + '.' + installation.customer.hp)
            $('.KdInstallasi').html(installation.kode_instalasi + ' ' + inisialPaket)
            $('.CaterInstallasi').html(installation.users.nama)
            $('.PackageInstallasi').html(installation.package.kelas)
            $('.AlamatInstallasi').html(installation.alamat)
            $('.AkhirUsage').val(installation.one_usage?.akhir || 0)
            $('.TglAkhirUsage').val(installation.one_usage?.tgl_akhir || 0)
            $('.PemakaianUsage').val(installation.one_usage?.tgl_pemakaian || 0)

            if (allowInput == 'false') {
                $('#SimpanPemakaian').attr('disabled', true)
            } else {
                $('#SimpanPemakaian').attr('disabled', false)
            }

            $('#staticBackdrop').modal('show')
            indexInput = index
        })

        $(document).on('keyup', '#searchInput', function() {
            searching($(this).val());
        });

        function searching(search) {
            let data = dataInstallation;

            dataSearch = data.filter((element) => {
                return (
                    element.kode_instalasi.includes(search) ||
                    element.customer.nama.toLowerCase().includes(search)
                )
            });

            setTable(dataSearch)
        }

        function setTable(data) {
            var table = $('#DaftarInstalasi');
            table.html('');

            data.forEach((item, index) => {
                var nilai_awal = (item.one_usage) ? item.one_usage.akhir : '0';
                var nilai_akhir = (item.one_usage) ? item.one_usage.akhir : '0';
                var nilai_jumlah = (item.one_usage) ? item.one_usage.jumlah : '0';

                //set warna
                function formatbulan1(tanggal,
                    dataReturn = 'date') {
                    if (!tanggal) return '';
                    let parts = tanggal.split('/');
                    if (parts.length === 3) {
                        let [day, month, year] = parts;
                        if (
                            dataReturn == 'month') {
                            return month;
                        }
                    }
                }

                function formatbulan2(tanggal,
                    dataReturn = 'date') {
                    if (!tanggal) return '';
                    let parts = tanggal.split('-');
                    if (parts.length === 3) {
                        let [day, month, year] = parts;
                        if (
                            dataReturn == 'month') {
                            return month;
                        }
                    }
                }

                var tgl_pemakaian = (item.one_usage) ? formatbulan2(item.one_usage.tgl_pemakaian, 'month') : '0';
                var tgl_akhir = (item.one_usage) ? formatbulan2(item.one_usage.tgl_akhir, 'month') : '0';
                var tgl_hariini = formatbulan1($('#tanggal').val(), 'month');

                var allowInput = true;
                var colorClass = 'text-danger';
                allowInput = false;
                hasildata = 0;
                jumlahN = 0;

                if (tgl_akhir <= tgl_hariini) {
                    allowInput = true;
                    colorClass = 'text-warning';
                    hasildata = nilai_awal;
                    jumlahN = 0;
                }

                if (tgl_pemakaian >= tgl_hariini || jQuery.inArray(item.id.toString(), dataPemakaian) !== -1) {
                    allowInput = false;
                    colorClass = 'text-success';
                    hasildata = nilai_akhir;
                    jumlahN = nilai_jumlah;
                }
                //endset
                table.append(`
            <tr data-index="${index}" data-allow-input="${allowInput}" data-id="${item.id}">
                <td align="left">${item.customer.nama}</td>    
              <td align="center">${item.kode_instalasi} ${item.package.kelas.charAt(0)}</td>   
                <td align="right" class="awal"><b>${nilai_awal}</b></td> 
                <td align="right" class="akhir ${colorClass}"><b>${hasildata}</b></td> 
                <td align="right" class="jumlah">${jumlahN}</td> 
            </tr>
        `);
            });
        }

        $(document).on('focus', '.input-nilai-akhir', function(e) {
            e.preventDefault();
            $(this).select();
        });

        $(document).on('change', '.input-nilai-akhir', function(e) {
            e.preventDefault()

            var id = $(this).attr('id').split('_')[1]
            var nilai_akhir = $(this).val()
            var nilai_awal = $('#awal_' + id).val()

            if (nilai_akhir - nilai_awal < 0) {
                Swal.fire({
                    title: 'Periksa kembali nilai yang dimasukkan',
                    text: 'Nilai Akhir tidak boleh lebih kecil dari Nilai Awal',
                    icon: 'warning',
                })

                $(this).val(nilai_awal)
                return;
            }

            var jumlah = nilai_akhir - nilai_awal
            $('#jumlah_' + id).val(jumlah)
        })

        $(document).on('click', '#SimpanPemakaian', function(e) {
            e.preventDefault()

            var id_cater = $('#caters').val();
            var customer = $('#customer').val();
            var awal = $('#awal_').val();
            var akhir = $('#akhir_').val();
            var jumlah = $('#jumlah_').val();
            var id = $('#id_instalasi').val();
            var tgl = $('#tanggal').val();
            var toleransi = $('#tgl_toleransi').val();

            var data = {
                id: id,
                tgl_pemakaian: tgl,
                id_cater: id_cater,
                customer: customer,
                awal: awal,
                akhir: akhir,
                jumlah: jumlah,
                toleransi: toleransi
            }

            var form = $('#FormInputPemakaian')
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: {
                    _token: form.find('input[name="_token"]').val(),
                    tanggal: $('#tanggal').val(),
                    data: data
                },
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: 'Pemakaian Berhasil di Input'
                        });

                        let pemakaian = result.pemakaian;
                        dataSearch[indexInput].one_usage = pemakaian;

                        var tr = 'tr[data-index="' + indexInput + '"]';
                        $('#DaftarInstalasi ' + tr).attr('data-allow-input', 'false')

                        $('#DaftarInstalasi ' + tr + ' .awal').html(pemakaian.awal)
                        $('#DaftarInstalasi ' + tr + ' .akhir').html(pemakaian.akhir)
                        $('#DaftarInstalasi ' + tr + ' .jumlah').html(pemakaian.jumlah)

                        $('#DaftarInstalasi ' + tr + ' .akhir').removeClass('text-warning')
                        $('#DaftarInstalasi ' + tr + ' .akhir').addClass('text-success')

                        dataPemakaian.push(pemakaian.id_instalasi)
                        $('#staticBackdrop').modal('hide')
                    }
                },
            })
        })
    </script>
@endsection

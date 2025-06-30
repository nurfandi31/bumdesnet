@extends('Layout.base')
@section('content')
    <style>
        @media (max-width: 576px) {

            /* Untuk layar kecil seperti HP */
            #bar {
                height: 300px !important;
            }

            .card-body {
                max-height: none !important;
            }
        }

        @media (min-width: 577px) {

            /* Untuk layar sedang dan besar (laptop/desktop) */
            #bar {
                height: 300px !important;
            }

            .card-body {
                max-height: 265px !important;
            }
        }
    </style>
    <br>
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row align-items-center">
                                <div class="col-12 d-flex align-items-center">
                                    <div class="stats-icon bg-success text-white me-3">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted font-semibold mb-1">Pendaftaran</h6>
                                        <h6 class="font-extrabold mb-0 text-success" id="InstallationCount">
                                            {{ $Permohonan }}</h6>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12" align="right">
                                    <a href="#"id="BtnModalPermohonan" class="text-primary"><b>Lihat Detail ></b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row align-items-center">
                                <div class="col-12 d-flex align-items-center">
                                    <div class="stats-icon bg-info me-3">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted font-semibold mb-1">Terpasang</h6>
                                        <h6 class="font-extrabold mb-0 text-info" id="UsageCount">
                                            {{ $Pasang }}</h6>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12" align="right">
                                    <a href="#" id="BtnModalPasang" class="text-primary"><b>Lihat Detail ></b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row align-items-center">
                                <div class="col-12 d-flex align-items-center">
                                    <div class="stats-icon bg-warning me-3">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted font-semibold mb-1">Pemakaian Aktif</h6>
                                        <h6 class="font-extrabold mb-0 text-warning" id="TunggakanCount">
                                            {{ $Aktif }}</h6>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12" align="right">
                                    <a href="#" id="BtnModalPemakaianAktif" class="text-primary"><b>Lihat
                                            Detail ></b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row align-items-center">
                                <div class="col-12 d-flex align-items-center">
                                    <div class="stats-icon bg-danger me-3">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted font-semibold mb-1">Tagihan</h6>
                                        <h6 class="font-extrabold mb-0 text-danger" id="TagihanCount">
                                            {{ $Tagihan }}</h6>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12" align="right">
                                    <a href="#" id="BtnModalTagihan" class="text-primary"><b>Lihat Detail ></b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-4">
                    <div class="card h-70 d-flex flex-column">
                        <div class="card-header p-3 pb-2 ps-3 pe-2 pt-3">
                            <h4>Saldo Bulan Ini</h4>
                        </div>
                        <div class="card-body flex-grow-1">
                            <div class="row h-70 align-items-center">
                                <div class="col-12">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="card h-70 d-flex flex-column">
                        <div class="card-header p-3 pb-2 ps-3 pe-2 pt-3">
                            <h4>Realisasi Pendapatan dan Beban</h4>
                        </div>
                        <div class="card-body flex-grow-1" style="position: relative;">
                            <div id="bar" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="ModalInstalasi" tabindex="-1" role="dialog" aria-labelledby="ModalInstalasiLabel"
        aria-modal="false">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalInstalasiLabel">Daftar Pendaftaran</h5>
                    <button type="button" class="close btn-modal-close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.Induk</th>
                                        <th>Customer</th>
                                        <th>Sales</th>
                                        <th>Paket</th>
                                        <th>Tgl Order</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="TablePermohonan"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-modal-close">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalPasang" tabindex="-1" role="dialog" aria-labelledby="ModalPasangLabel"
        aria-modal="false">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalPasangLabel">Daftar Terpasang</h5>
                    <button type="button" class="close btn-modal-close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.Induk</th>
                                        <th>Customer</th>
                                        <th>Paket</th>
                                        <th>Tgl Order</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="TablePasang"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-modal-close">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalAktif" tabindex="-1" role="dialog" aria-labelledby="ModalAktifLabel"
        aria-modal="false">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalAktifLabel">Daftar Pemakaian Aktif</h5>
                    <button type="button" class="close btn-modal-close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.Induk</th>
                                        <th>Customer</th>
                                        <th>Paket</th>
                                        <th>Tgl Order</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="TablePemakaianAktif"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-modal-close">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalTagihan" tabindex="-1" role="dialog" aria-labelledby="ModalTagihanLabel"
        aria-modal="false">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalTagihanLabel">Daftar Tagihan</h5>
                    <button type="button" class="close btn-modal-close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.Induk</th>
                                        <th>Customer</th>
                                        <th>Tgl Tagihan</th>
                                        <th>Jumlah</th>
                                        <th>Tagihan</th>
                                    </tr>
                                </thead>


                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-modal-close">Tutup</button>
                    <button type="button" id="SendWhatsappMessage" class="btn btn-primary">Kirim Pesan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.addEventListener('resize', function() {
            myChart.resize();
        });

        const chart = document.getElementById('myChart');
        new Chart(chart, {
            type: 'pie',
            data: {
                labels: ['Pendapatan', 'Beban', 'Surplus'],
                datasets: [{
                    label: 'Saldo Bulan Ini',
                    data: [
                        {{ $SaldoPendapatanBulanini }},
                        {{ $SaldoBebanBulanini }},
                        {{ $SaldoSurplusBulanini }}
                    ],
                    backgroundColor: [
                        'green',
                        'red',
                        'orange'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });
    </script>
    <script>
        $(document).on("DOMContentLoaded", function() {
            var dataChart = JSON.parse(@json($charts));
            var barChart = echarts.init(document.getElementById('bar'));

            var option = {
                redrawOnWindowResize: true,
                redrawOnParentResize: true,
                width: '90%',
                height: '150px',
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    data: ['Pendapatan', 'Beban', 'Surplus'],
                },
                xAxis: {
                    type: 'category',
                    data: dataChart.nama_bulan
                },
                yAxis: {
                    type: 'value',
                    name: '$ (saldo)',
                    nameLocation: 'middle',
                    nameGap: 60
                },
                series: [{
                        name: 'Pendapatan',
                        type: 'bar',
                        data: dataChart.pendapatan,
                        itemStyle: {
                            color: '#4CAF50'
                        }
                    },
                    {
                        name: 'Beban',
                        type: 'bar',
                        data: dataChart.beban,
                        itemStyle: {
                            color: '#E53935'
                        }
                    },
                    {
                        name: 'Surplus',
                        type: 'bar',
                        data: dataChart.surplus,
                        itemStyle: {
                            color: '#f5a623'
                        }
                    }
                ]
            };

            barChart.setOption(option);

            window.addEventListener('resize', function() {
                barChart.resize();
            });
        });
    </script>

    <script>
        async function dataPermohonan() {
            var result = await $.ajax({
                'url': '/dashboard/permohonan',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    return result
                }
            })

            return result;
        }

        async function dataPasang() {
            var result = await $.ajax({
                'url': '/dashboard/pasang',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    return result
                }
            })

            return result;
        }

        async function dataPemakaianAktif() {
            var result = await $.ajax({
                'url': '/dashboard/PemakaianAktif',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    return result
                }
            })

            return result;
        }

        async function dataTagihan() {
            var result = await $.ajax({
                'url': '/dashboard/tagihan',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    return result
                }
            })

            return result;
        }

        $(document).on('click', '#BtnModalPermohonan', async function(e) {
            e.preventDefault();
            var result = await dataPermohonan();
            var Instalasi = result.permohonan;

            var data = 0;
            var empty = 0;
            $('#TablePermohonan').html('');
            Instalasi.forEach((item, index) => {
                if (item == null) {
                    empty += 1;
                } else {
                    $('#TablePermohonan').append(`
                        <tr>
                            <td>${item.kode_instalasi}</td>
                            <td>${item.customer.nama}</td>
                            <td>${item.users.nama}</td>
                            <td>${item.package.kelas}</td>
                            <td>${item.order}</td>
                            <td><span class="badge bg-success">R</span></td>
                        </tr>
                    `)
                }

                data += 1
            })

            if (data - empty == 0) {
                $('#TablePermohonan').append(`
                        <tr>
                            <td align="center" colspan="4">Tidak ada data Pendaftaran</td>
                        </tr>
                    `)
            }

            $('#ModalInstalasi').modal('toggle');
        });

        $(document).on('click', '#BtnModalPasang', async function(e) {
            e.preventDefault();
            var result = await dataPasang();
            var Pasang = result.Pasang;

            var data = 0;
            var empty = 0;
            $('#TablePasang').html('');
            Pasang.forEach((item, index) => {
                if (item == null) {
                    empty += 1;
                } else {
                    $('#TablePasang').append(`
                        <tr>
                            <td>${item.kode_instalasi}</td>
                            <td>${item.customer.nama}</td>
                            <td>${item.users.nama}</td>
                            <td>${item.package.kelas}</td>
                            <td>${item.order}</td>
                            <td><span class="badge bg-success">I</span></td>
                        </tr>
                    `)
                }

                data += 1
            })

            if (data - empty == 0) {
                $('#TablePasang').append(`
                        <tr>
                            <td align="center" colspan="4">Tidak ada data Pendaftaran</td>
                        </tr>
                    `)
            }

            $('#ModalPasang').modal('toggle');
        });

        $(document).on('click', '#BtnModalPemakaianAktif', async function(e) {
            e.preventDefault();
            var result = await dataPemakaianAktif();
            var pemakaian = result.pemakaian;
            console.log(pemakaian);

            var data = 0;
            var empty = 0;
            $('#TablePemakaianAktif').html('');
            pemakaian.forEach((item, index) => {
                if (item == null) {
                    empty += 1;
                } else {
                    $('#TablePemakaianAktif').append(`
                        <tr>
                            <td>${item.kode_instalasi}</td>
                            <td>${item.customer.nama}</td>
                            <td>${item.users.nama}</td>
                            <td>${item.package.kelas}</td>
                            <td>${item.order}</td>
                            <td><span class="badge bg-success">A</span></td>
                        </tr>
                    `)
                }

                data += 1
            })

            if (data - empty == 0) {
                $('#TablePemakaianAktif').append(`
                        <tr>
                            <td align="center" colspan="4">Tidak ada data Pendaftaran</td>
                        </tr>
                    `)
            }

            $('#ModalAktif').modal('toggle');
        });

        $(document).on('click', '#BtnModalTagihan', async function(e) {
            e.preventDefault();

            var result = await dataTagihan();
            var Tagihan = result.Tagihan;
            var setting = result.setting;
            // var block = result.block; 

            $('#TableTagihan').html('');
            Tagihan.forEach((item, index) => {
                var paket = JSON.parse(item.installation.package.harga);

                // Ambil angka dari kelas, contoh: "Mbps [ 30 ]" → 30
                var kelasStr = item.installation.package.kelas;
                var match = kelasStr.match(/\[\s*(\d+)\s*\]/);
                var kelas = match ? match[1] : null;
                var harga = kelas && paket[kelas] ? paket[kelas] : 0;

                var pesan_tagihan = ReplaceText(setting.pesan_tagihan, {
                    'customer': item.installation.customer.nama,
                    'desa': item.installation.customer.village.nama,
                    'kode_instalasi': item.installation.kode_instalasi,
                    'jatuh_tempo': formatDate(item.tgl_akhir),
                    'jumlah_tagihan': harga,
                    'user_login': '{{ Auth::user()->nama }}',
                    'telpon': '{{ Auth::user()->telpon }}'
                });

                $('#TableTagihan').append(`
            <tr>
                <td>
                    <input type="hidden" class="pesan" name="pesan_tagihan[]" value="${item.installation.customer.hp}||${pesan_tagihan}">
                    ${item.installation.kode_instalasi}
                </td>
                <td>${item.installation.customer.nama}</td>
                <td>${item.tgl_akhir}</td>
                <td>${item.jumlah}</td>
                <td>${harga}</td>
            </tr>
         `);
            });

            $('#ModalTagihan').modal('toggle');
        });

        $(document).on('click', '#SendWhatsappMessage', function(e) {
            e.preventDefault()

            var messages = [];
            $('.pesan').each(function(i) {
                var pesan = this.value

                var number = pesan.split('||')[0]
                var msg = pesan.split('||')[1]

                if (!number.startsWith('08') && !number.startsWith('628')) {
                    number = '0' + number;
                }

                messages.push({
                    number,
                    message: msg
                })
            });

            $.ajax({
                type: 'POST',
                url: '{{ $api }}/api/message/{{ $business->token }}/send_messages',
                contentType: 'application/json',
                data: JSON.stringify({
                    messages
                }),
                success: function(result) {
                    if (result.success) {
                        Swal.fire('Berhasil', 'Pesan Berhasil Dikirim', 'success')
                    }
                }
            })

        })

        function ReplaceText(text, key_value) {
            return text.replace(/{([^}]+)}/g, function(match, key) {
                return key_value[key] || match;
            });
        }
    </script>
@endsection

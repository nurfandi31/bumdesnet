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
                                    <!-- Ikon -->
                                    <div class="stats-icon bg-success text-white me-3">
                                        <i class="iconly-boldProfile"></i>
                                        <!-- fs-3 = lebih besar -->
                                    </div>
                                    <!-- Teks di samping ikon -->
                                    <div>
                                        <h6 class="text-muted font-semibold mb-1">Instalasi</h6>
                                        <h6 class="font-extrabold mb-0 text-success" id="InstallationCount">
                                            {{ $Installation }}</h6>
                                    </div>
                                </div>
                                <!-- Garis pemisah -->
                                <div class="col-12">
                                    <hr>
                                </div>
                                <!-- Link Lihat Detail -->
                                <div class="col-12" align="right">
                                    <a href="#"id="BtnModalInstalasi" class="text-primary"><b>Lihat Detail ></b></a>
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
                                    <!-- Ikon -->
                                    <div class="stats-icon bg-info me-3">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                    <!-- Teks di samping ikon -->
                                    <div>
                                        <h6 class="text-muted font-semibold mb-1">Pemakaian</h6>
                                        <h6 class="font-extrabold mb-0 text-info" id="UsageCount">
                                            {{ $UsageCount }}</h6>
                                    </div>
                                </div>
                                <!-- Garis pemisah -->
                                <div class="col-12">
                                    <hr>
                                </div>
                                <!-- Link Lihat Detail -->
                                <div class="col-12" align="right">
                                    <a href="#" id="BtnModalPemakaian" class="text-primary"><b>Lihat Detail ></b></a>
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
                                    <!-- Ikon -->
                                    <div class="stats-icon bg-warning me-3">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                    <!-- Teks di samping ikon -->
                                    <div>
                                        <h6 class="text-muted font-semibold mb-1">Tunggakan</h6>
                                        <h6 class="font-extrabold mb-0 text-warning" id="TagihanCount">
                                            {{ $Tunggakan }}</h6>
                                    </div>
                                </div>
                                <!-- Garis pemisah -->
                                <div class="col-12">
                                    <hr>
                                </div>
                                <!-- Link Lihat Detail -->
                                <div class="col-12" align="right">
                                    <a href="#" id="BtnModalTunggakan" class="text-primary"><b>Lihat
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
                                    <!-- Ikon -->
                                    <div class="stats-icon bg-danger me-3">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                    <!-- Teks di samping ikon -->
                                    <div>
                                        <h6 class="text-muted font-semibold mb-1">Tagihan</h6>
                                        <h6 class="font-extrabold mb-0 text-danger"id="TagihanCount">
                                            {{ $Tagihan }}</h6>
                                    </div>
                                </div>
                                <!-- Garis pemisah -->
                                <div class="col-12">
                                    <hr>
                                </div>
                                <!-- Link Lihat Detail -->
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
                    <h5 class="modal-title" id="ModalInstalasiLabel">Daftar Instalasi</h5>
                    <button type="button" class="close btn-modal-close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="card pe-3">
                            <div class="card-body p-2 pb-3 pt-2 ">
                                <ul class="nav nav-tabs row pe-2 ps-2" id="myTab" role="tablist">
                                    <div class="col-12 col-md-4 p-0">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active text-center" id="Permohonan-tab"
                                                data-bs-toggle="tab" href="#Permohonan" role="tab"
                                                aria-controls="Permohonan" aria-selected="true"><b>Permohonan</b></a>
                                        </li>
                                    </div>
                                    <div class="col-12 col-md-4 p-0">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-center" id="Pasang-tab" data-bs-toggle="tab"
                                                href="#Pasang" role="tab" aria-controls="Pasang"
                                                aria-selected="false"><b>Pasang</b></a>
                                        </li>
                                    </div>
                                    <div class="col-12 col-md-4 p-0">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-center" id="Aktif-tab" data-bs-toggle="tab"
                                                href="#Aktif" role="tab" aria-controls="Aktif"
                                                aria-selected="false"><b>Aktif</b></a>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="Permohonan" role="tabpanel"
                                aria-labelledby="Permohonan-tab">
                                <div class="card pe-3">
                                    <div class="table-responsive pe-3 mb-3 p-3">
                                        <table class="table table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>No.Induk</th>
                                                    <th>Customer</th>
                                                    <th>Alamat</th>
                                                    <th>Paket</th>
                                                    <th>Tanggal Order</th>
                                                </tr>
                                            </thead>
                                            <tbody id="TablePermohonan"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Pasang" role="tabpanel" aria-labelledby="Pasang-tab">
                                <div class="card pe-3">
                                    <div class="table-responsive pe-3 mb-3 p-3">
                                        <table class="table table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>No.Induk</th>
                                                    <th>Customer</th>
                                                    <th>Alamat</th>
                                                    <th>Paket</th>
                                                    <th>Tanggal Order</th>
                                                </tr>
                                            </thead>
                                            <tbody id="TablePasang"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Aktif" role="tabpanel" aria-labelledby="Aktif-tab">
                                <div class="card pe-3">
                                    <div class="table-responsive pe-3 mb-3 p-3">
                                        <table class="table table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>No.Induk</th>
                                                    <th>Customer</th>
                                                    <th>Alamat</th>
                                                    <th>Paket</th>
                                                    <th>Tanggal Order</th>
                                                </tr>
                                            </thead>
                                            <tbody id="TableAktif"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary btn-modal-close">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalPemakaian" tabindex="-1" role="dialog" aria-labelledby="ModalPemakaianLabel"
        aria-modal="false">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalPemakaianLabel">Daftar Pemakaian</h5>
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
                                        <th>Pemakaian</th>
                                    </tr>
                                </thead>
                                <tbody id="TablePemakaian"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary btn-modal-close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalTunggakan" tabindex="-1" role="dialog" aria-labelledby="ModalPemakaianLabel"
        aria-modal="false">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalTunggakanLabel">Daftar Tunggakan</h5>
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
                                        <th>Alamat</th>
                                        <th>Paket</th>
                                        <th>Jumlah Tunggakan</th>
                                        <th style="text-align: center">Cetak</th>
                                    </tr>
                                </thead>
                                <tbody id="TableTunggakan"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modal-close">Close</button>
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
                    <button type="button" class="btn btn-outline-primary btn-modal-close">Close</button>
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
        async function dataInstallations() {
            var result = await $.ajax({
                'url': '/dashboard/installations',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    return result
                }
            })

            return result;
        }

        async function dataUsages() {
            var result = await $.ajax({
                'url': '/dashboard/usages',
                'type': 'GET',
                'dataType': 'json',
                'success': function(result) {
                    return result
                }
            })

            return result;
        }

        async function dataTunggakan() {
            var result = await $.ajax({
                'url': '/dashboard/tunggakan',
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

        $(document).on('click', '#BtnModalInstalasi', async function(e) {
            e.preventDefault();
            var result = await dataInstallations();

            var Permohonan = result.Permohonan;
            var Pasang = result.Pasang;
            var Aktif = result.Aktif;

            $('#TablePermohonan').html('');
            Permohonan.forEach((item, index) => {
                $('#TablePermohonan').append(`
                    <tr>
                        <td>${item.kode_instalasi} ${item.package.kelas.charAt(0)}</td>
                        <td>${item.customer.nama}</td>
                        <td>${item.customer.alamat}</td>
                        <td>${item.package.kelas}</td>
                        <td>${item.order}</td>
                    </tr>
                `)
            })

            $('#TablePasang').html('');
            Pasang.forEach((item, index) => {
                $('#TablePasang').append(`
                    <tr>
                        <td>${item.kode_instalasi} ${item.package.kelas.charAt(0)}</td>
                        <td>${item.customer.nama}</td>
                        <td>${item.customer.alamat}</td>
                        <td>${item.package.kelas}</td>
                        <td>${item.order}</td>
                    </tr>
                `)
            })

            $('#TableAktif').html('');
            Aktif.forEach((item, index) => {
                $('#TableAktif').append(`
                    <tr>
                        <td>${item.kode_instalasi} ${item.package.kelas.charAt(0)}</td>
                        <td>${item.customer.nama}</td>
                        <td>${item.customer.alamat}</td>
                        <td>${item.package.kelas}</td>
                        <td>${item.aktif}</td>
                    </tr>
                `)
            })

            $('#ModalInstalasi').modal('toggle');
        });

        $(document).on('click', '#BtnModalPemakaian', async function(e) {
            e.preventDefault();
            var result = await dataUsages();
            var Pemakaian = result.Usages;

            var data = 0;
            var empty = 0;
            $('#TablePemakaian').html('');
            Pemakaian.forEach((item, index) => {
                if (item.one_usage == null) {
                    empty += 1;
                } else {
                    $('#TablePemakaian').append(`
                        <tr>
                            <td>${item.kode_instalasi} ${item.package.kelas.charAt(0)}</td>
                            <td>${item.customer.nama}</td>
                            <td>${item.package.kelas}</td>
                            <td>${item.one_usage.akhir}</td>
                        </tr>
                    `)
                }

                data += 1
            })

            if (data - empty == 0) {
                $('#TablePemakaian').append(`
                        <tr>
                            <td align="center" colspan="4">Tidak ada data pemakaian</td>
                        </tr>
                    `)
            }

            $('#ModalPemakaian').modal('toggle');
        });
        $(document).on('click', '#BtnModalTunggakan', async function(e) {
            e.preventDefault();
            var result = await dataTunggakan();
            var tunggakan = result.tunggakan;
            console.log(tunggakan);

            var data = 0;
            var empty = 0;
            $('#TableTunggakan').html('');

            tunggakan.forEach((item, index) => {
                // Tentukan tombol mana yang ditampilkan
                let stButton = '';
                let spButton = '';
                let spsButton = '';

                if (item.jumlah_tunggakan == 1) {
                    stButton = `
                        <a target="_blank"
                            href="/dashboard/Cetaktunggakan1/${item.id}"
                            class="btn btn-warning btn-sm" data-id="">
                            st
                        </a>`;
                } else if (item.jumlah_tunggakan == 2) {
                    spButton = `
                        <a target="_blank"
                            href="/dashboard/Cetaktunggakan2/${item.id}"
                            class="btn btn-danger btn-sm" data-id="">
                            sp
                        </a>`;
                } else if (item.jumlah_tunggakan > 2) {
                    spsButton = `
                        <a target="_blank"
                            href="/dashboard/sps/${item.id}"
                            class="btn btn-primary btn-sm" data-id="">
                            sps
                        </a>`;
                }

                $('#TableTunggakan').append(`
                    <tr>
                        <td>${item.kode_instalasi} ${item.package.kelas.charAt(0)}</td>
                        <td>${item.customer.nama} ( ${item.status_tunggakan})</td>
                        <td>${item.alamat}</td>
                        <td>${item.package.kelas}</td>
                        <td>${item.jumlah_tunggakan} Bulan</td>
                        <td class="text-center">
                            ${stButton}
                            ${spButton}
                            ${spsButton}
                        </td>
                    </tr>
                `);

                data += 1;
            });

            if (data - empty == 0) {
                $('#TableTunggakan').append(`
                    <tr>
                        <td align="center" colspan="4">Tidak ada data pemakaian</td>
                    </tr>
                `);
            }

            $('#ModalTunggakan').modal('toggle');
        });


        // $(document).on('click', '#BtnModalTunggakan', async function(e) {
        //     e.preventDefault();
        //     var result = await dataTunggakan();
        //     var tunggakan = result.tunggakan;
        //     console.log(tunggakan);

        //     var data = 0;
        //     var empty = 0;
        //     $('#TableTunggakan').html('');

        //     tunggakan.forEach((item, index) => {
        //         // Default warna tombol: abu-abu
        //         let stClass = 'btn-secondary';
        //         let spClass = 'btn-secondary';
        //         let spsClass = 'btn-secondary';

        //         // Terapkan logika warna sesuai jumlah tunggakan
        //         if (item.jumlah_tunggakan == 1) {
        //             stClass = 'btn-primary'; // ST biru
        //         } else if (item.jumlah_tunggakan == 2) {
        //             spClass = 'btn-primary'; // SP biru
        //         } else if (item.jumlah_tunggakan > 2) {
        //             spsClass = 'btn-primary'; // SPS biru
        //         }

        //         $('#TableTunggakan').append(`
    //             <tr>
    //                 <td>${item.kode_instalasi} ${item.package.kelas.charAt(0)}</td>
    //                 <td>${item.customer.nama} ( ${item.status_tunggakan})</td>
    //                 <td>${item.alamat}</td>
    //                 <td>${item.package.kelas}</td>
    //                 <td>${item.jumlah_tunggakan} Bulan</td>
    //                 <td class="text-center">
    //                     <a target="_blank"
    //                         href="/dashboard/Cetaktunggakan1/${item.id}"
    //                         class="btn ${stClass} btn-sm" data-id="">
    //                         st
    //                     </a>
    //                     <a target="_blank"
    //                         href="/dashboard/Cetaktunggakan2/${item.id}"
    //                         class="btn ${spClass} btn-sm" data-id="">
    //                         sp
    //                     </a>
    //                     <a target="_blank"
    //                         href="/dashboard/sps/${item.id}"
    //                         class="btn ${spsClass} btn-sm" data-id="">
    //                         sps
    //                     </a>
    //                 </td>
    //             </tr>
    //         `);

        //         data += 1;
        //     });

        //     if (data - empty == 0) {
        //         $('#TableTunggakan').append(`
    //             <tr>
    //                 <td align="center" colspan="4">Tidak ada data pemakaian</td>
    //             </tr>
    //         `);
        //     }

        //     $('#ModalTunggakan').modal('toggle');
        // });


        $(document).on('click', '#BtnModalTagihan', async function(e) {
            e.preventDefault();
            var result = await dataTagihan();
            var Tagihan = result.Tagihan;
            var setting = result.setting;
            var block = result.block

            $('#TableTagihan').html('');
            Tagihan.forEach((item, index) => {
                var paket = JSON.parse(item.installation.package.harga)

                var pesan_tagihan = ReplaceText(setting.pesan_tagihan, {
                    'customer': item.installation.customer.nama,
                    'desa': item.installation.customer.village.nama,
                    'kode_instalasi': item.installation.kode_instalasi,
                    'jatuh_tempo': formatDate(item.tgl_akhir),
                    'jumlah_tagihan': paket[block[item.jumlah]],
                    'user_login': '{{ Auth::user()->nama }}',
                    'telpon': '{{ Auth::user()->telpon }}'
                })

                $('#TableTagihan').append(`
                    <tr>
                        <td>
                            <input type="hidden" class="pesan" name="pesan_tagihan[]" value="${item.installation.customer.hp}||${pesan_tagihan}">
                            ${item.installation.kode_instalasi}
                        </td>
                        <td>${item.installation.customer.nama}</td>
                        <td>${item.tgl_akhir}</td>
                        <td>${item.jumlah}</td>
                        <td>${paket[block[item.jumlah]]}</td>
                    </tr>
                `)
            })

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

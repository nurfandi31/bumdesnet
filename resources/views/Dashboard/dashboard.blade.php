@extends('layout.base')

@section('content')
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
                                        <h6 class="font-extrabold mb-0 text-success">112.000</h6>
                                    </div>
                                </div>
                                <!-- Garis pemisah -->
                                <div class="col-12">
                                    <hr>
                                </div>
                                <!-- Link Lihat Detail -->
                                <div class="col-12" align="right">
                                    <a href="" class="text-primary"><b>Lihat Detail ></b></a>
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
                                        <h6 class="font-extrabold mb-0">112.000</h6>
                                    </div>
                                </div>
                                <!-- Garis pemisah -->
                                <div class="col-12">
                                    <hr>
                                </div>
                                <!-- Link Lihat Detail -->
                                <div class="col-12" align="right">
                                    <a href="" class="text-primary"><b>Lihat Detail ></b></a>
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
                                        <h6 class="font-extrabold mb-0">112.000</h6>
                                    </div>
                                </div>
                                <!-- Garis pemisah -->
                                <div class="col-12">
                                    <hr>
                                </div>
                                <!-- Link Lihat Detail -->
                                <div class="col-12" align="right">
                                    <a href="" class="text-primary"><b>Lihat Detail ></b></a>
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
                                        <h6 class="font-extrabold mb-0">112.000</h6>
                                    </div>
                                </div>
                                <!-- Garis pemisah -->
                                <div class="col-12">
                                    <hr>
                                </div>
                                <!-- Link Lihat Detail -->
                                <div class="col-12" align="right">
                                    <a href="" class="text-primary"><b>Lihat Detail ></b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Visit</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use xlink:href="/assets/static/images/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Pendapatan</h5>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <h5 class="mb-0 text-end">862</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-europe"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-success" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use xlink:href="/assets/static/images/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Beban</h5>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <h5 class="mb-0 text-end">375</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-america"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-success" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use xlink:href="/assets/static/images/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Surplus</h5>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <h5 class="mb-0 text-end">625</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-india"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Visit</h4>
                        </div>
                        <div class="card-body">
                            <div id="bar"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <br>
@endsection

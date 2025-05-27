<!DOCTYPE html>
<html lang="en">

<head>
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/ruang-admin-min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <link href="/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>
<style>
    .card-body form p {
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
</style>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                    </button>
                </nav>
                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">

                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Form Basic -->
                            <div class="card mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <table width="100%">
                                            <tr>
                                                <td>Nama</td>
                                                <td>: {{ $user->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td>: {{ $user->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <td>Telepon</td>
                                                <td>: {{ $user->telpon }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jabatan</td>
                                                <td>: {{ $user->position->nama_jabatan ?? 'Jabatan tidak tersedia' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Pengaturan Hak Akses Menu</h6>
                                </div>
                                <div class="card-body">
                                    <form action="/master/hakakses/{{ $user->id }}" method="POST">
                                        @csrf

                                        @php
                                            $akses_menu = json_decode($user->akses_menu, true);
                                        @endphp

                                        <input type="hidden" name="id_user" id="id_user" value="{{ $user->id }}">
                                        @foreach ($menu as $item)
                                            @php
                                                $check = !in_array($item->id, $akses_menu) ? 'checked' : '';
                                            @endphp
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="menu{{ $item->id }}" name="menu[]"
                                                        value="{{ $item->id }}" {{ $check }}>
                                                    <label class="custom-control-label"
                                                        for="menu{{ $item->id }}">{{ $item->title }}</label>
                                                </div>
                                                @if (!$item->child->isEmpty())
                                                    <div class="ml-4">
                                                        @foreach ($item->child as $child)
                                                            @php
                                                                $check = !in_array($child->id, $akses_menu)
                                                                    ? 'checked'
                                                                    : '';
                                                            @endphp
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="menu{{ $child->id }}" name="menu[]"
                                                                    value="{{ $child->id }}" {{ $check }}>
                                                                <label class="custom-control-label"
                                                                    for="menu{{ $child->id }}">{{ $child->title }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--Row-->
                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            @include('layouts.footer')
            <!-- Footer -->
        </div>
    </div>
    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @yield('modal')

    <form action="/logout" method="post" id="logoutForm">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/assets/vendor/chart.js/Chart.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugins -->
    <script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
</body>

</html>

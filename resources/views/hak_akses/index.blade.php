<!DOCTYPE html>
<html lang="en">

<head>
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/ruang-admin-min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <link href="/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css?v={{ time() }}">

</head>
{{-- <style>
    /* Mengatur margin dan padding tabel */
    #hakakses {
        margin: 0;
        padding: 0;
        border-collapse: collapse;
        /* Menghilangkan jarak antar border sel */
        width: 100%;
    }

    /* Mengatur padding pada header dan data sel */
    #hakakses th,
    #hakakses td {
        padding: 10px;
        /* Sesuaikan angka ini untuk mengatur jarak */
        text-align: left;
        border: 1px solid #ffffff;
        /* Opsional: menambah border untuk visualisasi */
    }

    /* Menghilangkan jarak atas dan bawah pada thead */
    #hakakses thead {
        margin: 1;
        padding: 1;
    }
</style> --}}

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="row">
                        <!-- Datatables -->
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="table-responsive p-3">
                                    <!-- Input Search -->
                                    <div class="mb-3">
                                        <input type="text" id="searchInput" class="form-control"
                                            placeholder="Cari Nama / Jabatan">
                                    </div>
                                    <table class="table align-items-center table-flush mt-4 mb-4" id="hakakses">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Business ID</th>
                                                <th>NAMA LENGKAP</th>
                                                <th>JABATAN</th>
                                                <th style="text-align: center;">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->business_id }}</td>
                                                    <td>{{ $user->nama }}</td>
                                                    <td>{{ $user->position->nama_jabatan ?? '' }}</td>
                                                    <td>
                                                        <div style="display: flex; gap: 5px; justify-content: center;">
                                                            <button type="button"
                                                                onclick="window.location.href='/master/hakakses/{{ $user->id }}'"
                                                                class="btn btn-success btn-sm">
                                                                DETAIL
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- JavaScript untuk Search -->
                    <script>
                        document.getElementById('searchInput').addEventListener('keyup', function() {
                            var searchText = this.value.toLowerCase();
                            var rows = document.querySelectorAll('#hakakses tbody tr');

                            rows.forEach(row => {
                                var nama = row.cells[0].textContent.toLowerCase();
                                var jabatan = row.cells[1].textContent.toLowerCase();

                                if (nama.includes(searchText) || jabatan.includes(searchText)) {
                                    row.style.display = '';
                                } else {
                                    row.style.display = 'none';
                                }
                            });
                        });
                    </script>

                    <!--Row-->
                </div>
                <!---Container Fluid-->
            </div>
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

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
</body>

</html>

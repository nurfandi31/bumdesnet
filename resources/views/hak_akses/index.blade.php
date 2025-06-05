<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'x' }}</title>
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="/assets/extensions/choices.js/public/assets/styles/choices.css">
    <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/table-datatable.css">
</head>

<style>
    /* Hover effect warna biru */
    #hakakses tbody tr:hover {
        background-color: #cce5ff;
        transition: background-color 0.2s ease-in-out;
    }
</style>

<body>
    <script src="/assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="pb-2">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-content">
                <!-- Row tampil data -->
                <div class="tab-content">
                    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                        <div class="main-card mb-3 card">
                            <div class="card-body p-3 pe-3 ps-3 pb-0 pt-3">
                                <div class="mb-3">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Cari Nama / Jabatan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="table-responsive p-3">
                                        <table class="table table-striped" id="hakakses">
                                            <thead class="thead-light alert-secondary">
                                                <tr>
                                                    <th>Business ID</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Alamat</th>
                                                    <th>No Telp</th>
                                                    <th>Jabatan</th>
                                                    <th style="text-align: center;">Status</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr onclick="window.location='/master/hakakses/{{ $user->id }}'"
                                                        style="cursor: pointer;">
                                                        <td>{{ $user->business_id }}</td>
                                                        <td>{{ $user->nama }}</td>
                                                        <td>{{ $user->alamat }}</td>
                                                        <td>{{ $user->telpon }}</td>
                                                        <td>{{ $user->position->nama_jabatan ?? '' }}</td>
                                                        <td align="center">
                                                            <span class="badge bg-success">Aktif</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            @include('Layout.footer')
        </div>

        @yield('modal')
        <form action="/logout" method="post" id="logoutForm">
            @csrf
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

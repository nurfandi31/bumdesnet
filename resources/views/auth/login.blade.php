<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/login/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/login/assets/img/favicon.png">
    <title>
        Login to {{ $business->nama }}
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="/login/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/login/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="/login/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />

    <style>
        @media (max-width: 768px) {
            .mobile-bg {
                background-image: url('{{ asset('/login/assets/img/bg-hp.png') }}');
                background-size: cover;
                background-position: center;
            }
        }
    </style>

</head>

<body class="">
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                                style="background-image: url('/login/assets/img/illustration.png'); background-size: cover;">
                            </div>
                        </div>
                        <div class="min-vh-100 d-flex align-items-center justify-content-center mobile-bg">
                            <div
                                class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                                <div class="card card-plain">
                                    <div class="card-header rounded-top rounded-bottom">
                                        <h3 class="font-weight-bolder text-center">Log in {{ $business->nama }}</h3>
                                        <p class="mb-0">Enter your email and password to register</p>
                                        <div class="card-body">
                                            <form class="login100-form validate-form user" action="{{ route('auth') }}"
                                                method="POST">
                                                @csrf
                                                <div class="input-group input-group-outline mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" id="username" name="username"
                                                        class="form-control">
                                                </div>
                                                <div class="input-group input-group-outline mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password" id="password"
                                                        class="form-control">
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit"
                                                        class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Sign
                                                        Up</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                            <p class="mb-2 text-sm mx-auto">
                                                © 2025 PT. Asta Brata Teknologi — 0001
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="/login/assets/js/core/popper.min.js"></script>
    <script src="/login/assets/js/core/bootstrap.min.js"></script>
    <script src="/login/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/login/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/login/assets/js/material-dashboard.min.js?v=3.2.0"></script>
    @if (Session::get('success'))
        <script>
            toastMixin.fire({
                title: "{{ Session::get('success') }}",
                icon: 'success',
            })
        </script>
    @endif
    @if (Session::get('error'))
        <script>
            toastMixin.fire({
                title: "{{ Session::get('error') }}",
                icon: 'error',
            })
        </script>
    @endif
</body>

</html>

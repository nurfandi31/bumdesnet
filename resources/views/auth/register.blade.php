<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Business Baru</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="/Login/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/Login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assets/vendor/fontawesome-free/css/all.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/Login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/Login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/Login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/Login/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/Login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/Login/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/Login/css/register.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="container">
        <div class="register-box">
            <h3 class="text-center mb-3">Sign Up</h3>
            <form class="pt-3" action="/register" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <i class="fas fa-business-time input-icon"></i>
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                placeholder="Nama Business" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <i class="fas fa-address-book input-icon"></i>
                            <input type="number" class="form-control" name="telpon" autocomplete="off"
                                placeholder="No. telpon" value="{{ old('telpon') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="gmail" class="form-control" name="email" autocomplete="off"
                                placeholder="Email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <i class="fas fa-address-card input-icon"></i>
                            <input type="text" class="form-control" name="alamat" autocomplete="off"
                                placeholder="Alamat" value="{{ old('alamat') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="file-label text-center">Upload Profile Picture</label>
                            <div class="custom-file d-flex justify-content-center">
                                <input type="file" class="custom-file-input" accept=".xls, .xlsx" name="file"
                                    id="fileInput" required>
                                <span class="custom-file-label" for="fileInput">Choose file</span>
                            </div>
                            @error('file')
                                <div class="w-100 text-center">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-register">Sign Up</button>
            </form>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="/Login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="/Login/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="/Login/vendor/bootstrap/js/popper.js"></script>
    <script src="/Login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="/Login/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="/Login/vendor/daterangepicker/moment.min.js"></script>
    <script src="/Login/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="/Login/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script>
        document.querySelector(".custom-file-input").addEventListener("change", function(event) {
            let fileName = event.target.files[0].name;
            let label = document.querySelector(".custom-file-label");
            label.textContent = fileName;
        });
    </script>
</body>

</html>

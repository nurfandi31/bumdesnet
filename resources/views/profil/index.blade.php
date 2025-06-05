@extends('Layout.base')
@php
    $logo = $user->foto;
    if ($logo == 'no_image.png') {
        $logo = '/assets/img/' . $logo;
    } else {
        $logo = '/storage/profil/' . $logo;
    }
@endphp
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
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <form action="/profil/data_login" method="post" id="FormDataLogin" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <img src="{{ $logo }}" alt="Users" id="select-image"
                                    class="rounded-circle p-1 bg-light"
                                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; cursor: pointer;">

                                <input type="file" name="profil-image" id="profil-image" class="d-none">
                                <h3 class="mt-3" align="center">{{ $user->nama }}</h3>
                                <p class="text-small">( {{ $user->position->nama_jabatan }} )</p>
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    value="{{ $user->username }}">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="konfirmasi_password"
                                    id="konfirmasi_password" placeholder="Konfirmasi Password">
                                <sup>(Kosongkan password jika tidak ingin diubah)</sup>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" id="BtnSimpanDataLogin" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body p-3 ps-3 pe-3 pb-3 pt-3">
                        <div class="row">
                            <div class="col-7 col-lg-9">
                                <label for=""><b>Tema Gelap</b></label>
                            </div>
                            <div class="col-5 col-lg-3">
                                <div class="d-flex align-items-center gap-3 mt-0 mt-md-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20"
                                        height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                                opacity=".3"></path>
                                            <g transform="translate(-210 -1)">
                                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                                <path
                                                    d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                    <div class="form-check form-switch fs-6">
                                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark"
                                            style="cursor: pointer">
                                        <label class="form-check-label" for="toggle-dark"></label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20"
                                        height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">

                                        <path fill="currentColor"
                                            d="m17.75 4.09-2.53 1.94.91 3.06-2.63-1.81-2.63 1.81.91-3.06-2.53-1.94L12.44 4l1.06-3 1.06 3 3.19.09m3.5 6.91-1.64 1.25.59 1.98-1.7-1.17-1.7 1.17.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95 2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14.4-.4.82-.76 1.27-1.08.75-.53 1.93.36 1.85 1.19-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82-2.81 3.14-2.7 7.96.31 10.98 3.02 3.01 7.84 3.12 10.98.31Z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="/profil" method="post" id="FormDataDiri">
                            @csrf

                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        value="{{ $user->nama }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="alamat" id="alamat"
                                        value="{{ $user->alamat }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telpon" class="col-sm-3 col-form-label">Telpon</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="telpon" id="telpon"
                                        value="{{ $user->telpon }}">
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-3 pt-0">Jenis Kelamin</legend>
                                    <div class="col-sm-9">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" {{ $user->jenis_kelamin == 'L' ? 'checked' : '' }}
                                                id="laki_laki" name="jenis_kelamin" class="custom-control-input"
                                                value="L">
                                            <label class="custom-control-label" for="laki_laki">Laki Laki</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" {{ $user->jenis_kelamin == 'P' ? 'checked' : '' }}
                                                id="perempuan" name="jenis_kelamin" class="custom-control-input"
                                                value="P">
                                            <label class="custom-control-label" for="perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row mb-0">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="button" id="BtnSimpanDataDiri" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection

@section('script')
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
    <script>
        $(document).on('click', '#BtnSimpanDataLogin', function(e) {
            e.preventDefault();

            var password = $('#password').val();
            var konfirmasi_password = $('#konfirmasi_password').val();

            if (password != konfirmasi_password && password != '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Konfirmasi password tidak sama',
                })
                return;
            } else {
                swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Semua perangkat yang login menggunakan akun ini akan otomatis logout!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, lanjutkan!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('#FormDataLogin');
                        $.ajax({
                            url: form.attr('action'),
                            type: 'post',
                            data: form.serialize(),
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: data.message,
                                    }).then((result) => {
                                        window.location.href = '/auth';
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: data.message,
                                    })
                                }
                            }
                        })
                    }
                })
            }
        })

        $(document).on('click', '#select-image', function() {
            $('#profil-image').trigger('click')
        })

        $(document).on('change', '#profil-image', function() {
            var file = $(this)[0].files[0];
            let formData = new FormData();
            formData.append("profil-image", file);
            formData.append("_token", $('input[name=_token]').val());

            $.ajax({
                type: 'post',
                url: '/profil/img',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function() {
                    var output = document.getElementById('select-image');
                    output.src = URL.createObjectURL(file);
                    output.onload = function() {
                        URL.revokeObjectURL(output.src);
                    }
                    toastMixin.fire({
                        title: "Selamat, Foto Berhasil diperbarui !",
                        icon: 'success',
                    })
                }
            });
        });

        $(document).on('click', '#BtnSimpanDataDiri', function(e) {
            e.preventDefault();

            var form = $('#FormDataDiri');
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                        })

                        $('.NamaUser').text(data.nama);
                        $('.AlamatUser').text(data.alamat);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                        })
                    }
                }
            })
        })
    </script>
@endsection

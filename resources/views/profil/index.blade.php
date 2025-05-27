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

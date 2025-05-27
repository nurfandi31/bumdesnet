@extends('layout.base')

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
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form action="/caters/{{ $cater->id }}" method="post" id="forcater">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input autocomplete="off" type="text" name="nama" id="nama"
                                                value="{{ $cater->nama }}" class="form-control">
                                            <small class="text-danger" id="msg_nama">{{ $errors->first('nama') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="select2 form-control" name="jenis_kelamin" id="jenis_kelamin">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option {{ $cater->jenis_kelamin == 'L' ? 'selected' : '' }} value="L">
                                                    Laki-Laki</option>
                                                <option {{ $cater->jenis_kelamin == 'P' ? 'selected' : '' }} value="P">
                                                    Perempuan</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="alamat">ALamat</label>
                                            <input autocomplete="off" type="text" name="alamat" id="alamat"
                                                value="{{ $cater->alamat }}" class="form-control">
                                            <small class="text-danger"
                                                id="msg_alamat">{{ $errors->first('alamat') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="telpon">No Telpon</label>
                                            <input autocomplete="off" type="text" name="telpon" id="telpon"
                                                value="{{ $cater->telpon }}" class="form-control">
                                            <small class="text-danger"
                                                id="msg_telpon">{{ $errors->first('telpon') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input autocomplete="off" type="text" name="username" id="username"
                                                value="{{ $cater->username }}" class="form-control">
                                            <small class="text-danger"
                                                id="msg_username">{{ $errors->first('username') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="password">Pasword</label>
                                            <input autocomplete="off" type="password" name="password" id="password"
                                                value="" class="form-control">
                                            <small class="text-danger"
                                                id="msg_password">{{ $errors->first('password') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" id="SimpanCater" class="btn btn-primary me-1 mb-1">Simpan
                                            Perubahan</button>
                                        <a href="/caters" class="btn btn-light-secondary me-1 mb-1">Kembali</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

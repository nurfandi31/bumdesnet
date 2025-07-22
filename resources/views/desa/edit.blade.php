@extends('Layout.base')

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
                    <div class="card-header">
                        <h4 class="card-title">Multiple Column</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="/villages/{{ $village->id }}" method="post" id="Formdesa">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="kode" id="kode" value="{{ $village->kode }}">

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="kode">Kode</label>
                                            <input autocomplete="off" maxlength="16" type="text" name="kode"
                                                id="kode" class="form-control" value="{{ $village->kode }}" disabled>
                                            <small class="text-danger" id="msg_kode">{{ $errors->first('kode') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="nama">Nama Desa</label>
                                            <input autocomplete="off" type="text" name="nama" id="nama"
                                                class="form-control" value="{{ $village->nama }}" required>
                                            <small class="text-danger" id="msg_nama">{{ $errors->first('nama') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="dusun">Dusun/Pedukuhan</label>
                                            <input type="text" name="dusun" id="dusun"
                                                value="{{ $village->dusun }}" class="form-control" required>
                                            <small class="text-danger" id="msg_dusun"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="hp">No Hp</label>
                                            <input type="text" name="hp" id="hp" value="{{ $village->hp }}"
                                                class="form-control"required>
                                            <small class="text-danger" id="msg_hp"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group mb-3">
                                            <label for="alamat">Alamat</label>
                                            <input autocomplete="off" type="text" name="alamat" id="alamat"
                                                class="form-control" value="{{ $village->alamat }}" required>
                                            <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="/villages" class="btn btn-secondary me-1 mb-1">Kembali</a>
                                        <button type="submit" id="SimpanDesa" class="btn btn-primary me-1 mb-1">Simpan
                                            Perubahan</button>
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

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
                            <form action="/villages" method="post" id="FormInputDesa">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="provinsi">provinsi</label>
                                            <select name="provinsi" id="provinsi" class=" choices form-control ">
                                                <option value="">Pilih Nama Provinsi</option>
                                                @foreach ($provinsi as $prov)
                                                    <option value="{{ $prov->kode }}">
                                                        {{ ucwords(strtolower($prov->nama)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="kabupaten">Kabupaten</label>
                                            <select name="kabupaten" id="kabupaten" class="choices form-control ">
                                                <option value="">Pilih Nama Kabupaten</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="provinsi">kecamatan</label>
                                            <select name="kecamatan" id="kecamatan" class="form-control choices">
                                                <option value="">Pilih Nama Kecamatan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="desa">Desa/Kalurahan</label>
                                            <select name="desa" id="desa" class="form-control choices">
                                                <option value="">Pilih Nama Desa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="dusun">Dusun/Pedukuhan</label>
                                            <input type="text" name="dusun" id="dusun" class="form-control">
                                            <small class="text-danger" id="msg_dusun"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="hp">No Hp</label>
                                            <input type="text" name="hp" id="hp" class="form-control">
                                            <small class="text-danger" id="msg_hp"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group mb-3">
                                            <label for="alamat">Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control" readonly></textarea>
                                            <small class="text-danger" id="msg_alamat"></small>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" id="Simpandesa" class="btn btn-primary me-1 mb-1">Simpan
                                            Desa</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
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

@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/villages';
        });

        $(document).on('change', '#provinsi', function() {
            var kode = $(this).val();
            $.get('/ambil_kab/' + kode, function(result) {
                if (result.success) {
                    setSelectValue('kabupaten', result.data);
                }
            });
        });

        $(document).on('change', '#kabupaten', function() {
            var kode = $(this).val();
            $.get('/ambil_kec/' + kode, function(result) {
                if (result.success) {
                    setSelectValue('kecamatan', result.data);
                }
            });
        });

        $(document).on('change', '#kecamatan', function() {
            var kode = $(this).val();
            $.get('/ambil_desa/' + kode, function(result) {
                if (result.success) {
                    setSelectValue('desa', result.data);
                }
            });
        });

        $(document).on('change', '#desa', function() {
            var kode = $(this).val();

            $("#alamat").val('');
            $.get('/set_alamat/' + kode, function(result) {
                if (result.success) {
                    $("#alamat").val(result.alamat);
                }
            });
        });

        function setSelectValue(id, data) {
            var label = ucwords(id);

            var selectValue = [{
                label: "Pilih " + label,
                value: '',
            }]

            data.forEach((val) => {
                selectValue.push({
                    label: val.nama,
                    value: val.kode
                })
            });

            choiceData[id].setValue(selectValue)
            choiceData[id].setChoiceByValue('')
        }

        function ucwords(str) {
            return str.replace(/\b\w/g, function(char) {
                return char.toUpperCase();
            });
        }

        //simpan
        $(document).on('click', '#Simpandesa', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormInputDesa');
            var actionUrl = form.attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Tambahkan Register Desa Baru?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Tambahkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/villages/';
                            }
                        });
                    }
                },
                error: function(result) {
                    const response = result.responseJSON;

                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');

                    if (response && typeof response === 'object') {
                        $.each(response, function(key, message) {
                            $('#' + key)
                                .closest('.input-group.input-group-static')
                                .addClass('is-invalid');

                            $('#msg_' + key).html(message);
                        });
                    }
                }
            });
        });
    </script>
@endsection

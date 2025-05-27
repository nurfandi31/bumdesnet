@extends('layout.base')
@section('content')
    <div class="container-fluid">
        <form action="/transactions/anggaran" method="post" id="FromAnggaran">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body ps-3 pe-3 pb-3 pt-3 p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="tahun">Tahun</label>
                                        <input class="form-control" type="number" autocomplete="off" name="tahun"
                                            id="tahun" value="{{ date('Y') }}">
                                        <small class="text-danger" id="msg_tahun"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="bulan">Bulan</label>
                                        <input class="form-control" type="number" autocomplete="off" name="bulan"
                                            id="bulan" value="{{ date('m') }}">
                                        <small class="text-danger" id="msg_bulan"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-primary" type="button" id="anggaran"
                                    style="float: right; margin-left: 10px;">
                                    <span class="text">Tentukan Rencana Anggaran</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div id="FormEbudgeting"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#nominal").maskMoney({
            allowNegative: true
        })

        $(document).on('click', '#anggaran', function(e) {
            e.preventDefault()

            var form = $('#FromAnggaran')
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        $('#FormEbudgeting').html(result.view)
                    }
                }
            })
        })

        $(document).on('click', '#SimpanAnggaran', function(e) {
            e.preventDefault();

            var form = $('#FormRencanaAnggaran');
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        toastMixin.fire({
                            title: result.msg // Menggunakan pesan dari controller
                        });
                        setTimeout(() => window.location.reload(), 3000);
                    }
                }
            });
        });
    </script>
@endsection

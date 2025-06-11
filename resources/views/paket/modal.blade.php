<div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <form action="/packages" method="post" id="modalPaket">
            @csrf

            @method('POST')
            <div class="modal-content">
                <div class="modal-header p-2 pe-3 pb-0 pt-3 ps-3">
                    <h4 class="modal-title"><b>Tentukan Harga Paket</b></h4>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <hr class="mb-2 mt-0">
                    <div class="row">
                        <div class="col-6">
                            <div class="position-relative mb-2">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input autocomplete="off" type="text" name="kelas" id="kelas"
                                    class="form-control form-control-sm">
                                <small class="text-danger" id="msg_kelas"></small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="position-relative mb-2">
                                <label for="harga" class="form-label harga">Harga</label>
                                <input autocomplete="off" type="text" name="harga" id="harga"
                                    class="form-control form-control-sm">
                                <small class="text-danger" id="msg_harga"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="position-relative mb-2">
                                <label for="abodemen" class="form-label abodemen">Abodemen</label>
                                <input autocomplete="off" type="text" name="abodemen" id="abodemen"
                                    class="form-control form-control-sm">
                                <small class="text-danger" id="msg_abodemen"></small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="position-relative mb-2">
                                <label for="denda" class="form-label denda">Denda</label>
                                <input autocomplete="off" type="text" name="denda" id="denda"
                                    class="form-control form-control-sm">
                                <small class="text-danger" id="msg_denda"></small>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-0">
                </div>
                <div class="modal-footer  p-2 pe-2 pb-2 pt-2 ps-2">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button class="btn btn-secondary btn-icon-split" type="submit" id="SimpanPaket"
                        class="btn btn-dark" style="float: right; margin-left: 10px;">
                        <span class="text" style="float: right;">Simpan Harga</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

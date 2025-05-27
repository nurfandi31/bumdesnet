<div class="card-body">
    <form action="/pengaturan/sop/lembaga" method="post" id="FromLembaga">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="position-relative mb-3">
                    <label for="nama">Nama Lembaga</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        value="{{ $business->nama }}">
                    <small class="text-danger" id="msg_nama"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="position-relative mb-3">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat"
                        value="{{ $business->alamat }}">
                    <small class="text-danger" id="msg_alamat"></small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="position-relative mb-3">
                    <label for="telpon">No Telepon</label>
                    <input type="text" class="form-control" id="telpon" name="telpon"
                        value="{{ $business->telpon }}">
                    <small class="text-danger" id="msg_telpon"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="position-relative mb-3">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" id="email" name="email"
                        value="{{ $business->email }}">
                    <small class="text-danger" id="msg_email"></small>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-dark btn-icon-split" type="button" id="SimpanLembaga" class="btn btn-dark"
                style="float: right; margin-left: 20px;">
                <span class="text" style="float: right;">Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

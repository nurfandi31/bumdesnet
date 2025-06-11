<div class="card-body">
    <form action="/pengaturan/sop/sistem_instal" method="post" id="FromInstal">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="position-relative mb-3">
                    <label for="batas_tagihan " class="mb-1">Toleransi Menunggak</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="batas_tagihan">Bulan</span>
                        <input type="number" class="form-control" id="batas_tagihan" name="batas_tagihan"
                            value="{{ $tampil_settings->batas_tagihan }}">
                    </div>
                    <small class="text-danger" id="msg_batas_tagihan"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="position-relative mb-3">
                    <label for="tanggal_toleransi " class="mb-1">Batas Tagihan Bulanan</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="tanggal_toleransi">Setiap
                            tanggal</span>
                        <input type="number" class="form-control" id="tanggal_toleransi" name="tanggal_toleransi"
                            value="{{ $tampil_settings->tanggal_toleransi }}">
                    </div>
                    <small class="text-danger" id="msg_tanggal_toleransi"></small>
                </div>
            </div>
        </div>
        <hr>
        <p style="text-align: justify;">
            Apabila Instalasi dengan Status <b>AKTIF</b> memiliki tagihan menunggakan sesuai toleransi menunggak, maka
            aplikasi
            akan secara otomatis merubah status Instalasi menjadi status <b>BLOKIR</b> dan sekaligus menjadi
            perintah untuk dilakukan penutupan sementara sampai dengan dilakukan pembayaran tunggakan ditambah biaya
            aktivasi ulang.</p>
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-dark btn-icon-split" type="button" id="SimpanInstal" class="btn btn-dark"
                style="float: right; margin-left: 20px;">
                <span class="text" style="float: right;">Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

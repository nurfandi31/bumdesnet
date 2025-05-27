<form action="/packages" method="post" id="FormRegisterRekening">
    @csrf

    <div class="modal fade custom-modal" id="RegisterRekening" tabindex="-1" role="dialog"
        aria-labelledby="RegisterRekeningLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="RegisterRekeningLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div align="right"class="modal-body">
                    <div align="right"class="form-group row">
                        <label for="kodeAkun" class="col-sm-3 col-form-label">KODE AKUN</label>
                        <div class="col-sm-9">
                            <input type="text" id="kodeAkun" name="kode_akun" class="form-control" required>
                        </div>
                    </div>                    
                    <div align="right"class="form-group row">
                        <label for="namaAkun" class="col-sm-3 col-form-label">NAMA AKUN</label>
                        <div class="col-sm-9">
                            <input type="text" id="namaAkun" name="nama_akun" class="form-control" required>
                        </div>
                    </div>
                    <div align="right"class="form-group row">
                        <label for="jenisMutasi" class="col-sm-3 col-form-label">JENIS MUTASI</label>
                        <div class="col-sm-9">
                            <select id="jenisMutasi" name="jenis_mutasi" class="form-control" required>
                                <option value="">Pilih Jenis Mutasi</option>
                                <option value="debet">Debet</option>
                                <option value="kredit">Kredit</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

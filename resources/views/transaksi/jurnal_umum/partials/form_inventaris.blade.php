@if ($relasi)
    <div class="col-md-4">
        <div class="position-relative mb-3">
            <label for="relasi">Relasi</label>
            <input autocomplete="off" type="text" name="relasi" id="relasi" class="form-control">
            <small class="text-danger" id="msg_relasi"></small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="position-relative mb-3">
            <label for="nama_barang">Nama Barang</label>
            <input autocomplete="off" type="text" name="nama_barang" id="nama_barang" class="form-control">
            <small class="text-danger" id="msg_nama_barang"></small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="position-relative mb-3">
            <label for="jumlah">Jml. Unit</label>
            <input autocomplete="off" type="number" name="jumlah" id="jumlah" value="0" class="form-control">
            <small class="text-danger" id="msg_jumlah"></small>
        </div>
    </div>
@else
    <div class="col-md-6">
        <div class="position-relative mb-3">
            <label for="nama_barang">Nama Barang</label>
            <input autocomplete="off" type="text" name="nama_barang" id="nama_barang" class="form-control">
            <small class="text-danger" id="msg_nama_barang"></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative mb-3">
            <label for="jumlah">Jml. Unit</label>
            <input autocomplete="off" type="number" name="jumlah" id="jumlah" value="0" class="form-control">
            <small class="text-danger" id="msg_jumlah"></small>
        </div>
    </div>
@endif
<div class="col-md-4">
    <div class="position-relative mb-3">
        <label for="harga_satuan">Harga Satuan</label>
        <input autocomplete="off" type="text" name="harga_satuan" id="harga_satuan"
            class="form-control angka_format">
        <small class="text-danger" id="msg_harga_satuan"></small>
    </div>
</div>
<div class="col-md-4">
    <div class="position-relative mb-3">
        <label for="umur_ekonomis">Umur Eko. (bulan)</label>
        <input autocomplete="off" type="number" name="umur_ekonomis" value="0" id="umur_ekonomis"
            class="form-control">
        <small class="text-danger" id="msg_umur_ekonomis"></small>
    </div>
</div>
<div class="col-md-4">
    <div class="position-relative mb-3">
        <label for="harga_perolehan">Harga Perolehan</label>
        <input autocomplete="off" type="text" readonly disabled name="harga_perolehan" value="0.00"
            id="harga_perolehan" class="form-control angka_format">
        <small class="text-danger" id="msg_harga_perolehan"></small>
    </div>
</div>

<script>
    //angka 00,000,00
    $(".angka_format").maskMoney({
        allowNegative: true
    });
</script>

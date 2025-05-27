@if ($relasi)
    <div class="col-md-6">
        <div class="position-relative mb-3">
            <label for="relasi">Relasi</label>
            <input type="text" class="form-control" id="relasi" name="relasi" style="height: 38px;">
            <small class="text-danger"></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative mb-3">
            <label for="keterangan">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan"
                value="{{ $keterangan_transaksi }}" style="height: 38px;">
            <small class="text-danger"></small>
        </div>
    </div>

    <div class="col-md-12">
        <div class="position-relative mb-3">
            <label for="nominal">Nominal Rp.</label>
            <input type="text" class="form-control" id="nominal" name="nominal" style="height: 38px;">
            <small class="text-danger"></small>
        </div>
    </div>
@else
    <input type="hidden" name="relasi" id="relasi" value="">
    <div class="col-md-12">
        <div class="position-relative mb-3">
            <label for="keterangan">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan"
                value="{{ $keterangan_transaksi }}" style="height: 38px;">
            <small class="text-danger"></small>
        </div>
    </div>
    <div class="col-md-12">
        <div class="position-relative mb-3">
            <label for="nominal">Nominal Rp.</label>
            <input type="text" class="form-control" id="nominal" name="nominal"
                value="{{ number_format($susut, 2) }}" style="height: 38px;">
            <small class="text-danger"></small>
        </div>
    </div>
@endif


<script>
    //angka 00,000,00
    $("#nominal").maskMoney({
        allowNegative: true
    });
</script>

<div class="col-md-6">
    <label for="harga">Biaya Berlangganan {{ $package->kelas }}</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control nominal" name="harga" id="harga" aria-describedby="basic-addon2"
            value="{{ number_format($package->harga, 2) }}" readonly>
    </div>
</div>
<div class="col-md-6">
    <label for="pasang_baru">Biaya pasang baru</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control nominal" name="pasang_baru" id="pasang_baru"
            aria-describedby="basic-addon2" value="{{ number_format($tampil_settings->pasang_baru, 2) }}"
            {!! $tampil_settings->swit_tombol == '1' ? 'readonly' : '' !!}>
    </div>
</div>
<div class="col-md-6">
    <label for="abodemen">Abodemen</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control nominal" name="abodemen" id="abodemen"readonly
            aria-describedby="basic-addon2" value="{{ number_format($package->abodemen, 2) }}">
    </div>
</div>
<div class="col-md-6">
    <label for="denda">Denda</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control"aria-describedby="basic-addon2" readonly
            value="{{ number_format($package->denda, 2) }}">
    </div>
</div>
<script>
    $(".nominal").maskMoney({
        allowNegative: true
    });

    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
        });
    });
</script>

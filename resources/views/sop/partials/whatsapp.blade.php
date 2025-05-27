<div class="card-body">
    <form action="/pengaturan/pesan_whatsapp" method="post" id="FormScanWhatsapp">
        @csrf
        @method('POST')

        <div class="row">
            <div class="col-md-6">
                <div class="position-relative mb-3">
                    <label for="tagihan">Pesan Tagihan</label>
                    <textarea class="form-control" name="tagihan" id="tagihan" cols="20" rows="10">{!! $tampil_settings->pesan_tagihan !!}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="position-relative mb-3">
                    <label for="pembayaran">Pesan Pembayaran</label>
                    <textarea class="form-control" name="pembayaran" id="pembayaran" cols="20" rows="10">{!! $tampil_settings->pesan_pembayaran !!}</textarea>
                </div>
            </div>
        </div>
    </form>
</div>

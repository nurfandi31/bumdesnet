@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
@endphp

<div class="row mb-3 d-none" id="RowBlock">
    <div class="col-md-6">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" name="nama[]" placeholder="Nama Blok">
    </div>
    <div class="col-md-6">
        <label for="jarak">Volume</label>
        <input type="text" class="form-control" name="jarak[]" placeholder="0 - 10 M3">
    </div>
</div>

<form action="/packages/block_paket" method="POST" id="Fromblock">
    @csrf

    <div class="container mt-4">
        <div id="inputFromblock">
            @for ($i = 0; $i < $jumlah_blok; $i++)
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama[]" value="{{ $blok[$i]['nama'] }}">
                    </div>
                    <div class="col-md-6">
                        <label for="jarak">Volume</label>
                        <input type="text" class="form-control" name="jarak[]" value="{{ $blok[$i]['jarak'] }}">
                    </div>
                </div>
            @endfor
        </div>
    </div>
    <div class="modal-footer">
        <a href="" class="btn btn-light" data-dismiss="modal">Close</a>
        <button class="btn btn-info btn-icon-split" type="button" id="blockinput" class="btn btn-dark">
            <span class="text" style="float: right;">Block</span>
        </button>
        <button class="btn btn-success btn-icon-split" type="button" id="SimpanBlock" class="btn btn-dark">
            <span class="text" style="float: right;">Simpan Perubahan</span>
        </button>
    </div>
</form>

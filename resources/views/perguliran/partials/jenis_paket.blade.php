@php
    $blok = json_decode($tampil_settings->block, true);
    $jumlah_blok = count($blok);
    $harga = json_decode($package->harga, true);
@endphp

<div class="row">
    {{-- Baris pertama, maksimal 4 item --}}
    @for ($i = 0; $i < min(4, $jumlah_blok); $i++)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-1000">
                <div class="card-body">
                    <h5 class="card-title">{{ $blok[$i]['nama'] }}</h5>
                    <p class="card-text">
                        <strong>Jarak:</strong> {{ $blok[$i]['jarak'] }}<br>
                        <strong>Harga:</strong>
                        <span class="badge bg-success">
                            Rp. {{ number_format(isset($harga[$i]) ? $harga[$i] : 0, 2) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    @endfor
</div>

{{-- Sisanya, tetap 4 per baris --}}
@for ($i = 4; $i < $jumlah_blok; $i++)
    @if (($i - 4) % 4 == 0)
        <div class="row">
    @endif

    <div class="col-md-3 mb-4">
        <div class="card shadow-sm h-1000">
            <div class="card-body">
                <h5 class="card-title">{{ $blok[$i]['nama'] }}</h5>
                <p class="card-text">
                    <strong>Jarak:</strong> {{ $blok[$i]['jarak'] }}<br>
                    <strong>Harga:</strong>
                    <span class="badge bg-success">
                        Rp. {{ number_format($harga[$i] ?? 0, 2) }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    @if (($i - 4) % 4 == 3 || $i == $jumlah_blok - 1)
        </div>
    @endif
@endfor

<div class="col-md-4">
    <label for="pasang_baru">Biaya pasang baru</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control nominal" name="pasang_baru" id="pasang_baru"
            aria-describedby="basic-addon2" value="{{ number_format($tampil_settings->pasang_baru, 2) }}"
            {!! $tampil_settings->swit_tombol == '1' ? 'readonly' : '' !!}>
    </div>
</div>
<div class="col-md-4">
    <label for="abodemen">Abodemen</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control nominal" name="abodemen" id="abodemen"readonly
            aria-describedby="basic-addon2" value="{{ number_format($package->abodemen, 2) }}">
    </div>
</div>
<div class="col-md-4">
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

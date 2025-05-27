<div class="col-md-6">
    <div class="position-relative mb-3">
        <label for="sumber_dana">Sumber Dana</label>
        <select class="form-control choices" name="sumber_dana" id="sumber_dana">
            <option value="">-- Pilih {{ $label1 }} --</option>
            @foreach ($rek1 as $r1)
                <option value="{{ $r1->id }}">
                    {{ $r1->kode_akun }}. {{ $r1->nama_akun }}
                </option>
            @endforeach
        </select>
        <small class="text-danger" id="msg_sumber_dana"></small>
    </div>
</div>

<div class="col-md-6">
    <div class="position-relative mb-3">
        <label for="disimpan_ke">{{ $label2 }}</label>
        <select class="form-control choices" name="disimpan_ke" id="disimpan_ke">
            <option value="">-- Pilih {{ $label2 }} --</option>
            @foreach ($rek2 as $r2)
                <option value="{{ $r2->id }}">
                    {{ $r2->kode_akun }}. {{ $r2->nama_akun }}
                </option>
            @endforeach
        </select>
        <small class="text-danger" id="msg_disimpan_ke"></small>
    </div>
</div>

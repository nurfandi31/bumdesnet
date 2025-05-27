    <div class="position-relative mb-3">
        <label for="sub_laporan">Nama Sub Laporan</label>
        <select class="choices form-control" name="sub_laporan" id="sub_laporan">
            @foreach ($sub_laporan as $sl)
                <option value="{{ $sl['value'] }}">{{ $sl['title'] }}</option>
            @endforeach
        </select>
        <small class="text-danger" id="msg_sub_laporan"></small>
    </div>

@php
    use App\Utils\Tanggal;

    $totalNominal = $usages->sum('nominal');
@endphp
<form action="/usages/cetak" method="post" id="FormCetakBuktiTagihan" target="_blank">
    @csrf
    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="table table-striped midle">
        <thead class="bg-dark text-white">
            <tr>
                <td align="center" width="40">
                    <div class="form-check text-center ps-0 mb-0">
                        <input class="form-check-input" type="checkbox" value="true" id="checked" name="checked">
                    </div>
                </td>
                <td align="center" width="100">Nama</td>
                <td align="center" width="100">No. Induk</td>
                <td align="center" width="100">Meter Awal</td>
                <td align="center" width="100">Meter Akhir</td>
                <td align="center" width="100">Pemakaian</td>
                <td align="center" width="100">Tagihan</td>
                <td align="center" width="100">Tanggal Akhir</td>
            </tr>
        </thead>

        @foreach ($usages as $use)
            <tbody>
                <tr>
                    <td align="center">
                        <div class="form-check text-center ps-0 mb-0">
                            <input class="form-check-input" type="checkbox" value="{{ $use->id }}"
                                id="{{ $use->id }}" name="cetak[]" data-input="checked">
                        </div>
                    </td>
                    <td align="left">{{ $use->customers->nama }}</td>
                    <td align="left">{{ $use->installation->kode_instalasi }}
                        {{ substr($use->installation->package->kelas, 0, 1) }}</td>
                    <td align="right">{{ $use->awal }}</td>
                    <td align="right">{{ $use->akhir }}</td>
                    <td align="right">{{ $use->jumlah }}</td>
                    <td align="right">{{ number_format($use->nominal, 2) }}</td>
                    <td align="center">{{ $use->tgl_akhir }}</td>
                </tr>
        @endforeach
        <tr>
            <td align="center"colspan="6"><b>Jumlah Tagihan Pemakaian</b></td>
            <td align="right">{{ number_format($totalNominal, 2) }}</td>
            <td align="center">&nbsp;</td>
        </tr>
        </tbody>
    </table>
    <script>
        $(document).on('click', '#checked', function() {
            if ($(this)[0].checked == true) {
                $('[data-input=checked]').prop('checked', true)
            } else {
                $('[data-input=checked]').prop('checked', false)
            }
        })
    </script>

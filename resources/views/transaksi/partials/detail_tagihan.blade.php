@php
    use App\Utils\Tanggal;

    $total_tagihan = 0;
    $total_denda = 0;
    $total_bayar = 0;
@endphp

<div class="section">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Kode Kuitansi</th>
                        <th>Tagihan</th>
                        <th>Jumlah Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($transaksi as $trx)
                        @php

                            if ($trx->rekening_debit == $akun_kas->id) {
                                $ref = $trx->rek_debit->kode_akun;
                                $debit = $trx->total;
                            } else {
                                $ref = $trx->kode_akun;
                                $debit = 0;
                            }
                            $tagihan = $trx->Usages->nominal ?? 0;
                            $denda = $trx->denda ?? 0;

                            $total_tagihan += $tagihan;
                            $total_denda += $denda;
                            $total_bayar += $debit;

                        @endphp

                        <tr>
                            <td align="center">{{ $loop->iteration }}.</td>
                            <td align="center">{{ Tanggal::tglIndo($trx->tgl_transaksi) }}</td>
                            <td>{{ $trx->keterangan }} ( {{ $trx->installations->id }} )</td>
                            <td align="center">{{ $trx->id }}</td>
                            <td align="right">{{ number_format($trx->total ?? 0, 2) }}</td>
                            <td align="right">{{ number_format($debit, 2) }}</td>
                            <td align="right">
                                <div class="d-flex align-items-center gap-1">
                                    <a href="/transactions/dokumen/struk_{{ $trx->usage_id == '0' ? 'instalasi' : 'tagihan' }}/{{ $trx->transaction_id }}"
                                        target="_blank" class="btn btn-info btn-sm" title="Cetak Struk">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-delete mt-0" data-id="{{ $trx->id }}"
                                        title="Hapus">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="4" align="center">
                            <b>Total Transaksi</b>
                        </td>
                        <td align="right">
                            <b>{{ number_format($total_tagihan, 2) }}</b>
                        </td>
                        <td align="right">
                            <b>{{ number_format($total_bayar, 2) }}</b>
                        </td>
                        <td align="right">
                            <b>&nbsp;</b>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function initializeBootstrapTooltip() {
        $('[data-toggle="tooltip"]').tooltip();
    }
</script>

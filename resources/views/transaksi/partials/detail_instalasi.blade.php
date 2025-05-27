@php
    use App\Utils\Tanggal;

    $total_tagihan = 0;
    $total_denda = 0;
    $total_bayar = 0;
@endphp
<div class="section">
    <div class="card">
        <div class="card-body">
            <table border="0" width="100%" cellspacing="0" cellpadding="0" class="table table-striped midle">
                <thead>
                    <tr>
                        <td height="40" align="center" width="40">No</td>
                        <td align="center" width="100">Tanggal</td>
                        <td align="center">Keterangan</td>
                        <td align="center" width="140">Kode Kuitansi.</td>
                        <td align="center" width="140">Tagihan</td>
                        <td align="center" width="140">Denda</td>
                        <td align="center" width="140">Jumlah Bayar</td>
                        <td align="center" width="170">Aksi</td>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($transaksi as $trx)
                        @php

                            if ($trx->rekening_debit) {
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
                            <td align="right">{{ number_format($trx->Usages->nominal ?? 0, 2) }}</td>
                            <td align="right">{{ number_format($trx->denda ?? 0, 2) }}</td>
                            <td align="right">{{ number_format($debit, 2) }}</td>
                            <td align="center">
                                <div class="dropdown dropleft">
                                    <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                        id="{{ $trx->id }}" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="{{ $trx->id }}">
                                        <a class="dropdown-item" target="_blank"
                                            href="/transactions/dokumen/struk_instalasi/{{ $trx->id }}">
                                            Struk Pasang Baru
                                        </a>
                                        <a class="dropdown-item" target="_blank"
                                            href="/transactions/dokumen/struk_tagihan/{{ $trx->id }}">
                                            Struk Tagihan
                                        </a>
                                    </div>
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $trx->id }}">
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
                            <b>{{ number_format($total_denda, 2) }}</b>
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

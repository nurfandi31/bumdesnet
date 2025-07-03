<!-- Tambahkan di atas semua CSS (jika belum) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<style>
    #datatable-tagihan th,
    #datatable-tagihan td {
        text-align: center !important;
        vertical-align: middle !important;
    }

    #datatable-tagihan input[type="checkbox"] {
        display: block;
        margin: auto;
    }
</style>
<form action="/dashboard/CetakTagihan" method="post" id="FormCetakBuktiTagihan" target="_blank">
    @csrf
    <input type="hidden" name="tgl_akhir" value="{{ request('tgl_akhir') ?? date('Y-m-d') }}">

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-tagihan" class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr class="text-center align-middle">
                            <th rowspan="2" style="width: 25px;" class="align-middle text-center p-0">
                                <input type="checkbox" id="checked_all" class="form-check-input d-block mx-auto">
                            </th>
                            <th rowspan="2" width="4%">No</th>
                            <th rowspan="2" width="23%">Nama</th>
                            <th rowspan="2" width="15%">No. Induk</th>
                            <th colspan="2" width="30%">Tagihan</th>
                            <th rowspan="2" width="19%">Jumlah Tagihan</th>
                            <th rowspan="2" width="10%">Kategori</th>
                        </tr>
                        <tr class="text-center align-middle">
                            <th width="15%">Bulan Lalu</th>
                            <th width="15%">Bulan Ini</th>
                        </tr>
                    </thead>
                    <tbody class="text-center align-middle">
                        @php $no = 1; @endphp
                        @foreach ($Tagihan as $ins)
                            @php
                                $tgl_toleransi = $ins->settings->tanggal_toleransi ?? '01';
                                $bulan_lalu = 0;
                                $bulan_ini = 0;
                                $jumlah_menunggak = 0;
                                $bayar = 0;

                                foreach ($ins->usage as $usage) {
                                    foreach ($usage->transaction as $trx) {
                                        $bulan_tagihan = date('Y-m', strtotime($usage->tgl_akhir)) . '-01';
                                        $bulan_kondisi = date('Y-m', strtotime($tgl_kondisi)) . '-01';
                                        $bulan_kondisi_lalu =
                                            date('Y-m', strtotime('-1 month', strtotime($bulan_kondisi))) . '-01';

                                        if ($trx->rekening_debit == $akun_piutang->id) {
                                            if ($bulan_tagihan < $bulan_kondisi_lalu) {
                                                // tidak ditampilkan
                                            } elseif ($bulan_tagihan < $bulan_kondisi) {
                                                $bulan_lalu += $trx->total;
                                            } else {
                                                $bulan_ini += $trx->total;
                                            }
                                        } else {
                                            $bayar += $trx->total;
                                        }
                                    }

                                    $jumlah_menunggak++;
                                }

                                $tunggakan = $bulan_lalu + $bulan_ini;

                                $status = 'Lancar';
                                if ($jumlah_menunggak > 0) {
                                    $status = 'Menunggak';
                                }
                                if ($jumlah_menunggak > 1) {
                                    $status = 'SP';
                                }
                                if ($jumlah_menunggak > 2) {
                                    $status = 'SPS';
                                }
                            @endphp

                            <tr>
                                <td>
                                    <input type="checkbox" name="id[]" value="{{ $ins->id }}"
                                        class="form-check-input d-block mx-auto">
                                </td>
                                <td>{{ $no++ }}</td>
                                <td>{{ $ins->customer->nama ?? '-' }}</td>
                                <td>{{ $ins->kode_instalasi }}</td>
                                <td align="right">{{ number_format($bulan_lalu, 2) }}</td>
                                <td align="right">{{ number_format($bulan_ini, 2) }}</td>
                                <td align="right">{{ number_format($tunggakan, 2) }}</td>
                                <td>{{ $ins->status_tunggakan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-sm btn-dark">
                <i class="fas fa-print me-1"></i> Cetak Daftar Tagihan
            </button>
            <button type="button" class="btn btn-sm btn-danger" onclick="history.back();">
                Tutup
            </button>

        </div>
    </div>
</form>




<!-- JS di bawah semua konten -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        const table = $('#datatable-tagihan').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            autoWidth: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
            }
        });

        // Centang semua saat halaman dibuka
        table.$('input[name="id[]"]').prop('checked', true);
        $('#checked_all').prop('checked', true);

        // Toggle semua saat klik master checkbox
        $('#checked_all').on('change', function() {
            const isChecked = this.checked;
            table.$('input[name="id[]"]').prop('checked', isChecked);
        });

        // Tangani submit form
        $('#FormCetakBuktiTagihan').on('submit', function(e) {
            // Hapus semua input hidden sebelumnya yang ditambahkan JS
            $(this).find('input[type="hidden"][data-generated="1"]').remove();

            // Loop semua checkbox di seluruh halaman (termasuk yg tidak kelihatan karena paging)
            table.$('input[type="checkbox"][name="id[]"]').each(function() {
                if (this.checked) {
                    // Tambahkan hidden input baru (bukan mengganti name jadi id_hidden ya)
                    $('<input>')
                        .attr({
                            type: 'hidden',
                            name: 'id[]',
                            value: this.value,
                            'data-generated': '1'
                        })
                        .appendTo('#FormCetakBuktiTagihan');
                }
            });
        });
    });
</script>

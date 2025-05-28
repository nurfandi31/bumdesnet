@php
    use App\Utils\Tanggal;

    $title_form = [
        1 => 'Kelembagaan',
        2 => 'Dana Sosial',
        3 => 'Bonus UPK',
        4 => 'Lain-lain',
    ];
@endphp

@extends('layout.base')

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $title ?? 'x' }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">DataTable</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div>&nbsp;</div>
    @if ($success)
        <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
            <span class="alert-icon align-middle">
                <span class="material-icons text-md">
                    thumb_up_off_alt
                </span>
            </span>
            <span class="alert-text">
                <strong>Tutup Buku Tahun {{ $tahun }}</strong> berhasil.
                Anda dapat melanjutkan proses pembagian laba di lain hari,
                klik <a href="/transactions/tutup_buku" class="fw-bold text-white">Disini</a>
                untuk kembali.
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card">
        <div class="card-body p-2 pe-2 pb-2 ps-2 pt-1">
            <h4 class="font-weight-normal mt-3">
                <div class="row">
                    <span class="col-sm-6"> &nbsp; Laba Tahun {{ Tanggal::tahun($tgl_kondisi) }}</span>
                    <span class="col-sm-6 text-end">Rp. {{ number_format($surplus, 2) }}</span>
                </div>
            </h4>

        </div>
    </div>
    <form action="/transactions/simpan_laba" method="post" id="SimpanAlokasiLaba">
        @csrf
        <input type="hidden" name="tgl_kondisi" id="tgl_kondisi" value="{{ $tgl_kondisi }}">

        <div class="row">
            <div class="col-md-12">
                <div class="position-relative mb-3">
                    <input type="hidden" name="surplus" id="surplus" value="{{ $surplus }}">
                    <div class="card">
                        <div class="card-body p-3">
                            <h5 class="font-weight-normal">
                                Alokasi Laba
                            </h5>

                            <div class="table-responsive mb-3">
                                <table class="table table-striped  ">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th class="text-white" width="50%">
                                                <span class="text-sm">
                                                    Laba Dibagikan
                                                </span>
                                            </th>
                                            <th class="text-white" width="50%">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-sm">Jumlah</span>
                                                    <span class="text-sm">
                                                        Rp. <span data-id="total_surplus_bersih">0,00</span>
                                                    </span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pembagian_surplus as $rek)
                                            <tr>
                                                <td>{{ $rek->nama_akun }}</td>
                                                <td>
                                                    <div class="input-group input-group-outline my-0">
                                                        <input type="text" name="surplus_bersih[{{ $rek->id }}]"
                                                            id="surplus_bersih_{{ $rek->id }}"
                                                            class="form-control nominal surplus_bersih form-control-sm text-end"
                                                            value="0.00">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <input type="hidden" class="total" name="total_surplus_bersih"
                                            id="total_surplus_bersih">
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive mb-3">
                                <table class="table table-striped">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th class="text-white" width="50%">
                                                <span class="text-sm">Laba Ditahan</span>
                                            </th>
                                            <th class="text-white" width="50%">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-sm">Jumlah</span>
                                                    <span class="text-sm">
                                                        Rp. <span data-id="total_laba_ditahan">
                                                            {{ number_format($surplus, 2) }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="total_laba_ditahan" id="total_laba_ditahan"
                                            class="form-control form-control-sm text-end" value="{{ $surplus }}">
                                        <tr>
                                            <td>Pemupukan modal</td>
                                            <td>
                                                <div class="input-group input-group-outline my-0">
                                                    <input type="text" name="laba_ditahan[3.2.01.01]" id="laba_ditahan"
                                                        class="form-control laba_ditahan form-control-sm text-end"
                                                        value="{{ number_format($surplus, 2) }}" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" id="kembali" class="btn btn-warning text-white">
                                    Kembali
                                </button>
                                <button type="button" id="btnSimpanLaba" class="btn btn-dark ms-2">
                                    Simpan Alokasi Laba
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).on('click', '#kembali', function(e) {
            e.preventDefault();
            window.location.href = '/transactions/tutup_buku';
        });


        $(".nominal").maskMoney({
            allowNegative: true
        });

        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })

        $(document).on('change', '.cadangan_resiko', function(e) {
            var total = 0;
            $('.cadangan_resiko').map(function() {
                var value = $(this).val()
                if (value == '') {
                    value = 0
                } else {
                    value = value.split(',').join('')
                    value = value.split('.00').join('')
                }

                value = parseFloat(value)

                total += value
            })

            $('#total_cadangan_resiko').val(formatter.format(total)).trigger('change')
            $('[data-id=total_cadangan_resiko]').html(formatter.format(total))
        })

        $(document).on('change', '.surplus_bersih', function(e) {
            var total = 0;
            $('.surplus_bersih').map(function() {
                var value = $(this).val()
                if (value == '') {
                    value = 0
                } else {
                    value = value.split(',').join('')
                    value = value.split('.00').join('')
                }

                value = parseFloat(value)

                total += value
            })

            $('#total_surplus_bersih').val(formatter.format(total)).trigger('change')
            $('[data-id=total_surplus_bersih]').html(formatter.format(total))
        })

        $(document).on('change', '.total', function(e) {
            var total = 0;
            $('.total').map(function() {
                var value = $(this).val()
                if (value == '') {
                    value = 0
                } else {
                    value = value.split(',').join('')
                    value = value.split('.00').join('')
                }

                value = parseFloat(value)

                total += value
            })

            var surplus = $('#surplus').val()
            surplus = surplus.split(',').join('')
            surplus = surplus.split('.00').join('')

            var sisa_surplus = surplus - total

            $('#total_laba_ditahan').val(formatter.format(sisa_surplus))
            $('#laba_ditahan').val(formatter.format(sisa_surplus))
            $('[data-id=total_laba_ditahan]').html(formatter.format(sisa_surplus))
        })
        $(document).on('click', '#btnSimpanLaba', function(e) {
            e.preventDefault()

            var form = $('#SimpanAlokasiLaba')
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Swal.fire('Selamat', result.msg, 'success').then(() => {
                            // window.location.href = '/transaksi/tutup_buku'
                        })
                    }
                }
            })
        })
    </script>
@endsection

@extends('Layout.base')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data table</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <br>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive responsive p-2">
                        <table class="table table-striped table-hover" id="permohonan">
                            <thead>
                                <tr>
                                    <th>No.Induk</th>
                                    <th>Pelanggan</th>
                                    <th>alamat</th>
                                    <th>Nomor HP</th>
                                    <th>Email</th>
                                    <th>Tanggal Order</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        let table = setAjaxDatatable('#permohonan', '{{ url('/installations/permohonan') }}', [{
                data: 'kode_instalasi',
                name: 'kode_instalasi'
            },
            {
                data: 'customer.nama',
                name: 'customer.nama'
            },
            {
                data: 'village.nama',
                name: 'village.nama'
            },
            {
                data: 'customer.hp',
                name: 'customer.hp'
            },
            {
                data: 'customer.email',
                name: 'customer.email'
            },
            {
                data: 'order',
                name: 'order'
            }, {
                data: 'status',
                name: 'status',
                render: function(data, type, row, meta) {
                    if (data == 'R') {
                        return '<span class="badge bg-success">Paid</span>';
                    } else if (data == '0') {
                        return 'span class="badge bg-danger">Unpaid</span>';
                    }
                }
            }
        ]);

        $(document).on('change', '.set-table', function() {
            table.ajax.reload();
        });

        $('#permohonan').on('click', 'tbody tr', function() {
            var data = table.row(this).data();
            if (data && data.id) {
                Swal.fire({
                    title: `sedang menyiapkan data...`,
                    html: `
                        <div style="margin-top: 0px; text-align: center;">
                            <img src="data:image/svg+xml,%3c!--%20By%20Sam%20Herbert%20(@sherb),%20for%20everyone.%20--%3e%3csvg%20width='55'%20height='80'%20viewBox='0%200%2055%2080'%20xmlns='http://www.w3.org/2000/svg'%20fill='%235d79d3'%3e%3cg%20transform='matrix(1%200%200%20-1%200%2080)'%3e%3crect%20width='10'%20height='20'%20rx='3'%3e%3canimate%20attributeName='height'%20begin='0s'%20dur='1.2s'%20values='20;80;20'%20repeatCount='indefinite'/%3e%3c/rect%3e%3crect%20x='15'%20width='10'%20height='50'%20rx='3'%3e%3canimate%20attributeName='height'%20begin='0.2s'%20dur='1.2s'%20values='50;80;50'%20repeatCount='indefinite'/%3e%3c/rect%3e%3crect%20x='30'%20width='10'%20height='30'%20rx='3'%3e%3canimate%20attributeName='height'%20begin='0.4s'%20dur='1.2s'%20values='30;80;30'%20repeatCount='indefinite'/%3e%3c/rect%3e%3crect%20x='45'%20width='10'%20height='60'%20rx='3'%3e%3canimate%20attributeName='height'%20begin='0.6s'%20dur='1.2s'%20values='60;80;60'%20repeatCount='indefinite'/%3e%3c/rect%3e%3c/g%3e%3c/svg%3e"
                                style="width: 40px; display: block; margin: 0 auto 15px auto;">
                            <p style="margin: 0; font-size: 14px; color: #555;">Mohon tunggu sebentar</p>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });

                setTimeout(() => {
                    window.location.href = '/installations/' + data.id;
                }, 900);
            }
        });
    </script>
@endsection

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
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No.Induk</th>
                                <th>Customer</th>
                                <th>alamat</th>
                                <th>Nomor HP</th>
                                <th>Email</th>
                                <th>Tanggal Order</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Status_Aktif as $status_A)
                                <tr onclick="handleRowClick('{{ $status_A->id }}')" style="cursor: pointer;">
                                    <td>{{ $status_A->kode_instalasi }}
                                        {{ $status_A->package ? substr($status_A->package->kelas, 0, 1) : '-' }}
                                    </td>
                                    <td>{{ $status_A->customer ? $status_A->customer->nama : '' }}</td>
                                    <td>{{ $status_A->village ? $status_A->village->nama : '' }}</td>
                                    <td>{{ $status_A->customer ? $status_A->customer->hp : '' }}</td>
                                    <td>{{ $status_A->customer ? $status_A->customer->email : '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($status_A->order)->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $status_A->status_tunggakan }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleRowClick(id) {
        Swal.fire({
            title: 'Sedang menyiapkan data...',
            html: `
        <div style="margin-top: 10px; text-align: center;">
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
            window.location.href = '/installations/' + id;
        }, 900);
    }
</script>

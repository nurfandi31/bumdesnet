@extends('layout.base')
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
                            @foreach ($Status_Permohonan as $status_R)
                                <tr onclick="window.location='/installations/{{ $status_R->id }}'" style="cursor: pointer;">
                                    <td>{{ $status_R->kode_instalasi }} {{ substr($status_R->package->kelas, 0, 1) }}</td>
                                    <td>{{ $status_R->customer ? $status_R->customer->nama : '' }}</td>
                                    <td>{{ $status_R->village ? $status_R->village->nama : '' }}</td>
                                    <td>{{ $status_R->customer ? $status_R->customer->hp : '' }}</td>
                                    <td>{{ $status_R->customer ? $status_R->customer->email : '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($status_R->order)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($status_R->status === 'R')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($status_R->status === '0')
                                            <span class="badge bg-warning">Unpaid</span>
                                        @endif
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

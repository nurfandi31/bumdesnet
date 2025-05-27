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
                            @foreach ($Status_Blokir as $status_B)
                                <tr onclick="window.location='/installations/{{ $status_B->id }}'" style="cursor: pointer;">
                                    <td>{{ $status_B->kode_instalasi }} {{ substr($status_B->package->kelas, 0, 1) }}</td>
                                    <td>{{ $status_B->customer ? $status_B->customer->nama : '' }}</td>
                                    <td>{{ $status_B->village ? $status_B->village->nama : '' }}</td>
                                    <td>{{ $status_B->customer ? $status_B->customer->hp : '' }}</td>
                                    <td>{{ $status_B->customer ? $status_B->customer->email : '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($status_B->order)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($status_B->status === 'B')
                                            <span class="badge bg-warning">Blokir</span>
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

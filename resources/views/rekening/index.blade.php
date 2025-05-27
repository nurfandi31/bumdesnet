@extends('layouts.base')

@section('content')
    <!-- Datatables -->
    {{-- <div class="col-lg-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <!-- Bagian kiri: Rekening -->
            <div style="display: flex; align-items: center;">
                <i class="far fa-credit-card" style="font-size: 20px; margin-right: 5px;"></i>
                <b>Rekening</b>
            </div>
            <!-- Bagian kanan: Tombol -->
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#RegisterRekening" id="#myBtn">
                    Register Rekening
                </button>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="TbRekening">
                        <div style="display: flex; align-items: center;">
                            <i class="far fa-credit-card" style="font-size: 20px; margin-right: 5px;"></i>
                            <b>Rekening</b>
                        </div>
                        <div>&nbsp;</div>
                        <thead class="thead-light" align="center">
                            <tr>
                                <th>KODE AKUN</th>
                                <th>NAMA AKUN</th>
                                <th>JENIS MUTASI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekening as $rek)
                                <tr>
                                    <td>{{ $rek->kode_akun }}</td>
                                    <td>{{ $rek->nama_akun }}</td>
                                    <td>{{ $rek->jenis_mutasi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#TbRekening').DataTable(); // ID From dataTable 
        });
    </script>
@endsection

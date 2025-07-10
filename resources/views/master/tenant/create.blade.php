@extends('master.layouts.base', [
    'pageTitle' => 'Tambah Tenant',
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="/tenant" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_tenant">Nama Tenant</label>
                            <input type="text" id="nama_tenant" class="form-control" name="nama_tenant"
                                placeholder="Nama Tenant" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="domain">Domain</label>
                            <input type="text" id="domain" class="form-control" name="domain" placeholder="Domain"
                                autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mb-1">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("input#nama_tenant").on({
            keydown: function(e) {
                if (e.which === 32)
                    return false;
            },
            change: function() {
                this.value = this.value.replace(/\s/g, "");
            }
        });
    </script>
@endsection

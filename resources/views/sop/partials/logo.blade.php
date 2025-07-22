<div class="card-body">
    <div class="row">
        <div class="col-md-12 mt-4" data-animation="true">
            <a class="d-block blur-shadow-image">
                <img src="{{ asset('storage/logo/' . Session::get('logo')) }}" alt="Logo saat ini"
                    class="img-fluid shadow border-radius-lg mt-3 previewLogo" id=""
                    style="width: 130px; height: auto; margin-left: 20px;">
            </a>

            <div class="colored-shadow"
                style="background-image: url('{{ asset('storage/logo/' . Session::get('logo')) }}');">
            </div>

            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-primary border-0" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="Edit Logo" id="EditLogo">
                    <i class="fa fa-edit text-lg"></i>&nbsp;Edit Logo
                </button>
            </div>
        </div>
    </div>

    <form action="/pengaturan/sop/logo/{{ $business->id }}" method="post" enctype="multipart/form-data" id="FormLogo">
        @csrf
        @method('PUT')
        <input type="file" name="logo_busines" id="logo_busines" class="d-none">
    </form>
</div>

@php
    $logo = $user->foto;
    if ($logo == 'no_image.png') {
        $logo = '/assets/img/' . $logo;
    } else {
        $logo = '/storage/profil/' . $logo;
    }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'x' }}</title>
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="/assets/extensions/choices.js/public/assets/styles/choices.css">
    <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/table-datatable.css">
</head>

<style>
    /* Hover effect warna biru */
    #hakakses tbody tr:hover {
        background-color: #cce5ff;
        transition: background-color 0.2s ease-in-out;
    }
</style>

<body>
    <script src="/assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="pb-2">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-content">
                <div>&nbsp;</div>
                <section class="section">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body p-2 pb-0 pt-2 ps-3 pe-2">
                                    <h3 class="text-center bold">Pengaturan Hak Akses</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" method="post" id="" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex justify-content-center align-items-center flex-column">
                                            <img src="{{ $logo }}" alt="Users" id="select-image"
                                                class="rounded-circle p-1 bg-light"
                                                style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; cursor: pointer;">
                                            <h3 class="mt-3" align="center">{{ $user->nama }}</h3>
                                            <p class="text-small">( {{ $user->position->nama_jabatan }} )</p>
                                        </div>

                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input class="form-control" value="{{ $user->alamat }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>No Telp</label>
                                            <input class="form-control" value="{{ $user->telpon }}" disabled>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-9">
                            <div class="card">
                                <div class="card-body">
                                    <form action="/master/hakakses/{{ $user->id }}" method="POST">
                                        @csrf

                                        @php
                                            $akses_menu = json_decode($user->akses_menu, true);
                                        @endphp

                                        <input type="hidden" name="id_user" id="id_user" value="{{ $user->id }}">
                                        @foreach ($menu as $item)
                                            @php
                                                $check = !in_array($item->id, $akses_menu) ? 'checked' : '';
                                            @endphp
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="menu{{ $item->id }}" name="menu[]"
                                                        value="{{ $item->id }}" {{ $check }}>
                                                    <label class="custom-control-label"
                                                        for="menu{{ $item->id }}">{{ $item->title }}</label>
                                                </div>
                                                @if (!$item->child->isEmpty())
                                                    <div class="ml-4">
                                                        @foreach ($item->child as $child)
                                                            @php
                                                                $check = !in_array($child->id, $akses_menu)
                                                                    ? 'checked'
                                                                    : '';
                                                            @endphp
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="menu{{ $child->id }}" name="menu[]"
                                                                    value="{{ $child->id }}" {{ $check }}>
                                                                <label class="custom-control-label"
                                                                    for="menu{{ $child->id }}">{{ $child->title }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                        <div class="form-group row mb-0">
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <br><br>
        @include('Layout.footer')
    </div>
    </div>
</body>

</html>

<style>
    #floatingButtons {
        transition: all 0.3s ease-in-out;
    }

    #floatingButtons.fixed {
        position: fixed;
        top: 10px;
        left: 20px;
        right: 20px;
        z-index: 100;
    }

    @media (min-width: 768px) {
        #floatingButtons.fixed {
            left: 80px;
            right: 80px;
        }
    }

    @media (min-width: 1200px) {
        #floatingButtons.fixed {
            left: 320px;
            right: 20px;
        }
    }

    @media (max-width: 768px) {
        .btn-group-responsive {
            justify-content: center !important;
            flex-wrap: wrap;
        }

        .btn-group-responsive button {
            margin: 4px 2px;
        }
    }

    .btn-group-responsive button {
        margin-inline: 0.5rem;
    }

    .modal-dialog {
        max-width: 800px;
    }

    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 95%;
        }
    }

    ul.text-muted li {
        margin-bottom: 12px;
    }
</style>
@php
    $logo = Session::get('logo');
    if ($logo == 'no_image.png') {
        $logo = '/assets/img/' . $logo;
    } else {
        $logo = '/storage/logo/' . $logo;
    }

    $userlogo = Session::get('userlogo');
    if ($userlogo == 'no_image.png') {
        $userlogo = '/assets/img/' . $userlogo;
    } else {
        $userlogo = '/storage/profil/' . $userlogo;
    }
@endphp
<div id="floatingButtons" class="transition-all">
    <section class="basic-choices position-relative">
        <div class="row">
            <div class="col-12 position-relative">
                <div class="card mb-0 border-0 shadow-none">
                    <div class="card-content">
                        <div class="card-body pb-3 pt-3 ps-3 pe-3">
                            <div class="row align-items-center d-flex justify-content-between">
                                <div class="col-auto">
                                    <button
                                        class="burger-btn d-block d-xl-none btn btn-outline-primary btn-sm rounded-circle"
                                        title="Menu">
                                        <i class="bi bi-list"></i>
                                    </button>

                                    <div
                                        class="d-flex justify-content-between align-items-start flex-wrap d-none d-xl-inline">
                                        <div class="d-flex align-items-center flex-grow-1 me-2" style="min-width: 0;">
                                            <div style="width: 40px; height: 40px; margin-right: 15px; flex-shrink: 0;">
                                                <img src="{{ $logo }}" alt="User Avatar"
                                                    style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid #b8b8b8;">
                                            </div>

                                            <div class="d-flex flex-column bold">
                                                <div class="text-break text-bold">
                                                    <b style="font-size: 16px">{{ Session::get('nama_usaha') }},
                                                        {{ Session::get('describe') }}</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-end btn-group-responsive">
                                    <button onclick="location.href='/profil'"
                                        class="btn btn-outline-primary btn-sm rounded-circle" title="Profil">
                                        <i class="bi bi-person-circle"></i>
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm rounded-circle"
                                        title="Panduan Aplikasi">
                                        <i class="bi bi-info-circle"></i>
                                    </button>
                                    <button data-bs-toggle="modal" data-bs-target="#Ts/Invoice"
                                        class="btn btn-outline-info btn-sm rounded-circle" title="Ts dan Invoice">
                                        <i class="bi bi-envelope"></i>
                                    </button>
                                    <button id="logoutButton" class="btn btn-outline-danger btn-sm rounded-circle"
                                        title="Logout">
                                        <i class="bi bi-box-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="Ts/Invoice" tabindex="-1" aria-labelledby="Ts/InvoiceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Ts/InvoiceLabel">Ts dan Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center">
                        <img src="../../assets/static/images/logo/user.png" alt="Preview" class="img-fluid rounded">
                    </div>
                    <div class="col-md-8">
                        <h3 class="fw-bold text-center mb-2" style="font-size: 28px;">TECHNICAL SUPPORT</h3>
                        <h4 class="fw-bold text-center mb-4" style="font-size: 22px;">0882-0066-44656</h4>
                        <ul class="text-muted" style="font-size: 14px;">
                            <li>
                                Jika terdapat kendala teknis, silahkan menghubungi Technical Support kami melalui
                                WhatsApps ke nomor diatas.
                                Dimohon menggunakan bahasa yang mudah dipahami dan tidak menyulitkan.
                            </li>
                            <li>
                                Regristasikan terlebih dahulu Nomor Bapak/Ibu dengan cara ketik :<br>
                                <strong> {{ Session::get('nama_usaha') }}</strong>
                            </li>
                            <li>
                                Jika permasalahan berkaitan dengan transaksi, sertakan No.Induk Pelanggan Transaksi yang
                                dimaksud.
                            </li>
                        </ul>
                        <p class="text-end fw-bold mt-4">Team Technical Support</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('scroll', function() {
        const el = document.getElementById('floatingButtons');
        if (window.scrollY > 10) {
            el.classList.add('fixed');
        } else {
            el.classList.remove('fixed');
        }
    });
</script>
<br>

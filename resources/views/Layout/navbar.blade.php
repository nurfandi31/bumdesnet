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
            left: 290px;
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

    ul.text-muted li {
        margin-bottom: 12px;
    }
</style>

@php
    $logo =
        Session::get('logo') === 'no_image.png' ? '/assets/img/no_image.png' : '/storage/logo/' . Session::get('logo');

    $userlogo =
        Session::get('userlogo') === 'no_image.png'
            ? '/assets/img/no_image.png'
            : '/storage/profil/' . Session::get('userlogo');
@endphp

<div id="floatingButtons" class="transition-all">
    <section class="basic-choices position-relative">
        <div class="card mb-0 border-0 shadow-none">
            <div class="card-body pb-3 pt-3 ps-3 pe-3">
                <div class="row align-items-center">
                    <div class="col-12 d-flex flex-wrap flex-md-nowrap justify-content-between align-items-center gap-2">
                        <div class="col-auto">
                            <button class="burger-btn d-block btn btn-outline-primary btn-sm rounded-circle"
                                title="Menu">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                        <div class="d-flex align-items-center justify-content-end flex-wrap gap-3 ms-auto">
                            <div class="d-flex align-items-center gap-3">
                                <a href="#" title="Panduan Aplikasi" class="text-warning">
                                    <i class="fas fa-lightbulb fa-lg"></i>
                                </a>
                                <a href="/pengaturan/coa" title="Chart Of Account (CoA)" class="text-danger">
                                    <i class="fas fa-file-invoice-dollar fa-lg"></i>
                                </a>
                                <a href="/packages" title="Paket Mbps" class="text-success">
                                    <i class="fas fa-wifi fa-lg"></i>
                                </a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#Ts/Invoice"
                                    title="TS dan Invoice" class="text-secondary">
                                    <i class="fas fa-comment-dots fa-lg"></i>
                                </a>
                            </div>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown">
                                    <div class="d-flex align-items-center">
                                        <div class="text-end me-3 d-none d-sm-block">
                                            <h6 class="mb-0 text-gray-600">{{ Session::get('nama') }}</h6>
                                            <p class="mb-0 text-sm text-gray-600">{{ Session::get('jabatan') }}</p>
                                        </div>
                                        <div class="avatar avatar-md">
                                            <img src="{{ $userlogo }}" alt="User Avatar">
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" style="min-width: 11rem;">
                                    <li>
                                        <h6 class="dropdown-header">Manage Your Account</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="/profil"><i class="bi bi-person me-2"></i> My
                                            Profile</a></li>
                                    <li><a class="dropdown-item" href="/pengaturan"><i class="bi bi-gear me-2"></i>
                                            Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#" id="logoutButton"><i
                                                class="bi bi-box-arrow-left me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="Ts/Invoice" tabindex="-1" aria-labelledby="Ts/InvoiceLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;">
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
                            <li>Jika terdapat kendala teknis, silahkan menghubungi Technical Support kami melalui
                                WhatsApps ke nomor diatas. Dimohon menggunakan bahasa yang mudah dipahami dan tidak
                                menyulitkan.</li>
                            <li>Regristasikan terlebih dahulu Nomor Bapak/Ibu dengan cara ketik
                                :<br><strong>{{ Session::get('nama_usaha') }}</strong></li>
                            <li>Jika permasalahan berkaitan dengan transaksi, sertakan No.Induk Pelanggan Transaksi yang
                                dimaksud.</li>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<script>
    document.addEventListener('scroll', () => {
        document.getElementById('floatingButtons').classList.toggle('fixed', window.scrollY > 10);
    });
</script>

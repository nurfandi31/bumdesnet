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
        Session::get('logo') === 'default.png' ? '/assets/img/default.png' : '/storage/logo/' . Session::get('logo');

    $userlogo =
        Session::get('userlogo') === 'default.png'
            ? '/assets/img/default.png'
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
                            <div class="d-flex align-items-center gap-1 mt-0 mt-md-0">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20"
                                    height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                            opacity=".3"></path>
                                        <g transform="translate(-210 -1)">
                                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                            <circle cx="220.5" cy="11.5" r="4"></circle>
                                            <path
                                                d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input me-0" type="checkbox" id="toggle-dark"
                                        style="cursor: pointer">
                                    <label class="form-check-label" for="toggle-dark"></label>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20"
                                    height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">

                                    <path fill="currentColor"
                                        d="m17.75 4.09-2.53 1.94.91 3.06-2.63-1.81-2.63 1.81.91-3.06-2.53-1.94L12.44 4l1.06-3 1.06 3 3.19.09m3.5 6.91-1.64 1.25.59 1.98-1.7-1.17-1.7 1.17.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95 2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14.4-.4.82-.76 1.27-1.08.75-.53 1.93.36 1.85 1.19-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82-2.81 3.14-2.7 7.96.31 10.98 3.02 3.01 7.84 3.12 10.98.31Z">
                                    </path>
                                </svg>
                            </div>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown">
                                    <div class="d-flex align-items-center">
                                        <div class="text-end me-3 d-none d-sm-block">
                                            <h6 class="mb-0 text-gray-600">{{ Session::get('nama') }}</h6>
                                            <p class="mb-0 text-sm text-gray-600">{{ Session::get('jabatan') }}</p>
                                        </div>
                                        <div class="avatar avatar-md">
                                            <img src="{{ $userlogo }}" alt="User Avatar" class="select-image">
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'x' }}</title>
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" crossorigin href="/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="/assets/extensions/choices.js/public/assets/styles/choices.css">
    <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" crossorigin href="/assets/compiled/css/table-datatable.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <link rel="stylesheet" href="assets/extensions/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
        integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
<meta name="csrf-token" content="{{ csrf_token() }}">
        
    <style>
        .tt-menu {
        background-color: #f0f0f0;
        border: 1px solid #a50000;
        padding: 4px;
        width: 100%; 
        z-index: 1000;
        border-radius: 4px;
        }

        .tt-suggestion {
        padding: 8px 12px;
        cursor: pointer;
        background-color: rgba(243, 243, 243, 0.968);
        border-radius: 4px;
        }

        .tt-suggestion:hover,
        .tt-suggestion.tt-cursor {
        background-color: #d3d3d3; 
        border-radius: 4px;
        }

        .twitter-typeahead {
            width: 100%;
        }

        .camera-container {
            position: relative;
            text-align: center;
            width: 100%;
            height: 100%;
        }

        .camera-container video {
            width: 100%;
            height: 100%;
            max-height: 200px;
            display: block;
            object-fit: cover;
        }

        .camera-container video.mirror {
            transform: scaleX(-1);
        }

        .scan-overlay {
            position: absolute;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2;
        }

        .scan-overlay.top {
            top: 0;
            left: 0;
            width: 100%;
            height: 40%;
        }

        .scan-overlay.bottom {
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40%;
        }

        .scan-overlay.left {
            top: 40%;
            left: 0;
            width: 20%;
            height: 20%;
        }

        .scan-overlay.right {
            top: 40%;
            right: 0;
            width: 20%;
            height: 20%;
        }

        .scan-area {
            position: absolute;
            top: 40%;
            left: 20%;
            width: 60%;
            height: 20%;
            border: 3px solid #fff;
            box-sizing: border-box;
            z-index: 3;
        }
        #table1 tbody tr:hover {
        background-color: #cce5ff;
        transition: background-color 0.2s ease-in-out;
    }
    </style>
</head>

<body>
    <script src="/assets/static/js/initTheme.js"></script>
    <div id="app">
        @include('Layout.sidebar')
        <div id="main" class="pb-2">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-content">
                @yield('content')
            </div>
            <br><br>
            @include('Layout.footer')
        </div>
        @yield('modal')
        <form action="/logout" method="post" id="logoutForm">
            @csrf
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script script src="/assets/static/js/components/dark.js"></script>
    <script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/compiled/js/app.js"></script>
    {{-- <script src="/assets/extensions/apexcharts/apexcharts.min.js"></script> --}}
    <script src="/assets/static/js/pages/dashboard.js"></script>
    <script src="/assets/extensions/dayjs/dayjs.min.js"></script>
    <script src="/assets/static/js/pages/ui-apexchart.js"></script>
    <script src="/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="/assets/static/js/pages/form-element-select.js"></script>
    <script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="/assets/static/js/pages/simple-datatables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.6.0/dist/echarts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.jquery.min.js" integrity="sha512-AnBkpfpJIa1dhcAiiNTK3JzC3yrbox4pRdrpw+HAI3+rIcfNGFbVXWNJI0Oo7kGPb8/FG+CMSG8oADnfIbYLHw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
    integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js"
        integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        @if (Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                text: @json(Session::get('success')),
            }).then((result) => {
                window.open('/generatepemakaian', '_blank', 'width=500,height=500,top=100,left=100');
                window.open('/dataset/{{ time() }}', '_blank', 'width=500,height=500,top=100,left=100');
            });
        </script> @endif
         <script>
             // Tunggu sebentar jika perlu (opsional)
             setTimeout(function() {
                 window.close();
             }, 2000); // Tutup setelah 2 detik
         </script>
    

    {{-- Logout --}}
    <script>
        $(document).on('click', '#logoutButton', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Konfirmasi Logout",
                icon: 'info',
                showDenyButton: true,
                confirmButtonText: "Logout",
                denyButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logoutForm').submit();
                }
            });
        })
    </script>


    <script>
        //property lainya
        function open_window(link) {
            return window.open(link)
        }

        $(document).on('click', '.btn-modal-close', function(e) {
            e.preventDefault();
            $('.modal').modal('hide');
        });
        $(document).on('click', '.btn-modal-close', function(e) {
            e.preventDefault();
            $('.modal').modal('hide');
        });

        const formatDate = (dateString) => {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        };

        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script>
    <script>
        //pelunasan instalasi
        var numFormat = new Intl.NumberFormat('en-EN', {
            minimumFractionDigits: 2
        })

        $('#PelunasanInstalasi').typeahead(null, {
            source: function(query, syncResults, asyncResults) {
                $.get('/installations/CariPelunasan_Instalasi', {
                    query: query
                }, function(result) {
                    var states = [];
                    result.map(function(item) {
                        if (item.installation.length > 0) {
                            item.installation.map(function(instal) {
                                var name = item.nama +
                                    ' - ' + instal.village
                                    .nama +
                                    ' - ' + instal
                                    .kode_instalasi +
                                    ' [' + item.nik + ']';

                                states.push({
                                    name,
                                    instal,
                                    nama_customer: item.nama,
                                })
                            })
                        }
                    });
                    asyncResults(states);
                });
            },

            displayKey: 'name',
            autoSelect: true,
            fitToElement: true,
            items: 10

        }).bind('typeahead:selected', function(event, item) {
            var installation = item.instal
            var NamaCustomer = item.nama_customer
            var trx = installation.transaction
            var sum_total = 0;
            var rekening_debit = 0;
            var rekening_kredit = 0;

            trx.map(function(item) {
                rekening_debit = item.rekening_debit;
                rekening_kredit = item.rekening_kredit;
                sum_total += item.total;
            })

            var rek_debit = rekening_debit;
            var rek_kredit = rekening_kredit;
            var tagihan = (installation.biaya_instalasi);

            $("#nama_customer").html(NamaCustomer);
            $("#installation").val(installation.id);
            $("#order").html(installation.order);
            $("#kode_instalasi").html(installation.kode_instalasi);
            $("#alamat").html(installation.village.nama);
            $("#package").html(installation.package.kelas);
            $("#abodemen").val(numFormat.format(installation.abodemen));
            $("#biaya_sudah_dibayar").val(numFormat.format(sum_total));
            $("#tagihan").val(numFormat.format(tagihan));
            $("#pembayaran").val(numFormat.format(tagihan - sum_total));
            $("#_total").val(numFormat.format(tagihan - sum_total));
            $("#rek_debit").val(rek_debit);
            $("#rek_kredit").val(rek_kredit);
        });
    </script>

    <script>
        //Tagihan Bulanan (Aktif)
        var numFormat = new Intl.NumberFormat('en-EN', {
            minimumFractionDigits: 2
        })
        var dataCustomer;

        $('#TagihanBulanan').typeahead(null, {
            source: function(query, syncResults, asyncResults) {
                if (query.length < 2) return;

                $.get('/installations/CariTagihan_bulanan', {
                    query: query
                }, function(result) {
                    const states = [];

                    result.map(function(item) {
                        const name = item.nama + ' - ' + item.kode_instalasi + ' [' + item.nik +
                            ']';

                        states.push({
                            name,
                            value: item.kode_instalasi,
                            item
                        });
                    });

                    asyncResults(states);
                }).fail(function(xhr, status, error) {
                    console.error("Terjadi kesalahan saat pemanggilan TagihanBulanan:", error);
                    asyncResults([]);
                });
            },

            displayKey: 'name',
            autoSelect: true,
            fitToElement: true,
            items: 10
        }).bind('typeahead:selected', function(event, selectedItem) {
            formTagihanBulanan(selectedItem.item);
        });

        function formTagihanBulanan(installation) {
            let timerInterval;
            Swal.fire({
                title: 'Menyiapkan data...',
                html: 'Harap tunggu <b></b> ms.',
                timer: 30000,
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector('b');
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            });

            $.get('/installations/usage/' + installation.kode_instalasi, (result) => {
                Swal.close();
                if (result.success) {
                    $('#accordion').html(result.view);
                } else {
                    $('#accordion').html(result.view);
                }

                window.dataCustomer = {
                    item: installation,
                    rek_debit: result.rek_debit,
                    rek_kredit: result.rek_kredit,
                };
            }).fail(() => {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal memuat data',
                    text: 'Terjadi kesalahan saat mengambil data dari server.',
                });
            });
        }
    </script>

    @yield('script')
</body>

</html>

@extends('Layout.base')
@php
    $status = $settings->swit_tombol ?? null;
    $hanyaDusun = $desa->contains('kategori', 1);

    $namaCustomer = '';
    $nikCustomer = '';
    $alamatCustomer = '';
@endphp

@section('content')
    <style>
        .card-custom {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            background-color: #d6d6d6;
            margin-top: 1px;
            margin-bottom: 1px;
            margin-left: 12px;
            margin-right: 12px;
        }

        .icon-box {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #333, #555);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-box img {
            width: 32px;
            height: 32px;
        }
    </style>
    <form action="/installations" method="post" id="FormRegisterPermohonan">
        @csrf
        <input type="hidden" name="customer_id" id="customer_id">

        <section class="basic-choices position-relative">
            <div class="row">
                <div class="col-12 position-relative">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body pb-0 pt-2 ps-2 pe-2">
                                <div class="row">
                                    <div class="col-md-9 mb-0">
                                        <div class="form-group">
                                            <select class="choices form-control" name="daftar-customer"
                                                id="daftar-customer">
                                                @foreach ($customer as $anggota)
                                                    @php
                                                        $id_installation = $anggota->installation->first()?->id;

                                                        $statusText = '';
                                                        foreach ($anggota->installation as $ins) {
                                                            if ($ins->status == 'B') {
                                                                $statusText = '[ Blokir ]';
                                                            } elseif ($ins->status == 'C') {
                                                                $statusText = '[ Cabut ]';
                                                            }
                                                        }

                                                        $value = $anggota->id;
                                                        $value .= '-' . $anggota->nama;
                                                        $value .= '-' . $anggota->alamat;
                                                        $value .= '-' . $anggota->nik;
                                                        $value .= '-' . $statusText;
                                                        $value .= '-' . $id_installation;

                                                        $select = '';
                                                        if ($loop->iteration == '1') {
                                                            $namaCustomer = $anggota->nama;
                                                            $alamatCustomer = $anggota->alamat;
                                                            $nikCustomer = $anggota->nik;
                                                            $select = 'selected';
                                                        }
                                                    @endphp
                                                    <option value="{{ $value }}" {{ $select }}>
                                                        {{ $anggota->nik }} {{ $anggota->nama }} {{ $statusText }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-0 p-0 pe-3 ps-3 pb-2">
                                        <div class="d-grid">
                                            <a href="/customers/create" class="btn btn-success">
                                                Reg. Pelanggan Baru
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="container mt-4">
                        <div class="card card-custom p-3 d-flex flex-row align-items-center">
                            <div class="icon-box me-3">
                                <img src="https://img.icons8.com/ios-filled/50/ffffff/document.png" alt="Icon Proposal" />
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">
                                    Register Pelanggan Atas Nama
                                    <span id="namaCustomer" class="h5 text-dark">{{ $namaCustomer }}</span>
                                </h5>
                                <small class="text-muted">Alamat.
                                    <span id="alamatCustomer">{{ $alamatCustomer }}, </span>
                                    ( <span id="nikCustomer">{{ $nikCustomer }} </span> )
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="position-relative mb-3">
                                    <label for="order">Tanggal Order</label>
                                    <input type="text" class="form-control date" name="order" id="order"
                                        placeholder="order" value="{{ old('order', date('d/m/Y')) }}">
                                    <small class="text-danger" id="msg_order"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative mb-3">
                                    <label for="desa">Nama/Desa & Dusun</label>
                                    <select class="choices form-control" name="desa" id="desa">
                                        <option value="">Pilih Nama/Desa & Dusun</option>
                                        @foreach ($desa as $ds)
                                            @if (!$hanyaDusun || $ds->kategori == 1)
                                                <option {{ $pilih_desa == $ds->kode ? 'selected' : '' }}
                                                    value="{{ $ds->id }}">
                                                    {{ $ds->kode }} -
                                                    [{{ $hanyaDusun ? $ds->dusun : $ds->nama }}]
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="msg_desa"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="cater">Nama Sales</label>
                                    <select class="choices form-control" name="cater" id="cater">
                                        <option value="">Pilih Sales</option>
                                        @foreach ($caters as $ct)
                                            <option value="{{ $ct->id }}">
                                                {{ $ct->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="msg_cater"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="position-relative mb-3">
                                    <label for="jalan">Jalan</label>
                                    <input type="text" class="form-control" id="jalan" name="jalan"
                                        aria-describedby="jalan" placeholder="Jalan">
                                    <small class="text-danger" id="msg_jalan"></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="position-relative mb-3">
                                    <label for="rw">RW</label>
                                    <input type="number" class="form-control" id="rw" name="rw"
                                        aria-describedby="rw" placeholder="Rw">
                                    <small class="text-danger" id="msg_rw"></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="position-relative mb-3">
                                    <label for="rt">RT</label>
                                    <input type="number" class="form-control" id="rt" name="rt"
                                        aria-describedby="rt" placeholder="Rt">
                                    <small class="text-danger" id="msg_rt"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="koordinate">Koordinate</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Masukkan Link Koordinate"
                                        aria-describedby="koordinate" name="koordinate" id="koordinate">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">
                                            <a href="https://maps.google.com/" target="_blank"
                                                style="color: rgb(0, 0, 0); text-decoration: none;">Google Maps</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="jenis_paket">Paket/Kelas</label>
                                    <select class="choices form-control package" name="package_id" id="jenis_paket">
                                        <option value="">Pilih Paket/Kelas</option>
                                        @foreach ($paket as $p)
                                            <option value="{{ $p->id }}">
                                                {{ $p->kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="msg"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="formjenis_paket">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="kode_instalasi">Kode instalasi</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" aria-describedby="Kode_instalasi"
                                        name="kode_instalasi" id="kode_instalasi"
                                        placeholder="Kode instalasi akan terpenuhi jika desa dipilih" readonly>
                                </div>
                            </div>
                            @if ($status === 1)
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="total">Nominal</label>
                                        <input type="text" class="form-control total" aria-describedby="total"
                                            name="total" id="total"
                                            value="{{ number_format($settings->pasang_baru, 2) }}" readonly>
                                        <small class="text-danger" id="msg_package_id"></small>
                                    </div>
                                </div>
                            @elseif ($status === 2)
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="total">Nominal</label>
                                        <input type="text" class="form-control total total1" aria-describedby="total"
                                            name="total" id="total">
                                        <small class="text-danger" id="msg_package_id"></small>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <hr>
                        <p class="mb-0">
                            Catatan : ( Jika Ada data atau inputan yang kosong bisa di isi ( 0 ) atau ( - ) )
                        </p>
                        <button type="submit" id="SimpanPermohonan" class="btn btn-dark" style="float: right;">Daftar &
                            Simpan</button>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $("#abodemen").maskMoney({
            allowNegative: true
        });

        $(".total").maskMoney({
            allowNegative: true
        });

        $(document).on('change', '#total', function() {
            function cleanNumber(value) {
                let cleanNumber = value.toString().replace(/,/g, '');
                return parseFloat(cleanNumber) || 0;
            }

            var pasang = cleanNumber($('#pasang_baru').val());
            var total = cleanNumber($(this).val());

            if (total > pasang) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Total Tidak Boleh Lebih Dari Pasang Baru!"
                });
            }
        });

        jQuery.datetimepicker.setLocale('de');
        $('.date').datetimepicker({
            i18n: {
                de: {
                    months: [
                        'Januar', 'Februar', 'März', 'April',
                        'Mai', 'Juni', 'Juli', 'August',
                        'September', 'Oktober', 'November', 'Dezember',
                    ],
                    dayOfWeek: [
                        "So.", "Mo", "Di", "Mi",
                        "Do", "Fr", "Sa.",
                    ]
                }
            },
            timepicker: false,
            format: 'd/m/Y'
        });

        $(document).on('change', '#desa, #rt', function(e) {
            e.preventDefault();

            var kd_desa = $('#desa').val();
            var rt = $('#rt').val();

            $.get('/installations/kode_instalasi', {
                kode_desa: kd_desa,
                kode_rt: rt,
            }, function(result) {
                $('#kode_instalasi').val(result.kd_instalasi);
            });
        });

        $(document).on('change', '#jenis_paket', async function() {
            var jenis_paket = $(this).val()
            var view = '';

            if (jenis_paket != '') {
                await $.get('/installations/jenis_paket/' + jenis_paket, function(result) {
                    view = result.view;
                })
            }

            $('#formjenis_paket').html(view)
        })

        $(document).on('click', '#SimpanPermohonan', function(e) {
            e.preventDefault();
            $('small').html('');

            var form = $('#FormRegisterPermohonan');
            var actionUrl = form.attr('action');
            var btn = $(this);

            // Nonaktifkan tombol & tampilkan loading Swal
            btn.prop('disabled', true);
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(result) {
                    Swal.close(); // Tutup loading Swal
                    if (result.success) {
                        Swal.fire({
                            title: result.msg,
                            text: "Tambahkan Register Instalasi Baru?",
                            icon: "success",
                            showDenyButton: true,
                            confirmButtonText: "Tambahkan",
                            denyButtonText: `Tidak`
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload()
                            } else {
                                window.location.href = '/installations/' + result.installation
                                    .id;
                            }
                        });
                    }
                },
                error: function(result) {
                    Swal.close(); // Tutup loading Swal
                    btn.prop('disabled', false); // Aktifkan kembali tombol

                    const response = result.responseJSON;
                    Swal.fire('Error', 'Cek kembali input yang anda masukkan', 'error');
                    if (response && typeof response === 'object') {
                        $.each(response, function(key, message) {
                            $('#' + key)
                                .closest('.input-group.input-group-static')
                                .addClass('is-invalid');

                            $('#msg_' + key).html(message);
                        });
                    }
                }
            });
        });

        //notifikasi
        $(document).on('change', '#daftar-customer', function() {
            var value = $(this).val().split('-');
            var id = value[0];
            var nama = value[1];
            var alamat = value[2];
            var nik = value[3];
            var status = value[4];
            var id_instal = value[5];

            $('#namaCustomer').html(nama);
            $('#alamatCustomer').html(alamat);
            $('#nikCustomer').html(nik);

            $('input.form-control:not(.total)').val("");
            $('select.choices').each((index, item) => {
                if (item.getAttribute('id') != 'daftar-customer') {
                    choiceData[item.getAttribute('id')].setChoiceByValue("");
                }
            });
            $('#customer_id').val(id);
            $('#jenis_paket').trigger('change');
            if (status) {
                Swal.fire({
                    title: "<strong>Tidak Bisa Register Instalasi Baru !!</u></strong>",
                    icon: "info",
                    html: `
                        Customer an.<strong>${nama}</strong>
                        memiliki Tagihan Instalasi dengan Status <strong>${status}</strong>
                    `,
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    cancelButtonText: `Cancel`,
                    confirmButtonText: `Cek Detail Sekarang`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (status == '[ Blokir ]') {
                            window.location.href = '/installations/' + id_instal;
                        } else if (status == '[ Cabut ]') {
                            window.location.href = '/installations/' + id_instal;
                        }
                    }

                });
            }
        });

        function getTodayDate() {
            const today = new Date();
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const year = today.getFullYear();
            return `${day}/${month}/${year}`;
        }

        $(document).ready(function() {
            $('#daftar-customer').on('change', function() {
                // Pakai delay kecil agar ini dijalankan paling terakhir
                setTimeout(function() {
                    $('#order').val(getTodayDate());
                }, 50);
            });
        });
    </script>
@endsection

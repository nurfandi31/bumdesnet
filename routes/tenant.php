<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\AccountController;
use App\Http\Controllers\Tenant\AuthController;
use App\Http\Controllers\Tenant\BusinessController;
use App\Http\Controllers\Tenant\CategoryController;
use App\Http\Controllers\Tenant\CaterController;
use App\Http\Controllers\Tenant\CustomerController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\HakAksesController;
use App\Http\Controllers\Tenant\InstallationsController;
use App\Http\Controllers\Tenant\PackageController;
use App\Http\Controllers\Tenant\PelaporanController;
use App\Http\Controllers\Tenant\ProductController;
use App\Http\Controllers\Tenant\ProductPurchaseController;
use App\Http\Controllers\Tenant\ProfilController;
use App\Http\Controllers\Tenant\SopController;
use App\Http\Controllers\Tenant\SystemController;
use App\Http\Controllers\Tenant\TransactionController;
use App\Http\Controllers\Tenant\UsageController;
use App\Http\Controllers\Tenant\UserController;
use App\Http\Controllers\Tenant\VillageController;
use App\Models\Tenant\ProductPurchase;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
  'web',
  InitializeTenancyByDomain::class,
  PreventAccessFromCentralDomains::class,
])->group(function () {
  Route::middleware(['guest:web'])->group(function () {
    // Auth
    Route::get('/auth', [AuthController::class, 'index'])->name('auth');
    Route::post('/auth', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'proses_register']);

    Route::get('/migrasi/desa', [AuthController::class, 'migrasi_desa']);
    Route::get('/migrasi/paket', [AuthController::class, 'migrasi_paket']);
    Route::get('/migrasi/customer', [AuthController::class, 'migrasi_customer']);
    Route::get('/migrasi/instalasi', [AuthController::class, 'migrasi_instalasi']);
    Route::get('/migrasi/pemakaian', [AuthController::class, 'migrasi_pemakaian']);
    Route::get('/migrasi/akun', [AuthController::class, 'migrasi_akun']);
    Route::get('/migrasi/transaksi', [AuthController::class, 'migrasi_transaksi']);
    Route::get('/migrasi/sync', [AuthController::class, 'migrasi_sync']);

    Route::get('/migrasi/custom/{business}', [AuthController::class, 'custom']);
  });

  Route::middleware(['auth', 'auth.token'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard/permohonan', [DashboardController::class, 'permohonan']);
    Route::get('/dashboard/pasang', [DashboardController::class, 'pasang']);
    Route::get('/dashboard/PemakaianAktif', [DashboardController::class, 'Pemakaian']);
    Route::get('/dashboard/tagihan', [DashboardController::class, 'tagihan']);
    Route::get('/dashboard/tunggakan', [DashboardController::class, 'tunggakan']);
    Route::get('/dashboard/sps/{id}', [DashboardController::class, 'sps']);
    Route::get('/dashboard/Cetaktunggakan2/{id}', [DashboardController::class, 'Cetaktunggakan2']);
    Route::get('/dashboard/Cetaktunggakan1/{id}', [DashboardController::class, 'Cetaktunggakan1']);
    Route::post('/dashboard/CetakTagihan', [DashboardController::class, 'CetakTagihan']);
    Route::get('/dashboard/tagihan_dashboard', [DashboardController::class, 'tagihan_dashboard']);
    Route::get('/dataset/{time}', [SystemController::class, 'dataset']);

    Route::get('/pengaturan/coa', [SopController::class, 'coa']);

    // Profil
    Route::get('/profil', [ProfilController::class, 'index']);
    Route::post('/profil', [ProfilController::class, 'update']);
    Route::post('/profil/img', [ProfilController::class, 'upload']);
    Route::post('/profil/data_login', [ProfilController::class, 'data_login']);

    // Accounts || Rekening
    Route::resource('/accounts', AccountController::class);

    // Business || Usaha
    Route::resource('/business', BusinessController::class);

    // Customers || Pelanggan
    Route::resource('/customers', CustomerController::class);

    // Products || Produk
    Route::resource('/category', CategoryController::class);
    Route::resource('/products', ProductController::class);

    // Purchase || Pembelian
    Route::resource('/purchases', ProductPurchaseController::class);

    // Installations || Instalasi
    Route::get('/installations/permohonan', [InstallationsController::class, 'permohonan']);
    Route::get('/installations/pasang', [InstallationsController::class, 'pasang']);
    Route::get('/installations/aktif', [InstallationsController::class, 'aktif']);
    Route::get('/installations/blokir', [InstallationsController::class, 'blokir']);
    Route::get('/installations/cabut', [InstallationsController::class, 'cabut']);

    Route::get('/installations/cater/{cater_id?}', [InstallationsController::class, 'list']);
    Route::get('/installations/jenis_paket/{id}', [InstallationsController::class, 'jenis_paket']);
    Route::get('/installations/kode_instalasi', [InstallationsController::class, 'kode_instalasi']);
    Route::get('/installations/struk_Tagihan/{installation}', [InstallationsController::class, 'strukTagihan']);
    Route::get('/installations/surat_tagihan/{installation}', [InstallationsController::class, 'surat_tagihan']);
    Route::get('/installations/cetak/{installation}', [InstallationsController::class, 'cetak_pemakaian']);

    Route::get('/installations/CariPelunasan_Instalasi', [InstallationsController::class, 'CariPelunasanInstalasi']);
    Route::get('/installations/CariTagihan_bulanan', [InstallationsController::class, 'CariTagihanbulanan']);
    Route::get('/installations/usage/{kode_instalasi}', [InstallationsController::class, 'usage']);
    Route::get('/installations/KembaliStatus_A/{id}', [InstallationsController::class, 'KembaliStatus_A']);
    Route::post('/installations/blokirStatus/{id}', [InstallationsController::class, 'blokirStatus']);
    Route::resource('/installations', InstallationsController::class);

    // Packages || Paket
    Route::get('/packages/block_paket', [PackageController::class, 'block_paket']);
    Route::resource('/packages', PackageController::class);

    // Usages || Penggunaan
    Route::get('/generatepemakaian', [UsageController::class, 'generatePemakaian']);
    Route::get('/usages/detail_tagihan/', [UsageController::class, 'detailTagihan']);
    Route::post('/usages/cetak', [UsageController::class, 'cetak']);
    Route::post('/usages/cetak_tagihan', [UsageController::class, 'cetak_tagihan']);
    Route::resource('/usages', UsageController::class);

    // Transactions || Transaksi
    Route::get('/transactions/ambil_rekening/{id}', [TransactionController::class, 'rekening']);
    Route::get('/transactions/form_nominal/', [TransactionController::class, 'form']);
    Route::get('/transactions/jurnal_umum', [TransactionController::class, 'jurnal_umum']);
    Route::get('/transactions/tagihan_bulanan', [TransactionController::class, 'tagihan_bulanan']);
    Route::get('/transactions/pelunasan_instalasi', [TransactionController::class, 'pelunasan_instalasi']);
    Route::get('/transactions/saldo/{kode_akun}', [TransactionController::class, 'saldo']);
    Route::get('/transactions/detail_transaksi_tagihan/', [TransactionController::class, 'detailTransaksiTagihan']);
    Route::get('/transactions/detail_transaksi_instalasi/', [TransactionController::class, 'detailTransaksiInstalasi']);
    Route::get('/transactions/detail_transaksi/', [TransactionController::class, 'detailTransaksi']);

    Route::post('/transactions/tutup_buku/saldo_tutup_buku', [TransactionController::class, 'saldo_tutup_buku']);
    Route::get('/transactions/tutup_buku', [TransactionController::class, 'jurnalTutupBuku']);
    Route::post('/transactions/tutup_buku', [TransactionController::class, 'tutup_buku']);
    Route::post('/transactions/simpan_laba', [TransactionController::class, 'simpanAlokasiLaba']);

    Route::get('/transactions/ebudgeting', [TransactionController::class, 'ebudgeting']);
    Route::post('/transactions/anggaran', [TransactionController::class, 'anggaran']);
    Route::post('/transactions/simpan_anggaran', [TransactionController::class, 'simpananggaran']);

    Route::get('/transactions/dokumen/struk_instalasi/{id}', [TransactionController::class, 'struk_instalasi']);
    Route::get('/transactions/dokumen/struk_tagihan/{id}', [TransactionController::class, 'struk_tagihan']);
    Route::get('/transactions/dokumen/kuitansi/{id}', [TransactionController::class, 'kuitansi']);
    Route::get('/transactions/dokumen/kuitansi_thermal/{id}', [TransactionController::class, 'kuitansi_thermal']);
    Route::get('/transactions/dokumen/bkk/{id}', [TransactionController::class, 'bkk']);
    Route::get('/transactions/dokumen/bkm/{id}', [TransactionController::class, 'bkm']);
    Route::get('/transactions/dokumen/bm/{id}', [TransactionController::class, 'bm']);

    Route::post('/transactions/dokumen/cetak', [TransactionController::class, 'cetak']);
    Route::get('/transactions/data/{id}', [TransactionController::class, 'data']);
    Route::post('/transactions/reversal', [TransactionController::class, 'reversal']);
    Route::post('/transactions/hapus', [TransactionController::class, 'hapus']);
    Route::resource('/transactions', TransactionController::class);

    // Setting
    Route::get('/pengaturan/sop', [SopController::class, 'profil']);
    Route::get('/pengaturan/coa', [SopController::class, 'coa']);
    Route::get('/pengaturan/akun_coa', [SopController::class, 'akun_coa']);
    Route::post('/pengaturan/coa', [SopController::class, 'CreateCoa']);
    Route::put('/pengaturan/coa/{kode_akun}', [SopController::class, 'UpdateCoa']);
    Route::delete('/pengaturan/coa/{account}', [SopController::class, 'DeleteCoa']);


    Route::get('/pengaturan/sop/pasang_baru', [SopController::class, 'pasang_baru']);
    Route::get('/pengaturan/sop/lembaga', [SopController::class, 'lembaga']);
    Route::get('/pengaturan/sop/sistem_instal', [SopController::class, 'sistem_instal']);
    Route::get('/pengaturan/sop/block_paket', [SopController::class, 'block_paket']);
    Route::put('/pengaturan/sop/logo/{business}', [SopController::class, 'logo']);
    Route::post('/pengaturan/pesan_whatsapp', [SopController::class, 'pesan']);
    Route::resource('/pengaturan', SopController::class);

    // Users || Pengguna
    Route::resource('/users', UserController::class);

    // Users || Desa
    Route::get('/ambil_kab/{kode}', [VillageController::class, 'ambil_kab']);
    Route::get('/ambil_kec/{kode}', [VillageController::class, 'ambil_kec']);
    Route::get('/ambil_desa/{kode}', [VillageController::class, 'ambil_desa']);
    Route::get('/set_alamat/{kode}', [VillageController::class, 'generateAlamat']);
    Route::resource('/villages', VillageController::class);
    Route::delete('/villages/{village}', [VillageController::class, 'destroy']);

    // Dusun
    // Route::resource('/hamlets', HamletController::class);
    // Route::delete('/hamlets/{hamlet}', [HamletController::class, 'destroy']);

    // Cater
    Route::resource('/caters', CaterController::class);

    //generate
    Route::get('/generate_alamat/{kode}', [VillageController::class, 'generateAlamat']);

    //pelaporan
    Route::get('/pelaporan', [PelaporanController::class, 'index']);
    Route::get('/pelaporan/preview', [PelaporanController::class, 'preview']);
    Route::get('/pelaporan/sub_laporan/{file}', [PelaporanController::class, 'subLaporan']);
    Route::get('/pelaporan/simpan_saldo/{tahun}/{bulan?}', [PelaporanController::class, 'simpanSaldo']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
  });
});

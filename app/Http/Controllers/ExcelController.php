<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Models\Customer;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Excel as ExcelExcel;

class ExcelController extends Controller
{
    public function index()
    {
        $lokasi = '2';
        Session::put('business_id', $lokasi);
        $excel = (new ExcelImport)->toArray('storage/excel/DATA PEMBAYARAN WIFI 2025 Juni Fix.xlsx', null, ExcelExcel::XLSX);

        $customers = [];
        $package = Package::where('business_id', Session::get('business_id'))->get()->pluck([], 'kelas')->toArray();
        $customer = Customer::where('business_id', Session::get('business_id'))->get();
        foreach ($customer as $cs) {
            $customers[strtolower($cs->nama)] = $cs;
        }

        $queryInsertCustomer = 'INSERT INTO `customers`(`id`, `business_id`, `nama`, `nama_panggilan`, `nik`, `jk`, `alamat`, `tempat_lahir`, `tgl_lahir`, `pekerjaan`, `hp`, `email`, `foto`, `petugas`, `created_at`, `updated_at`) VALUES ';
        $queryInsertInstallation = 'INSERT INTO `installations`(`id`, `business_id`, `kode_instalasi`, `customer_id`, `cater_id`, `package_id`, `harga_paket`, `koordinate`, `desa`, `alamat`, `rw`, `rt`, `status`, `status_tunggakan`, `biaya_instalasi`, `abodemen`, `order`, `pasang`, `aktif`, `blokir`, `cabut`, `created_at`, `updated_at`) VALUES ';
        $queryInsertUsage = 'INSERT INTO `usages`(`id`, `business_id`, `tgl_pemakaian`, `id_instalasi`, `kode_instalasi`, `customer`, `awal`, `akhir`, `jumlah`, `nominal`, `tgl_akhir`, `cater`, `status`, `created_at`, `updated_at`) VALUES ';
        $queryInsertTransaction = 'INSERT INTO `transactions`(`id`, `business_id`, `tgl_transaksi`, `rekening_debit`, `rekening_kredit`, `user_id`, `usage_id`, `installation_id`, `total`, `transaction_id`, `relasi`, `keterangan`, `urutan`, `created_at`, `updated_at`) VALUES ';

        $customerIdStart = 1;
        $installationIdStart = 1;
        $usageIdStart = 1;

        $query_update = '';
        foreach ($excel[4] as $key => $ex) {
            if ($key <= 5) continue;

            /**
             * 0 => "NO"
             * 1 => "TGL AKTIF"
             * 2 => "TGL. BAYAR"
             * 3 => "NO. ID"
             * 4 => "NAMA "
             * 5 => "NIK"
             * 6 => "NO. HP"
             * 7 => "ALAMAT"
             * 8 => "PAKET LAYANAN"
             * 9 => "HARGA PAKET"
             * 10 => "TAGIHAN (-PPN)"
             * 11 => "PEMAKAIAN (HARI)"
             * 12 => "PPN"
             * 13 => "DISKON"
             * 14 => "DISKON (Rp)"
             * 15 => "JMLH TAGIHAN"
             * 16 => "KETERANGAN"
             * 17 => null
             */

            $nama_customer = strtolower($ex[4]);
            if (in_array($nama_customer, array_keys($customers))) {
                $update_set = 'nik="' . $ex[5] . '"';
                $update_set .= ', hp="' . $ex[6] . '"';
                $update_set .= ', alamat="' . $ex[7] . '"';
                $query_update .= 'UPDATE customers SET ' . $update_set . ' WHERE id="' . $customers[$nama_customer]->id . '";<br>';
            } else {
                $paket = $package[$ex[8]];
                $paket_id = $paket['id'];

                $unicodeTime = ($ex[1] - 25569) * 86400;
                $tgl_aktif = date("Y-m-d", $unicodeTime);
                $tgl_akhir = date('y-m-t', strtotime($tgl_aktif));

                $status = ($ex[16] == 'LUNAS') ? 'PAID' : 'UNPAID';

                $queryInsertCustomer .= `('${customerIdStart}', '${lokasi}', '${ex[4]}', '${ex[4]}', '${ex[5]}', 'L', '${ex[7]}', '-', NULL, NULL, '${ex[6]}', NULL, NULL, NULL, '${ex[0]}', '${ex[0]}');<br>`;
                $queryInsertInstallation .= `('${installationIdStart}', '${lokasi}', '${ex[3]}', '${customerIdStart}', '1', '${paket_id}', '1', '${ex[7]}','1', '1', 'A', 'lancar','150000', '0', '${tgl_aktif}', '${tgl_aktif}', '${tgl_aktif}', '${tgl_aktif}', '${tgl_aktif}');<br>`;
                $queryInsertUsage .= `('${usageIdStart}', '${lokasi}', '${tgl_aktif}', '${installationIdStart}', '${ex[3]}', '${customerIdStart}', '1', '30', '1', '${ex[9]}', '${tgl_akhir}', '1', '${status}', '${tgl_aktif}', '${tgl_aktif}'); <br>`;

                if ($status == 'PAID') {
                    $PPN = $ex[9] * 11 / 100;
                    $queryInsertTransaction .= `(NULL, '${lokasi}', '${tgl_akhir}', 692, 740, 1, '${usageIdStart}', '${installationIdStart}', '${ex[9]}', 'BL-${usageIdStart}', '-', 'Bayar Jasa Internet', '0', '${tgl_akhir}', '${tgl_akhir}'); <br>`;
                    $queryInsertTransaction .= `(NULL, '${lokasi}', '${tgl_akhir}', 692, 739, 1, '${usageIdStart}', '${installationIdStart}', '${PPN}', 'BL-${usageIdStart}', '-', 'Pendapatan Lain', '0', '${tgl_akhir}', '${tgl_akhir}'); <br>`;
                }

                $customerIdStart++;
                $installationIdStart++;
                $usageIdStart++;
            }
        }

        echo $query_update;
        echo "<br>";
        echo $queryInsertCustomer;
        echo "<br>";
        echo $queryInsertInstallation;
        echo "<br>";
        echo $queryInsertUsage;
        echo "<br>";
        echo $queryInsertTransaction;
        echo "<br>";
    }
}

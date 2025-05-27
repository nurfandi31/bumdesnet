<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Amount;
use App\Models\Installations;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SystemController extends Controller
{
    public function dataset($waktu)
    {
        $setting = Settings::where('business_id', Session::get('business_id'))->first();

        $date = date('Y-m-d', $waktu);
        $created_at = date('Y-m-d H:i:s');
        $batas_toleransi = $setting->tanggal_toleransi ?: '27';
        $businessId = Session::get('business_id');
        $installations = Installations::where('business_id', Session::get('business_id'))->with([
            'package',
            'usage' => function ($query) use ($date) {
                $query->where('status', 'UNPAID')->where('tgl_akhir', '<=', $date)->orderBy('tgl_akhir')->orderBy('id');
            },
            'usage.transaction'
        ])->get();

        $accounts = Account::where('business_id', $businessId)
            ->whereIn('kode_akun', ['1.1.03.01', '4.1.01.02', '4.1.01.03', '4.1.01.04'])
            ->get()
            ->keyBy('kode_akun');

        $kode_piutang = $accounts['1.1.03.01'] ?? null;
        $kode_abodemen = $accounts['4.1.01.02'] ?? null;
        $kode_pemakaian = $accounts['4.1.01.03'] ?? null;
        $kode_denda = $accounts['4.1.01.04'] ?? null;

        $update_sps = [];
        $trx_tunggakan = [];
        foreach ($installations as $ins) {
            if (count($ins->usage) >= 3) {
                $update_sps[] = $ins->id;
            }

            $abodemen = $ins->abodemen;
            $denda = $ins->package->denda;
            foreach ($ins->usage as $usage) {
                $jumlah_pembayaran = 0;
                foreach ($usage->transaction as $trx) {
                    if ($trx->rekening_kredit == $kode_pemakaian->id) {
                        $jumlah_pembayaran += $trx->total;
                    }
                }

                $nominal = $usage->nominal;
                if ($usage->nominal <= 0) {
                    $nominal = 1;
                }

                $trx_id = substr(password_hash($usage->id, PASSWORD_DEFAULT), 7, 6);
                if ($usage->tgl_akhir <= $date && $jumlah_pembayaran < $nominal) {
                    $trx_tunggakan[] = [
                        'business_id' => $businessId,
                        'tgl_transaksi' => $usage->tgl_akhir,
                        'rekening_debit' => $kode_piutang->id,
                        'rekening_kredit' => $kode_abodemen->id,
                        'user_id' => '1',
                        'usage_id' => $usage->id,
                        'installation_id' => $usage->id_instalasi,
                        'transaction_id' => $trx_id,
                        'total' => $abodemen,
                        'relasi' => $usage->customers->nama,
                        'keterangan' => 'Hutang Abodemen pemakaian atas nama ' . $usage->customers->nama . ' (' . $ins->id . ')',
                        'urutan' => '0',
                        'created_at' => $created_at
                    ];

                    $trx_tunggakan[] = [
                        'business_id' => $businessId,
                        'tgl_transaksi' => $usage->tgl_akhir,
                        'rekening_debit' => $kode_piutang->id,
                        'rekening_kredit' => $kode_pemakaian->id,
                        'user_id' => '1',
                        'usage_id' => $usage->id,
                        'installation_id' => $usage->id_instalasi,
                        'transaction_id' => $trx_id,
                        'total' => $usage->nominal - $jumlah_pembayaran,
                        'relasi' => $usage->customers->nama,
                        'keterangan' => 'Hutang Pemakaian atas nama ' . $usage->customers->nama . ' (' . $ins->id . ')',
                        'urutan' => '0',
                        'created_at' => $created_at
                    ];

                    $trx_tunggakan[] = [
                        'business_id' => $businessId,
                        'tgl_transaksi' => $usage->tgl_akhir,
                        'rekening_debit' => $kode_piutang->id,
                        'rekening_kredit' => $kode_denda->id,
                        'user_id' => '1',
                        'usage_id' => $usage->id,
                        'installation_id' => $usage->id_instalasi,
                        'transaction_id' => $trx_id,
                        'total' => $denda,
                        'relasi' => $usage->customers->nama,
                        'keterangan' => 'Hutang Denda pemakaian atas nama ' . $usage->customers->nama . ' (' . $ins->id . ')',
                        'urutan' => '0',
                        'created_at' => $created_at
                    ];
                }
            }
        }

        // dd($trx_tunggakan);
        Installations::whereIn('id', $update_sps)->update(['status_tunggakan' => 'sps']);
        DB::statement('SET @DISABLE_TRIGGER = 1');
        Transaction::insert($trx_tunggakan);
        DB::statement('SET @DISABLE_TRIGGER = 0');

        $this->saldo(date('Y', $waktu), date('m', $waktu), $kode_piutang->id, $kode_abodemen->id, $kode_pemakaian->id, $kode_denda->id);
        echo '<script>window.close()</script>';
        exit;
    }

    private function saldo($tahun, $bulan, ...$akun)
    {
        $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $date = $tahun . '-' . $bulan . '-01';
        $tgl_kondisi = date('Y-m-t', strtotime($date));
        $accounts = Account::where('business_id', Session::get('business_id'))
            ->whereIn('id', $akun)->with([
                'trx_debit' => function ($query) use ($date, $tgl_kondisi) {
                    $query->whereBetween('tgl_transaksi', [$date, $tgl_kondisi]);
                },
                'trx_kredit' => function ($query) use ($date, $tgl_kondisi) {
                    $query->whereBetween('tgl_transaksi', [$date, $tgl_kondisi]);
                },
                'oneAmount' => function ($query) use ($tahun, $bulan) {
                    $bulan = str_pad(intval($bulan - 1), 2, '0', STR_PAD_LEFT);
                    $query->where('tahun', $tahun)->where('bulan', $bulan);
                }
            ])->get();

        $amount = [];
        $data_id = [];
        foreach ($accounts as $account) {
            $id = $account->id . $tahun . $bulan;

            $saldo_debit = 0;
            $saldo_kredit = 0;
            if ($account->oneAmount && intval($bulan) > 1) {
                $saldo_debit = $account->oneAmount->debit;
                $saldo_kredit = $account->oneAmount->kredit;
            }

            foreach ($account->trx_debit as $trx_debit) {
                $saldo_debit += $trx_debit->total;
            }

            foreach ($account->trx_kredit as $trx_kredit) {
                $saldo_kredit += $trx_kredit->total;
            }


            $amount[] = [
                'id' => $id,
                'account_id' => $account->id,
                'tahun' => $tahun,
                'bulan' => $bulan,
                'debit' => $saldo_debit,
                'kredit' => $saldo_kredit
            ];

            $data_id[] = $id;
        }

        Amount::whereIn('id', $data_id)->delete();
        Amount::insert($amount);
    }
}
?>

<!-- Pendapatan abodemen, denda, penggunaan air
Tanggal 27 if (tagihan) jurnal => piutang usaha
if pembayaran bulanan sps, ada 2 transaksi
1. piutang ke kas
2. trx komisi utang sps (2.1.02) ke fee kolektor | 10% dari total -->
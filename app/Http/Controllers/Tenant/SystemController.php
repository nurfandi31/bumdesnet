<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Account;
use App\Models\Tenant\Amount;
use App\Models\Tenant\Installations;
use App\Models\Tenant\Settings;
use App\Models\Tenant\Transaction;
use App\Models\Tenant\Usage;
use Illuminate\Http\Request;
use App\Utils\Tanggal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class SystemController extends Controller
{
    public function dataset($waktu)
    {
        $businessId = Session::get('business_id');
        $setting = Settings::where('business_id', $businessId)->first();
        $sekarang = now();
        $toleransiTanggal = (int) date('d', strtotime($setting->tanggal_toleransi));
        $tanggalToleransi = $sekarang->copy()->day($toleransiTanggal);

        $installations = Installations::where('business_id', $businessId)
            ->with(['usage' => fn ($q) => $q->where('status', 'UNPAID')])
            ->get();
        dd($installations, $sekarang, $tanggalToleransi, $setting, $businessId);
        $lancar = [];
        $menunggak1 = [];

        foreach ($installations as $installation) {
            $count = $installation->usage->count();
            if ($count == 1) {
                $menunggak1[] = $installation->id;
            } elseif ($count == 0) {
                $lancar[] = $installation->id;
            }
        }

        if ($menunggak1) {
            Installations::whereIn('id', $menunggak1)->update([
                'status' => 'B',
                'blokir' => date('Y-m-d')
            ]);
        }

        if ($lancar) {
            Installations::whereIn('id', $lancar)->update([
                'status' => 'A'
            ]);
        }

        if ($sekarang->greaterThan($tanggalToleransi)) {
            $telatBayarIds = Installations::where('business_id', $businessId)
                ->where('status', 'A')
                ->whereHas('usage', function ($q) use ($sekarang) {
                    $q->where('status', 'UNPAID')
                        ->whereMonth('created_at', $sekarang->copy()->subMonth()->month)
                        ->whereYear('created_at', $sekarang->copy()->subMonth()->year);
                })
                ->pluck('id')
                ->toArray();

            if ($telatBayarIds) {
                Installations::whereIn('id', $telatBayarIds)->update([
                    'status' => 'B',
                    'blokir' => date('Y-m-d')
                ]);
            }
        }

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
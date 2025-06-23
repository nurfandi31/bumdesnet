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
        $created_at = now();
        $businessId = Session::get('business_id');
        $installations = Installations::where('business_id', $businessId)
            ->with([
                'package',
                'usage' => function ($query) {
                    $query->where('status', 'UNPAID');
                }
            ])->get();

        $menunggak3 = [
            'update' => [
                'status_tunggakan' => 'menunggak2',
                'status' => 'C'
            ],
            'id' => []
        ];
        $menunggak2 = [
            'update' => [
                'status_tunggakan' => 'menunggak1',
                'status' => 'B'
            ],
            'id' => []
        ];
        $menunggak1 = [
            'update' => [
                'status_tunggakan' => 'lancar',
                'status' => 'A'
            ],
            'id' => []
        ];
        foreach ($installations as $installation) {
            $unpaidCount = count($installation->usage);

            if ($unpaidCount >= 3) {
                $menunggak3['id'][] = $installation->id;
            } elseif ($unpaidCount == 2) {
                $menunggak2['id'][] = $installation->id;
            } else {
                $menunggak1['id'][] = $installation->id;
            }
        }

        Installations::whereIn('id', $menunggak3['id'])->update($menunggak3['update']);
        Installations::whereIn('id', $menunggak2['id'])->update($menunggak2['update']);
        Installations::whereIn('id', $menunggak1['id'])->update($menunggak1['update']);

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
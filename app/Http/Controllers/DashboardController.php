<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Business;
use App\Models\Installations;
use App\Models\Settings;
use App\Models\Usage;
use App\Models\User;
use App\Utils\Keuangan;
use App\Utils\Tanggal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    public function index()
    {
        $keuangan = new Keuangan;

        $installations = Installations::selectRaw("
                SUM(CASE WHEN status = 'R' THEN 1 ELSE 0 END) AS permohonan,
                SUM(CASE WHEN status = 'I' THEN 1 ELSE 0 END) AS pasang,
                SUM(CASE WHEN status = 'A' THEN 1 ELSE 0 END) AS aktif
            ")
            ->where('business_id', Session::get('business_id'))
            ->first();

        $Installation = $installations->permohonan + $installations->pasang + $installations->aktif;
            $Usages = Installations::where('business_id', Session::get('business_id'))->where('status', 'A')->with([
            'customer',
            'package',
            'oneUsage' => function ($query) {
                $query->where('tgl_akhir', '<=', date('Y-m-d'));
            }
        ])->get();
        $Tagihan = Usage::where('business_id', Session::get('business_id'))->where([
            ['status', 'UNPAID'],
            ['tgl_akhir', '<', date('Y-m-d')]
        ])->count();

        $Tunggakan = Installations::where('business_id', Session::get('business_id'))->where('status', 'A')
            ->whereHas('usage', function (Builder  $query) {
                $query->where([
                    ['status', 'UNPAID'],
                    ['tgl_akhir', '<=', date('Y-m-d')]
                ]);
            }, '>=', '1')->count();

        $UsageCount = 0;
        foreach ($Usages as $usage) {
            if ($usage->oneUsage != null) {
                $UsageCount += 1;
            }
        }

        $bulan = intval(date('m'));
        $chart = $this->chart();

        $pendapatan = $chart['pendapatan'];
        $beban = $chart['beban'];
        $surplus = $chart['surplus'];
        $SaldoPendapatanBulanini = $chart['pendapatan_bulan_ini'];
        $SaldoBebanBulanini = $chart['beban_bulan_ini'];
        $SaldoSurplusBulanini = $chart['surplus_bulan_ini'];

        $pros_pendapatan = $keuangan->ProsSaldo($pendapatan[$bulan - 1], $pendapatan[$bulan]);
        $pros_beban = $keuangan->ProsSaldo($beban[$bulan - 1], $beban[$bulan]);
        $pros_surplus = $keuangan->ProsSaldo($surplus[$bulan - 1], $surplus[$bulan]);

        $charts = json_encode($chart);

        $today = date('Y-m-d');
        $year = date('Y');
        $month = date('m');

        $title = 'Dashboard';
        $api = env('APP_API', 'http://localhost:8080');
        $business = Business::where('id', Session::get('business_id'))->first();
        return view('Dashboard.dashboard')->with(compact('Installation', 'SaldoPendapatanBulanini', 'SaldoBebanBulanini', 'SaldoSurplusBulanini', 'Tunggakan', 'UsageCount', 'Tagihan', 'title', 'charts', 'pendapatan', 'beban', 'surplus', 'pros_pendapatan', 'pros_beban', 'pros_surplus', 'business', 'api'));
    }


    private function chart()
    {
        $accounts = Account::where('business_id', Session::get('business_id'))->where(function ($query) {
            $query->where('lev1', '4')->orWhere('lev1', '5');
        })->with([
            'amount' => function ($query) {
                $query->where('tahun', date('Y'))->where('bulan', '<=', date('m'));
            }
        ])->get();

        $bulan = [];
        for ($i = 0; $i <= date('m'); $i++) {
            $bulan[$i] = [
                'pendapatan' => 0,
                'beban' => 0
            ];
        }

        foreach ($accounts as $account) {
            foreach ($account->amount as $amount) {
                $saldo = $amount->kredit - $amount->debit;
                if ($account->jenis_mutasi != 'kredit') {
                    $saldo = $amount->debit - $amount->kredit;
                }

                if ($account->lev1 == '4') {
                    $bulan[intval($amount->bulan)]['pendapatan'] += $saldo;
                } else {
                    $bulan[intval($amount->bulan)]['beban'] += $saldo;
                }
            }
        }

        $nama_bulan = [];
        $pendapatan = [];
        $beban = [];
        $surplus = [];
        $saldo_pendapatan_bulan_ini = 0;
        $saldo_beban_bulan_ini = 0;
        $saldo_surplus_bulan_ini = 0;
        foreach ($bulan as $key => $value) {
            $saldo_pendapatan = 0;
            $saldo_beban = 0;
            if ($key > 0) {
                $saldo_pendapatan = $value['pendapatan'] - $bulan[$key - 1]['pendapatan'];
                $saldo_beban = $value['beban'] - $bulan[$key - 1]['beban'];
            }

            $pendapatan[$key] = $saldo_pendapatan;
            $beban[$key] = $saldo_beban;
            $surplus[$key] = $saldo_pendapatan - $saldo_beban;

            $saldo_pendapatan_bulan_ini = $value['pendapatan'];
            $saldo_beban_bulan_ini = $value['beban'];
            $saldo_surplus_bulan_ini = $saldo_pendapatan_bulan_ini - $saldo_beban_bulan_ini;
            if ($key == 0) {
                $nama_bulan[$key] = 'Awal Tahun';
            } else {
                $tanggal = date('Y-m-d', strtotime(date('Y') . '-' . $key . '-01'));
                $nama_bulan[$key] = Tanggal::namaBulan($tanggal);
            }
        }

        return [
            'nama_bulan' => $nama_bulan,
            'pendapatan' => $pendapatan,
            'beban' => $beban,
            'surplus' => $surplus,
            'pendapatan_bulan_ini' => $saldo_pendapatan_bulan_ini,
            'beban_bulan_ini' => $saldo_beban_bulan_ini,
            'surplus_bulan_ini' => $saldo_surplus_bulan_ini,
        ];
    }

    public function installations()
    {
        $Permohonan = Installations::where('business_id', Session::get('business_id'))->where('status', '0')->orwhere('status', 'R')->with([
            'customer',
            'package'
        ])->get();
        $Pasang = Installations::where('business_id', Session::get('business_id'))->where('status', 'I')->with([
            'customer',
            'package'
        ])->get();
        $Aktif = Installations::where('business_id', Session::get('business_id'))->where('status', 'A')->with([
            'customer',
            'package'
        ])->get();

        return response()->json([
            'Permohonan' => $Permohonan,
            'Pasang' => $Pasang,
            'Aktif' => $Aktif
        ]);
    }

    public function usages()
    {
        $Usages = Installations::where('business_id', Session::get('business_id'))->where('status', 'A')->with([
            'customer',
            'package',
            'oneUsage' => function ($query) {
                $query->where('tgl_akhir', '<=', date('Y-m-d'));
            }
        ])->get();

        return response()->json([
            'Usages' => $Usages
        ]);
    }

    public function tunggakan()
    {
        $tunggakan = Installations::where('business_id', Session::get('business_id'))
            ->where('status', 'A')
            ->whereHas('usage', function (Builder $query) {
                $query->where('status', 'UNPAID')
                    ->whereDate('tgl_akhir', '<=', date('Y-m-d'));
            })
            ->with([
                'customer',
                'package',
                'usage' => function ($query) {
                    $query->where('status', 'UNPAID')
                        ->whereDate('tgl_akhir', '<=', date('Y-m-d'));
                }
            ])
            ->get();

        $tunggakan->each(function ($item) {
            $item->jumlah_tunggakan = $item->usage->count();
        });

        return response()->json([
            'tunggakan' => $tunggakan
        ]);
    }

 public function tagihan()
{
    $tgl_akhir = request()->get('tgl_akhir') ?: date('Y-m-d');

    $Tagihan = Usage::where('business_id', Session::get('business_id'))
        ->where([
            ['status', 'UNPAID'],
            ['tgl_akhir', '<', $tgl_akhir]
        ])
        ->with([
            'installation',
            'installation.customer',
            'installation.customer.village',
            'installation.package'
        ])
        ->get();

    $setting = Settings::where('business_id', Session::get('business_id'))->first();

    return response()->json([
        'Tagihan' => $Tagihan,
        'setting' => $setting,
    ]);
}


    public function sps($id)
    {
        $keuangan = new Keuangan;

        $thn = request()->input('tahun');
        $bln = request()->input('bulan');
        $hari = request()->input('hari');

        $tgl = $thn . '-' . $bln . '-' . $hari;

        $data = [
            'tahun' => $thn,
            'bulan' => $bln,
            'hari' => $hari,
            'judul' => 'Laporan Keuangan',
            'tgl' => Tanggal::tahun($tgl),
            'sub_judul' => 'Tahun ' . Tanggal::tahun($tgl),
            'cater' => request()->input('cater', null),
        ];

        if (request()->input('bulanan')) {
            $data['bulanan'] = true;
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }

        $data['dir'] = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '1']
        ])->first();

        $data['ket'] = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '8']
        ])->first();

        $data['bisnis'] = Business::where('id', Session::get('business_id'))->first();
        $data['tunggakan'] = Installations::where('business_id', Session::get('business_id'))
            ->where('status', 'A')
            ->where('id', $id)
            ->whereHas('usage', function ($query) {
                $query->where('status', 'UNPAID')
                    ->whereDate('tgl_akhir', '<=', date('Y-m-d'));
            }, '>=', 2)
            ->with([
                'customer',
                'settings',
                'package',
                'usage' => function ($query) {
                    $query->where('status', 'UNPAID')
                        ->whereDate('tgl_akhir', '<=', date('Y-m-d'));
                }
            ])
            ->first();
        $data['keuangan'] = $keuangan;
        $data['title'] = 'Cetak Tunggakan (SPS)';

        return view('Dashboard.partials.sps', $data);
    }

    public function Cetaktunggakan1($id)
    {
        $keuangan = new Keuangan;

        $thn = request()->input('tahun');
        $bln = request()->input('bulan');
        $hari = request()->input('hari');

        $tgl = $thn . '-' . $bln . '-' . $hari;

        $data = [
            'tahun' => $thn,
            'bulan' => $bln,
            'hari' => $hari,
            'judul' => 'Laporan Keuangan',
            'tgl' => Tanggal::tahun($tgl),
            'sub_judul' => 'Tahun ' . Tanggal::tahun($tgl),
            'cater' => request()->input('cater', null),
        ];

        if (request()->input('bulanan')) {
            $data['bulanan'] = true;
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }

        $data['dir'] = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '1']
        ])->first();

        $data['ket'] = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '8']
        ])->first();

        $data['bisnis'] = Business::where('id', Session::get('business_id'))->first();
        $data['tunggakan'] = Installations::where('business_id', Session::get('business_id'))
            ->where('status', 'A')
            ->where('id', $id)
            ->whereHas('usage', function ($query) {
                $query->where([
                    ['status', 'UNPAID'],
                    ['tgl_akhir', '<=', date('Y-m-d')],
                ]);
            })
            ->with([
                'customer',
                'settings',
                'package',
                'usage' => function ($query) {
                    $query->where([
                        ['status', 'UNPAID'],
                        ['tgl_akhir', '<=', date('Y-m-d')],
                    ])
                        ->orderBy('tgl_akhir', 'asc')
                        ->limit(1);
                }
            ])
            ->first();
        $data['keuangan'] = $keuangan;
        $data['title'] = 'Cetak Tunggakan (ST)';

        return view('Dashboard.partials.tunggakan1', $data);
    }

    public function Cetaktunggakan2($id)
    {
        $keuangan = new Keuangan;

        $thn = request()->input('tahun');
        $bln = request()->input('bulan');
        $hari = request()->input('hari');

        $tgl = $thn . '-' . $bln . '-' . $hari;

        $data = [
            'tahun' => $thn,
            'bulan' => $bln,
            'hari' => $hari,
            'judul' => 'Laporan Keuangan',
            'tgl' => Tanggal::tahun($tgl),
            'sub_judul' => 'Tahun ' . Tanggal::tahun($tgl),
            'cater' => request()->input('cater', null),
        ];

        if (request()->input('bulanan')) {
            $data['bulanan'] = true;
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }

        $data['dir'] = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '1']
        ])->first();

        $data['ket'] = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '8']
        ])->first();

        $data['bisnis'] = Business::where('id', Session::get('business_id'))->first();
        $data['tunggakan'] = Installations::where('business_id', Session::get('business_id'))
            ->where('status', 'A')
            ->where('id', $id)
            ->whereHas('usage', function ($query) {
                $query->where([
                    ['status', 'UNPAID'],
                    ['tgl_akhir', '<=', date('Y-m-d')],
                ]);
            })
            ->with([
                'customer',
                'settings',
                'package',
                'usage' => function ($query) {
                    $query->where([
                        ['status', 'UNPAID'],
                        ['tgl_akhir', '<=', date('Y-m-d')],
                    ])
                        ->orderBy('tgl_akhir', 'asc') // ambil tgl_akhir paling awal
                        ->limit(2); // hanya 1 data
                }
            ])
            ->first();
        $data['keuangan'] = $keuangan;
        $data['title'] = 'Cetak Tunggakan (SP)';

        return view('Dashboard.partials.tunggakan2', $data);
    }
}

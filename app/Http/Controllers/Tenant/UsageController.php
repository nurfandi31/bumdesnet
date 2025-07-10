<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Business;
use App\Models\Tenant\Customer;
use App\Models\Tenant\Installations;
use App\Models\Tenant\Package;
use App\Models\Tenant\Settings;
use App\Models\Tenant\Usage;
use App\Models\Tenant\Account;
use App\Models\Tenant\User;
use App\Utils\Keuangan;
use App\Utils\Tanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class UsageController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $bulan = request()->get('bulan') ?: date('m');
            $caterId = request()->get('cater') ?: '';
            $tgl_pakai = date('Y-m', strtotime(date('Y') . '-' . $bulan . '-01'));

            $rekening_denda = Account::where([
                ['kode_akun', '4.1.01.04'],
                ['business_id', Session::get('business_id')]
            ])->first();

            $pengaturan = Settings::where('business_id', Session::get('business_id'));
            $trx_settings = $pengaturan->first();

            $usages = Usage::select('usages.*')->where([
                ['usages.business_id', Session::get('business_id')],
                ['usages.tgl_pemakaian', 'LIKE', $tgl_pakai . '%']
            ]);

            if ($caterId != '') {
                $usages = $usages->where('usages.cater', $caterId);
            }

            $usages = $usages->with([
                'customers',
                'installation',
                'installation.transaction' => function ($query) use ($rekening_denda) {
                    $query->where('rekening_kredit', $rekening_denda->id);
                },
                'installation.village',
                'usersCater',
                'installation.package'
            ])->orderBy('created_at', 'DESC');
            return DataTables::eloquent($usages)
                ->addColumn('kode_instalasi_dengan_inisial', function ($usage) {
                    $kode = $usage->installation->kode_instalasi ?? '-';
                    $kelas = $usage->installation->package->kelas ?? '';
                    $hurufDepan = $kelas ? substr($kelas, 0, 1) : '';

                    return $kode . ($hurufDepan ? '-' . $hurufDepan : '');
                })

                ->addColumn('aksi', function ($usage) {
                    $edit = '<a href="/usages/' . $usage->id . '/edit" class="btn btn-warning btn-sm mb-1 mb-md-0 me-md-1"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
                    $delete = '<a href="#" data-id="' . $usage->id . '" class="btn btn-danger btn-sm Hapus_pemakaian"><i class="fas fa-trash-alt"></i></a>';
                    return '<div class="d-flex flex-column flex-md-row">' . $edit . $delete . '</div>';
                })
                ->addColumn('tgl_akhir', function ($usage) {
                    return Tanggal::tglIndo($usage->tgl_akhir);
                })
                ->editColumn('nominal', function ($usage) use ($trx_settings) {
                    $dendaPemakaianLalu = 0;
                    foreach ($usage->installation->transaction as $trx_denda) {
                        if ($trx_denda->tgl_transaksi < $usage->tgl_akhir) {
                            $dendaPemakaianLalu = $trx_denda->total;
                        }
                    }

                    $nominal = $usage->nominal + $dendaPemakaianLalu + $trx_settings->abodemen;
                    return number_format($nominal, 2);
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        $caters = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '5']
        ])->get();
        $user = auth()->user();
        $cater_id = ($user->jabatan == 5) ? $user->id : '';

        $title = 'Data Pemakaian';
        return view('penggunaan.index')->with(compact('title', 'caters', 'user', 'cater_id'));
    }

    public function barcode(Usage $usage)
    {
        $title = '';
        return view('penggunaan.barcode')->with(compact('title'));
    }
    public function create()
    {
        //create
    }

    public function generatePemakaian()
    {
        $instalasiList = Installations::where('business_id', Session::get('business_id'))
            ->whereIn('status', ['A', 'B', 'C'])
            ->with([
                'oneUsage',
                'package',
                'settings',
                'usage'
            ])->get();

        foreach ($instalasiList as $instal) {
            $masihAdaUnpaid = $instal->usage->contains(fn($u) => $u->status === 'UNPAID');
            if ($masihAdaUnpaid) {
                continue;
            }

            $usage_berjalan = $instal->oneUsage;
            if ($usage_berjalan) {
                $bulan_lalu = Carbon::parse($usage_berjalan->tgl_pemakaian)->format('Y-m');
                $bulan_ini = Carbon::now()->format('Y-m');
                if ($bulan_lalu === $bulan_ini) {
                    continue;
                }
            }
            $tanggal_awal = $usage_berjalan ? Carbon::now()->startOfMonth() : Carbon::now();
            $tanggal_akhir = Carbon::now()->endOfMonth();

            $selisih_hari = $tanggal_awal->diffInDays($tanggal_akhir) + 1;
            $jumlah_hari_bulan_ini = $tanggal_awal->daysInMonth;
            $jumlah_rasio = round($selisih_hari / $jumlah_hari_bulan_ini, 2);

            $harga = $instal->harga_paket ?? ($instal->package->harga ?? 0);
            if ($harga <= 0) {
                continue;
            }

            Usage::create([
                'business_id'    => Session::get('business_id'),
                'id_instalasi'   => $instal->id,
                'kode_instalasi' => $instal->kode_instalasi,
                'tgl_pemakaian'  => $tanggal_awal->format('Y-m-d'),
                'tgl_akhir'      => $tanggal_akhir->format('Y-m-d'),
                'awal'           => $tanggal_awal->format('d'),
                'akhir'          => $tanggal_akhir->format('d'),
                'jumlah'         => $jumlah_rasio,
                'cater'          => $instal->cater_id,
                'nominal'        => round($jumlah_rasio * $harga),
                'customer'       => $instal->customer_id,
                'created_at'     => now(),
            ]);
        }

        echo '<script>window.close()</script>';
        exit;
    }
    public function store(Request $request)
    {
        //simpan data
    }
    public function detailTagihan()
    {
        $keuangan = new Keuangan;
        $usages = Usage::where('business_id', Session::get('business_id'))->where('status', 'UNPAID')->with([
            'customers',
            'installation'
        ])->get();

        return [
            'label' => '<i class="fas fa-book"></i> ' . 'Detail Pemakaian Dengan Status <b>(UNPAID)</b>',
            'cetak' => view('penggunaan.partials.DetailTagihan', ['usages' => $usages])->render()
        ];
    }
    public function cetak_tagihan(Request $request)
    {
        $thn = $request->input('tahun');
        $bln = $request->input('bulan');
        $hari = $request->input('hari');

        $tgl = $thn . '-' . $bln . '-' . $hari;

        $rekening_denda = Account::where([
            ['kode_akun', '4.1.01.04'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $data = [
            'tahun' => $thn,
            'bulan' => $bln,
            'hari' => $hari,
            'judul' => 'Laporan Keuangan',
            'tgl' => Tanggal::tahun($tgl),
            'sub_judul' => 'Tahun ' . Tanggal::tahun($tgl),
            'cater' => $request->input('cater', null),
        ];

        $data['bisnis'] = Business::where('id', Session::get('business_id'))->first();

        $usagesQuery = Usage::where([
            ['business_id', Session::get('business_id')],
            ['tgl_pemakaian', 'LIKE', date('Y') . '-' . $request->bulan_tagihan . '%']
        ]);

        if ($request->cater != '') {
            $usagesQuery->where('cater', $request->cater);
        }

        $usages = $usagesQuery->with([
            'customers',
            'installation',
            'installation.village',
            'installation.transaction' => function ($query) use ($rekening_denda) {
                $query->where('rekening_kredit', $rekening_denda->id);
            },
            'usersCater',
            'installation.package'
        ])->get();

        $data['usages'] = $usages->sortBy([
            fn($a, $b) => strcmp($a->installation->village->dusun, $b->installation->village->dusun),
            fn($a, $b) => $a->installation->rt <=> $b->installation->rt,
            fn($a, $b) => strcmp($a->tgl_akhir, $b->tgl_akhir),
        ]);

        $data['pemakaian_cater'] = $usages->first()?->usersCater?->nama ?? '-';

        $data['title'] = 'Cetak Daftar Tagihan';

        \Carbon\Carbon::setLocale('id');
        $bulan_angka = $request->bulan_tagihan ?? '';
        $data['bulan'] = $bulan_angka
            ? \Carbon\Carbon::create($thn, $bulan_angka, 1)->translatedFormat('F Y')
            : '-';

        $view = view('penggunaan.partials.cetak1', $data)->render();
        $pdf = PDF::loadHTML($view)->setPaper('F4', 'portrait');
        return $pdf->stream();
    }
    public function cetak(Request $request)
    {
        $keuangan = new Keuangan;
        $id = $request->cetak;

        $data['bisnis'] = Business::where('id', Session::get('business_id'))->first();
        $data['usage'] = Usage::where('business_id', Session::get('business_id'))->whereIn('id', $id)->with(
            'customers',
            'installation',
            'usersCater',
            'installation.package'
        )->get();
        $data['jabatan'] = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '3']
        ])->first();
        $logo = $data['bisnis']->logo;
        $data['gambar'] = $logo;
        $data['keuangan'] = $keuangan;

        $view = view('penggunaan.partials.cetak', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }

    public function show(Usage $usage)
    {
        //
    }

    public function edit(Usage $usage)
    {
        $usages = Usage::where('business_id', Session::get('business_id'))->with([
            'customers',
            'installation'
        ])->get();
        $title = 'Data Pemakaian';
        return view('penggunaan.edit')->with(compact('title', 'usage', 'usages'));
    }

    public function update(Request $request, Usage $usage)
    {
        $data = $request->only([
            "tgl_akhir",
            "awal",
            "akhir",
            "jumlah",
        ]);

        $rules = [
            'awal'   => 'required',
            'akhir'   => 'required',
            'jumlah'   => 'required',
            'tgl_akhir' => 'required'
        ];
        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $tgl_akhir = \DateTime::createFromFormat('d/m/Y', $request->tgl_akhir)->format('Y-m-d');

        $usage->update([
            'tgl_akhir' =>
            Tanggal::tglNasional($request->tgl_akhir),
            'awal'      => $request->awal,
            'akhir'     => $request->akhir,
            'jumlah'    => $request->jumlah
        ]);

        return redirect('/usages')->with('berhasil', 'Usage berhasil diperbarui!');
    }

    public function destroy(Usage $usage)
    {
        $usage->delete();
        return redirect('/usages')->with('success', 'Pemakaian berhasil dihapus');
    }
}

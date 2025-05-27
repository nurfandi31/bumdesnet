<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Customer;
use App\Models\Installations;
use App\Models\Settings;
use App\Models\Usage;
use App\Models\User;
use App\Utils\Keuangan;
use App\Utils\Tanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class UsageController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $bulan = request()->get('bulan') ?: date('m');
            $cater = request()->get('cater') ?: '';

            $tgl_pakai = date('Y-m', strtotime(date('Y') . '-' . $bulan . '-01'));
            $usages = Usage::where([
                ['business_id', Session::get('business_id')],
                ['tgl_pemakaian', 'LIKE', $tgl_pakai . '%']
            ]);

            if ($cater != '') {
                $usages->where('cater', $cater);
            }

            $usages = $usages->with([
                'customers',
                'installation',
                'installation.village',
                'usersCater',
                'installation.package'
            ])->orderBy('created_at', 'DESC')->get();
            Session::put('usages', $usages);

            return DataTables::of($usages)
                ->addColumn('aksi', function ($usage) {
                    $edit = '<a href="/usages/' . $usage->id . '/edit" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                    $delete = '<a href="#" data-id="' . $usage->id . '" class="btn-sm btn-danger mx-1 Hapus_pemakaian"><i class="fas fa-trash-alt"></i></a>';

                    return $edit . $delete;
                })
                ->addColumn('tgl_akhir', function ($usage) {
                    return Tanggal::tglIndo($usage->tgl_akhir);
                })
                ->editColumn('nominal', function ($usage) {
                    return number_format($usage->nominal, 2);
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        $caters = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '5']
        ])->get();
        $title = 'Data Pemakaian';
        return view('penggunaan.index')->with(compact('title', 'caters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = Settings::where('business_id', Session::get('business_id'))->first();
        $customer = Installations::where('business_id', Session::get('business_id'))->with('customer')->orderBy('id', 'ASC')->get();
        $caters = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '5']
        ])->get();
        $usages = Usage::where('business_id', Session::get('business_id'))->get();
        $installasi = Installations::where('business_id', Session::get('business_id'))->orderBy('id', 'ASC')->get();
        $pilih_customer = 0;

        $title = 'Register Pemakaian';
        return view('penggunaan.create')->with(compact('customer', 'settings', 'pilih_customer', 'caters', 'title', 'usages'));
    }
    public function barcode(Usage $usage)
    {
        $title = '';
        return view('penggunaan.barcode')->with(compact('title'));
    }
    public function store(Request $request)
    {
        $data = $request->only('data')['data'];
        $installation = Installations::where([
            ['business_id', Session::get('business_id')],
            ['id', $data['id']]
        ])->with('package', 'customer')->first();
        $setting = Settings::where('business_id', Session::get('business_id'))->first();

        $harga = json_decode($installation->package->harga, true);

        $result = [];
        $block = json_decode($setting->block, true);
        foreach ($block as $index => $item) {
            preg_match_all('/\d+/', $item['jarak'], $matches);
            $start = (int)$matches[0][0];
            $end = (isset($matches[0][1])) ? $matches[0][1] : 200;

            for ($i = $start; $i <= $end; $i++) {
                $result[$i] = $index;
            }
        }

        $tglPakai = Tanggal::tglNasional($data['tgl_pemakaian']);
        $tglAkhir = date('Y-m', strtotime('+1 month', strtotime($tglPakai))) . '-' . str_pad($data['toleransi'], 2, '0', STR_PAD_LEFT);
        $index_harga = (isset($result[$data['jumlah']])) ? $result[$data['jumlah']] : end($result);

        $insert = [
            'business_id' => Session::get('business_id'),
            'tgl_pemakaian' => Tanggal::tglNasional($data['tgl_pemakaian']),
            'customer' => $data['customer'],
            'awal' => $data['awal'],
            'akhir' => $data['akhir'],
            'jumlah' => $data['jumlah'],
            'id_instalasi' => $data['id'],
            'tgl_akhir' => $tglAkhir,
            'nominal' => $harga[$index_harga] * $data['jumlah'],
            'cater' =>  $data['id_cater'],
            'user_id' => auth()->user()->id,
        ];

        // Simpan data
        $usage = Usage::create($insert);

        return response()->json([
            'success' => true,
            'msg' => 'Input Pemakain Berhasil ',
            'pemakaian' => $usage
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function carianggota(Request $request)
    {
        $query = $request->input('query');

        $customer = Customer::where('business_id', Session::get('business_id'))->join('installations', 'customers.id', 'installations.customer_id')
            ->where('customers.nama', 'LIKE', '%' . $query . '%')
            ->orwhere('installations.kode_instalasi', 'LIKE', '%' . $query . '%')->get();

        $data_customer = [];
        foreach ($customer as $cus) {
            $usage = Usage::where('business_id', Session::get('business_id'))->where('id_instalasi', $cus->id)->orderBy('created_at', 'DESC')->first();

            $data_customer[] = [
                'customer' => $cus,
                'usage' => $usage
            ];
        }


        return response()->json($data_customer);
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usage $usage)
    {
        $usages = Usage::where('business_id', Session::get('business_id'))->with([
            'customers',
            'installation'
        ])->get();
        $title = 'Data Pemakaian';
        return view('penggunaan.edit')->with(compact('title', 'usage', 'usages'));
    }

    /**
     * Update the specified resource in storage.
     */
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

        // Mengubah format tanggal dari d/m/Y ke Y-m-d
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


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usage $usage)
    {
        $usage->delete();
        return redirect('/usages')->with('success', 'Pemakaian berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Business;
use App\Models\Sop;
use App\Models\AkunLevel1;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

class SopController extends Controller
{
    public function index()
    {
        $api = env('APP_API', 'http://localhost:8080');
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $business = Business::where('id', $business_id)->first();
        $token = $business->token;

        $tampil_settings = $pengaturan->first();
        $title = 'Personalisasi Sop';
        return view('sop.index')->with(compact('title', 'api', 'business', 'token', 'tampil_settings'));
    }

    public function profil()
    {
        $business_id = Session::get('business_id');

        $business = Business::where('id', $business_id)->first();

        $title = 'Sop';

        return view('sop.partials.profil')->with(compact('title', 'business'));
    }

    public function pasang_baru()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        if (request()->ajax()) {
            $data['swit_tombol'] = request()->get('swit_tombol');
            $data['pasang_baru'] = request()->get('pasang_baru');

            $validate = Validator::make($data, [
                'swit_tombol' => 'required',
                'pasang_baru' => 'required',
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
            }

            $data['pasang_baru'] = str_replace(',', '', $data['pasang_baru']);
            $data['pasang_baru'] = str_replace('.00', '', $data['pasang_baru']);
            $data['pasang_baru'] = floatval($data['pasang_baru']);

            $pasang_baru = $data['pasang_baru'];

            if ($pengaturan->count() > 0) {
                $Settings = $pengaturan->update([
                    'swit_tombol' => $data['swit_tombol'],
                    'pasang_baru' => $pasang_baru,
                ]);
            } else {
                $Settings = Settings::create([
                    'business_id' => $business_id,
                    'swit_tombol' => $data['swit_tombol'],
                    'pasang_baru' => $pasang_baru,
                ]);
            }

            return response()->json([
                'success' => true,
                'Settings' => $Settings
            ], Response::HTTP_ACCEPTED);
        }

        $tampil_settings = $pengaturan->first();
        $title = 'Sop';
        return view('sop.partials.pasang_baru')->with(compact('title', 'tampil_settings'));
    }
    public function coa()
    {
        $title = "Chart Of Account (CoA)";

        return view('sop.partials.coa')->with(compact('title'));
    }

    public function akun_coa()
    {
        $akun1 = AkunLevel1::with([
            'akun2',
            'akun2.akun3',
            'akun2.akun3.accounts' => function ($query) {
                $query->where('business_id', Session::get('business_id'));
            }
        ])->get();

        $akun_id = 0;
        $data_coa = [];
        foreach ($akun1 as $akun) {
            $data_coa[$akun_id] = [
                'id' => $akun->kode_akun,
                'text' => $akun->kode_akun . '. ' . $akun->nama_akun
            ];

            $akun2_id = 0;
            foreach ($akun->akun2 as $akun2) {
                $data_coa[$akun_id]['children'][$akun2_id] = [
                    'id' => $akun2->kode_akun,
                    'text' => $akun2->kode_akun . '. ' . $akun2->nama_akun
                ];

                $akun3_id = 0;
                foreach ($akun2->akun3 as $akun3) {
                    $data_coa[$akun_id]['children'][$akun2_id]['children'][$akun3_id] = [
                        'id' => $akun3->kode_akun,
                        'text' => $akun3->kode_akun . '. ' . $akun3->nama_akun
                    ];

                    foreach ($akun3->accounts as $account) {
                        $data_coa[$akun_id]['children'][$akun2_id]['children'][$akun3_id]['children'][] = [
                            'id' => $account->kode_akun,
                            'text' => $account->kode_akun . '. ' . $account->nama_akun
                        ];
                    }

                    $akun3_id++;
                }
                $akun2_id++;
            }
            $akun_id++;
        }

        return response()->json($data_coa);
    }
    public function CreateCoa(Request $request)
    {
        $data = $request->only([
            'id_akun',
            'nama_akun'
        ]);

        $rek = Account::where('business_id', Session::get('business_id'))->where('kode_akun', $data['id_akun'])->count();
        if ($rek <= 0) {
            $kode_akun = explode('.', $data['id_akun']);
            $lev1 = $kode_akun[0];
            $lev2 = $kode_akun[1];
            $lev3 = str_pad($kode_akun[2], 2, '0', STR_PAD_LEFT);
            $lev4 = str_pad($kode_akun[3], 2, '0', STR_PAD_LEFT);

            $data['id_akun'] = $lev1 . '.' . $lev2 . '.' . $lev3 . '.' . $lev4;
            $nama_akun = preg_replace('/\d/', '', $data['nama_akun']);
            $nama_akun = preg_replace('/[^A-Za-z\s]/', '', $nama_akun);
            $nama_akun = trim($nama_akun);

            $insert = [
                'parent_id' => $lev1 . $lev2 . intval($lev3),
                'lev1' => $lev1,
                'lev2' => $lev2,
                'lev3' => $lev3,
                'lev4' => $lev4,
                'kode_akun' => $data['id_akun'],
                'nama_akun' => $nama_akun,
                'business_id' => Session::get('business_id')
            ];

            Account::create($insert);

            return response()->json([
                'success' => true,
                'id' => $insert['kode_akun'],
                'nama_akun' => $insert['kode_akun'] . '. ' . $nama_akun,
                'msg' => 'COA berhasil dibuat'
            ], 201);
        }
        return response()->json([
            'success' => false
        ], 201);
    }

    public function UpdateCoa(Request $request, $kode_akun)
    {
        $data = $request->only([
            'id_akun',
            'nama_akun'
        ]);


        $nama_akun = preg_replace('/\d/', '', $data['nama_akun']);
        $nama_akun = preg_replace('/[^A-Za-z\s]/', '', $nama_akun);
        $nama_akun = trim($nama_akun);

        $lev1 = explode('.', $data['id_akun'])[0];
        $lev2 = explode('.', $data['id_akun'])[1];
        $lev3 = explode('.', $data['id_akun'])[2];
        $lev4 = explode('.', $data['id_akun'])[3];

        $rekening = Account::where('business_id', Session::get('business_id'))->where('kode_akun', $kode_akun)->first();
        if ($rekening->nama_akun != $nama_akun && $rekening->kode_akun == $data['id_akun']) {
            Account::where('business_id', Session::get('business_id'))->where([
                ['kode_akun', $rekening->kode_akun],
                ['business_id', Session::get('business_id')]
            ])->update([
                'nama_akun' => $nama_akun,
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Akun dengan kode ' . $data['id_akun'] . ' berhasil diperbarui',
                'nama_akun' => $data['id_akun'] . '. ' . $nama_akun,
                'id' => $data['id_akun'],
            ]);
        }
    }
    public function deleteCoa(Request $request, $account)
    {
        $data = $request->only([
            'id_akun',
            'nama_akun'
        ]);

        $rekening = Account::where('business_id', Session::get('business_id'))->where([
            ['kode_akun', $account],
            ['business_id', Session::get('business_id')]
        ])->first();

        if ($rekening->kode_akun == $data['id_akun']) {
            Account::where('business_id', Session::get('business_id'))->where('id', $rekening->id)->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Akun dengan kode ' . $data['id_akun'] . ' berhasil dihapus',
                'id' => $data['id_akun'],
            ]);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Akun gagal dihapus'
        ]);
    }
    public function lembaga()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Business::where('id', $business_id);
        $business = Business::all();

        if (request()->ajax()) {
            $data['nama'] = request()->get('nama');
            $data['alamat'] = request()->get('alamat');
            $data['telpon'] = request()->get('telpon');
            $data['email'] = request()->get('email');

            $validate = Validator::make($data, [
                'nama' => 'required',
                'alamat' => 'required',
                'telpon'    => 'required',
                'email'       => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
            }

            if ($pengaturan->count() > 0) {
                $business = $pengaturan->update([
                    'nama' => $data['nama'],
                    'alamat' => $data['alamat'],
                    'telpon'    => $data['telpon'],
                    'email'       => $data['email'],
                ]);
            } else {
                $business = Business::create([
                    'nama' => $data['nama'],
                    'alamat' => $data['alamat'],
                    'telpon'    => $data['telpon'],
                    'email'       => $data['email'],
                ]);
            }

            return response()->json([
                'success' => true,
                'business' => $business
            ], Response::HTTP_ACCEPTED);
        }

        $tampil_settings = $pengaturan->first();
        $title = 'Sop';
        return view('sop.partials.lembaga')->with(compact('title', 'business', 'tampil_settings'));
    }

    public function sistem_instal()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        if (request()->ajax()) {
            $data['batas_tagihan'] = request()->get('batas_tagihan');
            $data['abodemen'] = request()->get('abodemen');
            $data['denda']  = request()->get('denda');
            $data['biaya_aktivasi'] = request()->get('biaya_aktivasi');

            $validate = Validator::make($data, [
                'batas_tagihan' => 'required',
                'abodemen'      => 'required',
                'denda'         => 'required',
                'biaya_aktivasi' => 'required',
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
            }

            $data['abodemen'] = str_replace(',', '', $data['abodemen']);
            $data['abodemen'] = str_replace('.00', '', $data['abodemen']);
            $data['abodemen'] = floatval($data['abodemen']);

            $data['denda'] = str_replace(',', '', $data['denda']);
            $data['denda'] = str_replace('.00', '', $data['denda']);
            $data['denda'] = floatval($data['denda']);

            $data['biaya_aktivasi'] = str_replace(',', '', $data['biaya_aktivasi']);
            $data['biaya_aktivasi'] = str_replace('.00', '', $data['biaya_aktivasi']);
            $data['biaya_aktivasi'] = floatval($data['biaya_aktivasi']);

            $abodemen = $data['abodemen'];
            $denda = $data['denda'];
            $biaya_aktivasi = $data['biaya_aktivasi'];


            if ($pengaturan->count() > 0) {
                $Settings = $pengaturan->update([
                    'batas_tagihan' => $data['batas_tagihan'],
                    'abodemen'      => $abodemen,
                    'denda'         => $denda,
                    'biaya_aktivasi' => $biaya_aktivasi,
                ]);
            } else {
                $Settings = Settings::create([
                    'business_id'   => $business_id,
                    'batas_tagihan' => $data['batas_tagihan'],
                    'abodemen'      => $abodemen,
                    'denda'         => $denda,
                    'biaya_aktivasi' => $biaya_aktivasi,
                ]);
            }

            return response()->json([
                'success' => true,
                'Settings' => $Settings
            ], Response::HTTP_ACCEPTED);
        }

        $tampil_settings = $pengaturan->first();
        $title = 'Sop';
        return view('sop.partials.sistem_instal')->with(compact('title', 'tampil_settings'));
    }

    public function pesan(Request $request)
    {
        $business_id = Session::get('business_id');

        Settings::where('business_id', $business_id)->update([
            'pesan_tagihan' => $request->tagihan,
            'pesan_pembayaran' => $request->pembayaran,
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Pesan whatsapp berhasil diubah'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $Settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $Settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Settings $Settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $Settings)
    {
        //
    }
}

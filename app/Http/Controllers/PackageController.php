<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Family;
use App\Models\Installations;
use App\Models\Package;
use App\Models\Region;
use App\Models\Transaction;
use App\Models\Usage;
use App\Models\Village;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;
use App\Utils\Keuangan;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $packages = Package::where('business_id', Session::get('business_id'))->get();

        $tampil_settings = $pengaturan->first();
        $title = 'Data Paket';
        return view('paket.index')->with(compact('title', 'packages', 'tampil_settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $package = Package::where('business_id', Session::get('business_id'))->get();

        $tampil_settings = $pengaturan->first();
        $title = 'Register Paket';
        return view('paket.create')->with(compact('package', 'title', 'tampil_settings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            "kelas",
            "blok",
            "abodemen",
            "denda"
        ]);
        $rules = [
            'kelas' => 'required'
        ];
        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $no = 0;
        $blok = [];
        foreach ($data['blok'] as $b) {
            $data['_blok'] = str_replace(',', '', $b);
            $data['_blok'] = str_replace('.00', '', $data['_blok']);
            $data['_blok'] = floatval($data['_blok']);

            $blok[$no] = $data['_blok'];
            $no++;
        }
        //catatan : data yang kesimpen di tb paket coloum abodemen hanya berfungsi untuk menampilkan default saat register instalasi
        $Package = Package::create([
            'business_id'   => Session::get('business_id'),
            'kelas'         => $request->kelas,
            'denda'         => $request->denda,
            'abodemen'      => $request->abodemen,
            'harga'         => json_encode($blok)
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Paket berhasil disimpan',
            'simpanpackage' => $Package
        ]);
    }

    public function block_paket()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        if (request()->ajax()) {

            $nama = request()->get('nama');
            $jarak = request()->get('jarak');

            $blok = [];
            for ($i = 0; $i < count($nama); $i++) {
                if ($nama[$i] == '' or $jarak[$i] == '') {
                    continue;
                }

                $blok[] = [
                    "nama" => $nama[$i],
                    "jarak" => $jarak[$i]
                ];
            }

            if ($pengaturan->count() > 0) {
                $Settings = $pengaturan->update([
                    'block' => json_encode($blok),
                ]);
            } else {
                $Settings = Settings::create([
                    'business_id' => $business_id,
                    'block' => json_encode($blok),
                ]);
            }

            return response()->json([
                'success' => true,
                'simpanpblock' => $Settings
            ]);
        }

        $tampil_settings = $pengaturan->first();
        $title = 'Sop';
        return view('paket.block_paket')->with(compact('title', 'tampil_settings'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $paket = Package::where('business_id', Session::get('business_id'))->get();

        $tampil_settings = $pengaturan->first();
        $title = 'Edit Paket';
        return view('paket.edit')->with(compact('title', 'package', 'tampil_settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $data = $request->only([
            "kelas",
            "blok",
            "abodemen",
            "denda"
        ]);
        $rules = [
            'kelas' => 'required'
        ];
        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $no = 0;
        $blok = [];
        foreach ($data['blok'] as $b) {
            $data['_blok'] = str_replace(',', '', $b);
            $data['_blok'] = str_replace('.00', '', $data['_blok']);
            $data['_blok'] = floatval($data['_blok']);

            $blok[$no] = $data['_blok'];
            $no++;
        }

        // Update data 
        $update = Package::where('id', $package->id)->update([
            'business_id'   => Session::get('business_id'),
            'kelas'         => $request->kelas,
            'abodemen'      => $request->abodemen,
            'denda'         => $request->denda,
            'harga'         => $blok
        ]);
        return response()->json([
            'success' => true,
            'msg' => 'Edit Paket berhasil disimpan',
            'Editpackage' => $update
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {

        // $package->delete();

        package::where('business_id', Session::get('business_id'))->where('id', $package->id)->delete();
        return response()->json([
            'success' => true,
            'msg' => 'Data Paket berhasil dihapus',
            'installation' => $package
        ]);
    }
}

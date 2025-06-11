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
        $packages = Package::where('business_id', Session::get('business_id'))->get();

        $title = 'Data Paket';
        return view('paket.index')->with(compact('title', 'packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $business_id = Session::get('business_id');
        $package = Package::where('business_id', Session::get('business_id'))->get();

        $title = 'Register Paket';
        return view('paket.modal')->with(compact('package', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            "kelas",
            "harga",
            "abodemen",
            "denda"
        ]);
        $rules = [
            'kelas' => 'required'
        ];

        $data['harga'] = str_replace(',', '', $data['harga']);
        $data['harga'] = str_replace('.00', '', $data['harga']);
        $data['harga'] = floatval($data['harga']);
        $data['abodemen'] = str_replace(',', '', $data['abodemen']);
        $data['abodemen'] = str_replace('.00', '', $data['abodemen']);
        $data['abodemen'] = floatval($data['abodemen']);
        $data['denda'] = str_replace(',', '', $data['denda']);
        $data['denda'] = str_replace('.00', '', $data['denda']);
        $data['denda'] = floatval($data['denda']);

        $harga      = $data['harga'];
        $abodemen   =  $data['abodemen'];
        $denda      = $data['denda'];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $Package = Package::create([
            'business_id'   => Session::get('business_id'),
            'kelas'         => $request->kelas,
            'denda'         => $denda,
            'abodemen'      => $abodemen,
            'harga'         => $harga
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Paket berhasil disimpan',
            'simpanpackage' => $Package
        ]);
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
    public function edit($id)
    {
        $paket = Package::find($id);

        if (!$paket) {
            return response()->json(['success' => false, 'message' => 'Paket tidak ditemukan']);
        }

        return response()->json(['success' => true, 'data' => $paket]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $data = $request->only([
            "kelas",
            "harga",
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

        $data['harga'] = str_replace(',', '', $data['harga']);
        $data['harga'] = str_replace('.00', '', $data['harga']);
        $data['harga'] = floatval($data['harga']);
        $data['abodemen'] = str_replace(',', '', $data['abodemen']);
        $data['abodemen'] = str_replace('.00', '', $data['abodemen']);
        $data['abodemen'] = floatval($data['abodemen']);
        $data['denda'] = str_replace(',', '', $data['denda']);
        $data['denda'] = str_replace('.00', '', $data['denda']);
        $data['denda'] = floatval($data['denda']);

        $harga      = $data['harga'];
        $abodemen   =  $data['abodemen'];
        $denda      = $data['denda'];
        // Update data 
        $update = Package::where('id', $package->id)->update([
            'business_id'   => Session::get('business_id'),
            'kelas'         => $request->kelas,
            'abodemen'      => $abodemen,
            'denda'         => $denda,
            'harga'         => $harga
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

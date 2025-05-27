<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Region;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $villages = Village::where('kategori', '!=', 0)->get();


        $title = 'Data Desa';
        return view('desa.index')->with(compact('title', 'villages'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $provinsi = Region::whereRaw('LENGTH(kode)=2')->get();

        $title = 'Register Desa';
        return view('desa.create')->with(compact('provinsi', 'title'));
    }

    public function generateAlamat($kode)
    {
        // Memecah kode menjadi bagian-bagian
        $kode_provinsi = substr($kode, 0, 2);
        $kode_kabupaten = substr($kode, 0, 5);
        $kode_kecamatan = substr($kode, 0, 8);
        $kode_desa = $kode;

        // Mengambil data wilayah berdasarkan kode
        $provinsi = Region::where('kode', $kode_provinsi)->first();
        $kabupaten = Region::where('kode', $kode_kabupaten)->first();
        $kecamatan = Region::where('kode', $kode_kecamatan)->first();
        $desa = Region::where('kode', $kode_desa)->first();

        $alamat = '';
        if ($provinsi) {
            $alamat .= 'Provinsi ' . ucfirst(strtolower($provinsi->nama));
        }
        if ($kabupaten) {
            $alamat .= ', ' . ucfirst(strtolower($kabupaten->nama));
        }
        if ($kecamatan) {
            $alamat .= ', Kecamatan ' . ucfirst(strtolower($kecamatan->nama));
        }
        if ($desa) {
            $alamat .= ', Desa ' . ucfirst(strtolower($desa->nama));
        }

        return response()->json([
            'success' => true,
            'alamat' => $alamat
        ]);
    }

    public function ambil_kab($kode)
    {
        $kabupaten = Region::where('kode', 'LIKE', $kode . '%')->whereRaw('length(kode)=5')->get();

        return response()->json([
            'success' => true,
            'data' => $kabupaten
        ]);
    }

    public function ambil_kec($kode)
    {
        $kecamatan = Region::where('kode', 'LIKE', $kode . '%')->whereRaw('length(kode)=8')->get();

        return response()->json([
            'success' => true,
            'data' => $kecamatan
        ]);
    }

    public function ambil_desa($kode)
    {
        $desa = Region::where('kode', 'LIKE', $kode . '%')->whereRaw('length(kode)>8')->get();

        return response()->json([
            'success' => true,
            'data' => $desa
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            "desa",
            "dusun",
            "alamat",
            "hp",
        ]);

        $rules = [
            'desa' => 'required',
            'dusun' => 'required',
            'alamat' => 'required',
            'hp' => 'required',
        ];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $region = Region::where('kode', $request->desa)->first();
        $business_id = str_pad(Session::get('business_id'), 3, '0', STR_PAD_LEFT);

        $jumlah_urutan = '0001';
        $queryDesa = Village::where('kode', 'LIKE', $business_id . '%')->whereRaw('LENGTH(kode)=8');
        if ($queryDesa->count() > 0) {
            $desa = $queryDesa->orderBy('kode', 'DESC')->first();
            $kode_desa = explode('.', $desa->kode);

            $urutan = end($kode_desa);
            $jumlah_urutan = str_pad(intval($urutan) + 1, 4, '0', STR_PAD_LEFT);
        }

        $kode = $business_id .  '.' . $jumlah_urutan;
        $cekDesa = $queryDesa->where('nama', $region->nama);
        if ($cekDesa->count() <= 0) {
            $Desa = Village::create([
                'kode' => $kode,
                'nama' => $region->nama,
                'alamat' => $request->alamat,
                'hp' => $request->hp
            ]);
        } else {
            $desa = $cekDesa->first();
            $kode = $desa->kode;
        }

        $kode_desa = $kode;
        $jumlah_urutan = '0001';
        $queryDusun = Village::where('kode', 'LIKE', $kode_desa . '%')->whereRaw('LENGTH(kode)>8');
        if ($queryDusun->count() > 0) {
            $dusun = $queryDusun->orderBy('kode', 'DESC')->first();
            $kode_dusun = explode('.', $dusun->kode);

            $urutan = end($kode_dusun);
            $jumlah_urutan = str_pad(intval($urutan) + 1, 4, '0', STR_PAD_LEFT);
        }

        $kode_dusun = $kode_desa .  '.' . $jumlah_urutan;
        $Dusun = Village::create([
            'kode' => $kode_dusun,
            'nama' => $region->nama,
            'dusun' => $request->dusun,
            'alamat' => $request->alamat,
            'kategori' => "1",
            'hp' => $request->hp
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Desa berhasil ditambahkan!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Village $village)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Village $village)
    {
        $title = 'Edit Desa';
        return view('desa.edit')->with(compact('village', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Village $village)
    {
        // Validasi input
        $validasi = [
            'kode' => 'required',
            'nama' => 'required',
            'dusun' => 'required',
            'alamat' => 'required',
            'hp' => 'required'
        ];

        $this->validate($request, $validasi);

        // Update data 
        Village::where('id', $village->id)->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'dusun' => $request->dusun,
            'alamat' => $request->alamat,
            'hp' => $request->hp
        ]);

        return redirect('/villages')->with('jsedit', 'Desa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Village $village)
    {
        // Menghapus customer berdasarkan id yang diterima
        $village->delete();

        // Redirect ke halaman customer dengan pesan sukses
        return redirect('/villages')->with('success', 'Desa berhasil dihapus');
    }
}

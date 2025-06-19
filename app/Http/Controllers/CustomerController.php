<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Customer;
use App\Models\Installations;
use App\Models\Family;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;
use App\Utils\Keuangan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $business_id = Session::get('business_id');

            return DataTables::eloquent(
                Customer::select([
                    'id',
                    'nik',
                    'nama',
                    'alamat',
                    'hp',
                    'email',
                ])->where([
                    'business_id', $business_id,
                    'Installations'
                ])
            )
                ->addColumn('aksi', function ($row) {
                    return $row->id;
                })
                ->toJson();
        }

        return view('cater.index', ['title' => 'Data Pelanggan / Calon Pelanggan']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desa = Village::all();
        $hubungan = Family::orderBy('id', 'ASC')->get();

        $title = 'Register Pelanggan / Calon Pelanggan';
        return view('pelanggan.create')->with(compact('desa', 'hubungan', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            "nik",
            "nama_lengkap",
            "nama_panggilan",
            "alamat",
            "tempat_lahir",
            "tgl_lahir",
            "jenis_kelamin",
            "pekerjaan",
            "no_telp",
            "email",
        ]);

        $rules = [
            'nik' => 'required|unique:customers',
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'pekerjaan' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
        ];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $create = Customer::create([
            'business_id' => Session::get('business_id'),
            'nik' => $request->nik,
            'nama' => $request->nama_lengkap,
            'nama_panggilan' => $request->nama_panggilan,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' =>  Tanggal::tglNasional($request->tgl_lahir),
            'jk' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
            'hp' => $request->no_telp,
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Pelanggan berhasil Ditambahkan!',
            'installation' => $create
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Menghapus customer berdasarkan id yang diterima

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $desa = Village::all();
        $hubungan = Family::orderBy('id', 'ASC')->get();

        $title = 'Edit Pelanggan';
        return view('pelanggan.edit')->with(compact('desa', 'hubungan', 'customer', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // Validasi input
        $data = $request->only([
            "nik",
            "nama_lengkap",
            "nama_panggilan",
            "alamat",
            "tempat_lahir",
            "tgl_lahir",
            "jenis_kelamin",
            "pekerjaan",
            "no_telp",
            "email",
        ]);
        $rules = [
            'nik' => 'required',
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'pekerjaan' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
        ];

        if ($request->nik != $customer->nik) {
            $validasi['nik'] = 'required|unique:customers';
        }

        $validate = Validator::make(
            $data,
            $rules
        );
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        // Update data customer
        $update = Customer::where('business_id', Session::get('business_id'))->where('id', $customer->id)->update([
            'nik' => $request->nik,
            'nama' => $request->nama_lengkap,
            'nama_panggilan' => $request->nama_panggilan,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jk' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
            'hp' => $request->no_telp,
            'email' => $request->email
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Pelanggan berhasil diperbarui!',
            'Customer' => $update
        ]);

        // return redirect('/customers')->with('success', 'Pelanggan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Customer $customer)
    {
        // Cek jika customer masih memiliki status di tabel installations
        $Cek_Instal = Installations::where('business_id', Session::get('business_id'))->where('customer_id', $customer->id)->exists();

        if ($Cek_Instal) {
            return response()->json([
                'success' => false, // Operasi gagal karena ada status Pemakaian
                'msg' => 'Customer tidak dapat dihapus karena masih memiliki status Pemakaian.',
            ]);
        }

        // Hapus customer
        $customer->delete();

        return response()->json([
            'success' => true, // Operasi berhasil
            'msg' => 'Customer berhasil dihapus.',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $business_id = request()->session()->get('business_id');
        $rekening = Account::where('business_id', $business_id)->get();

        $title = 'Rekening';
        return view('rekening.index')->with(compact('title','business_id','rekening'));

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
        $data = $request->only([
            "kode_akun",
            "nama_akun",
            "jenis_mutasi",
        ]);

        $validate = Validator::make($data, [
            'kode_akun' =>
            [
                'required',
                Rule::unique('accounts')->where(function ($query) {
                    return $query->where('business_id', request()->session()->get('business_id'));
                }),
            ],
            'jenis_mutasi' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'msg' => 'Kesalahan validasi',
                'validate' => $validate->errors(),
            ]);
        }

        $kode_akun = explode('.', $data['kode_akun']);
        $lev1 = intval($kode_akun[0]);
        $lev2 = intval($kode_akun[1]);
        $lev3 = intval($kode_akun[2]);
        $lev4 = intval($kode_akun[3]);

        $account = Account::create([
            'business_id' => request()->session()->get('business_id'),
            'lev1' => $lev1,
            'lev2' => $lev2,
            'lev3' => $lev3,
            'lev4' => $lev4,
            'kode_akun' => $data['kode_akun'],
            'nama_akun' => $data['nama_akun'],
            'jenis_mutasi' => $data['jenis_mutasi'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $account,
            'msg' => 'Rekening berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        return response()->json([
            'success' => true,
            'data' => $account
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $data = $request->only([
            "kode_akun",
            "nama_akun",
            "jenis_mutasi",
        ]);

        $validate = Validator::make($data, [
            'kode_akun' => array_filter([
                'required',
                $request->kode_akun != $account->kode_akun
                    ? Rule::unique('accounts')->where(function ($query) {
                        return $query->where('business_id', request()->session()->get('business_id'));
                    })
                    : null,
            ]),
            'jenis_mutasi' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'msg' => 'Kesalahan validasi',
                'validate' => $validate->errors(),
            ]);
        }

        $kode_akun = explode('.', $data['kode_akun']);
        $lev1 = intval($kode_akun[0]);
        $lev2 = intval($kode_akun[1]);
        $lev3 = intval($kode_akun[2]);
        $lev4 = intval($kode_akun[3]);

        $update = Account::where('id', $account->id)->update([
            'lev1' => $lev1,
            'lev2' => $lev2,
            'lev3' => $lev3,
            'lev4' => $lev4,
            'kode_akun' => $data['kode_akun'],
            'nama_akun' => $data['nama_akun'],
            'jenis_mutasi' => $data['jenis_mutasi'],
        ]);

        return response()->json([
            'success' => true,
            'data' => Account::where('id', $account->id)->first(),
            'msg' => 'Rekening berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $delete = Account::where('id', $account->id)->delete();

        return response()->json([
            'success' => true,
            'data' => $account,
            'msg' => 'Rekening berhasil dihapus.'
        ]);
    }
}

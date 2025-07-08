<?php

namespace App\Http\Controllers;

use App\Models\Cater;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class CaterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $business_id = Session::get('business_id');

            return DataTables::eloquent(
                User::select([
                    'id',
                    'nama',
                    'alamat',
                    'telpon',
                    'username'
                ])->where([
                    ['business_id', $business_id],
                    ['jabatan', '5']
                ])
            )
                ->addColumn('aksi', function ($row) {
                    return $row->id;
                })
                ->toJson();
        }

        return view('cater.index', ['title' => 'Data Marketing']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Register Sales';
        return view('cater.create')->with(compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            "nama",
            "alamat",
            "telpon",
            "username",
            "password",
            "jenis_kelamin"
        ]);

        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'jenis_kelamin' => 'required'
        ];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $create = User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telpon' => $request->telpon,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'jenis_kelamin' => $request->jenis_kelamin,
            'business_id' => Session::get('business_id'),
            'jabatan' => '5',
            'akses_menu' => '[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31]'
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Daftar  Sales berhasil disimpan',
            'cater' => $create
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cater $cater)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $cater)
    {
        $title = 'Edit Sales';
        return view('cater.edit')->with(compact('title', 'cater'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $cater)
    {
        $data = $request->only([
            'nama',
            'jenis_kelamin',
            'alamat',
            'telpon',
            'username',
            'password',
        ]);

        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'username' => 'required',
            'jenis_kelamin' => 'required'
        ];

        if ($request->username != $cater->username) {
            $rules['username'] = 'required|unique:users';
        }

        $request->validate($rules);
        $password = $cater->password;
        if ($request->password) {
            $password = Hash::make($request->password);
        }

        User::where('id', $cater->id)->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'telpon' => $request->telpon,
            'username' => $request->username,
            'password' => $password,
        ]);

        return redirect('/caters')->with('jsedit', 'Sales berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $cater)
    {
        User::where('id', $cater->id)->delete();
        return redirect('/caters')->with('success', 'Sales berhasil dihapus');
    }
}

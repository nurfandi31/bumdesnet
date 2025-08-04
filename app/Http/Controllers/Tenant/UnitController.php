<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Product;
use App\Models\Tenant\Unit;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $units = Unit::orderBy('created_at', 'desc');
            return DataTables::eloquent($units)->addIndexColumn()
                ->make(true);
        }

        $title = "Daftar Satuan";
        return view('unit.index')->with(compact('title'));
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
        $request->validate([
            'nama_satuan' => 'required|unique:units,name',
            'nama_singkat' => 'required'
        ]);

        $unit = Unit::create([
            'name' => $request->nama_satuan,
            'short_name' => $request->nama_singkat
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Satuan berhasil ditambahkan',
            'data' => $unit
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $rule = [
            'nama_satuan' => 'required',
            'nama_singkat' => 'required',
        ];

        if ($request->nama_satuan != $unit->name) {
            $rule['nama_satuan'] = 'required|unique:units,name';
        }

        $request->validate($rule, [
            'nama_satuan.unique' => 'Kategori sudah ada'
        ]);

        Unit::where('id', $unit->id)->update([
            'name' => $request->nama_satuan,
            'short_name' => $request->nama_singkat
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Satuan berhasil diubah',
            'data' => $unit
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        Product::where('unit_id', $unit->id)->delete();

        return response()->json([
            'success' => true,
            'msg' => 'Satuan berhasil dihapus',
            'data' => $unit
        ]);
    }
}

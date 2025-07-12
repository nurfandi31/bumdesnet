<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Category;
use App\Models\Tenant\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $category = Category::with('products');
            return DataTables::eloquent($category)->addIndexColumn()
                ->addColumn('product_count', function ($row) {
                    return count($row->products);
                })->make(true);
        }

        $title = 'Daftar Kategori';
        return view('category.index')->with(compact('title'));
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
            'nama_kategori' => 'required|unique:categories,name'
        ]);

        $category = Category::create([
            'name' => $request->nama_kategori
        ]);
        return response()->json([
            'success' => true,
            'msg' => 'Kategori berhasil ditambahkan',
            'data' => $category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rule = [
            'nama_kategori' => 'required'
        ];

        if ($request->name != $category->name) {
            $rule['nama_kategori'] = 'required|unique:categories,name';
        }

        $request->validate($rule, [
            'nama_kategori.unique' => 'Kategori sudah ada'
        ]);

        Category::where('id', $category->id)->update([
            'name' => $request->nama_kategori
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Kategori berhasil diubah',
            'data' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Product::where('category_id', $category->id)->delete();

        return response()->json([
            'success' => true,
            'msg' => 'Kategori berhasil dihapus',
            'data' => $category
        ]);
    }
}

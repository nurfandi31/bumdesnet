<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Category;
use App\Models\Tenant\Product;
use App\Models\Tenant\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $products = Product::with('category', 'variations');
            return DataTables::eloquent($products)
                ->addIndexColumn()
                ->editColumn('harga_beli', function ($row) {
                    return "Rp. " . number_format($row->harga_beli, 2);
                })
                ->editColumn('harga_jual', function ($row) {
                    return "Rp. " . number_format($row->harga_jual, 2);
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="' . $row->id . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="' . $row->id . '" style="">
                                        <a class="dropdown-item show-product" href="#">Lihat</a>
                                        <a class="dropdown-item edit-product" href="/products/' . $row->id . '/edit">Edit</a>
                                        <a class="dropdown-item delete-product" href="#">Hapus</a>
                                    </div>
                                </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $title = 'Daftar Produk';
        return view('product.index')->with(compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        $title = 'Tambah Produk';
        return view('product.create')->with(compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "kategori" => "required",
            "nama_produk" => "required",
            "harga_beli" => "required",
            "harga_jual" => "required",
        ]);

        $gambarName = '';
        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);

            $gambar = $request->file('gambar');
            $gambarName = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('storage/product'), $gambarName);
        }

        $product = Product::create([
            "category_id" => $request->kategori,
            "name" => $request->nama_produk,
            "harga_beli" => str_replace(',', '', $request->harga_beli),
            "harga_jual" => str_replace(',', '', $request->harga_jual),
            "deskripsi" => $request->deskripsi,
            "gambar" => $gambarName,
            'stok' => 0
        ]);

        if (count($request->nama_varian) > 0) {
            $variant = [];
            foreach ($request->nama_varian as $key => $value) {
                $variant[] = [
                    'product_id' => $product->id,
                    'name' => $value,
                    'harga_beli' => str_replace(',', '', $request->harga_beli_varian[$key]),
                    'harga_jual' => str_replace(',', '', $request->harga_jual_varian[$key]),
                    'stok' => 0
                ];
            }

            ProductVariation::insert($variant);
        }

        return redirect('/products')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        $title = 'Edit Produk ' . $product->name;
        return view('product.edit')->with(compact('title', 'product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            "kategori" => "required",
            "nama_produk" => "required",
            "harga_beli" => "required",
            "harga_jual" => "required",
        ]);

        $gambarName = $product->gambar;
        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);

            $gambar = $request->file('gambar');
            $gambarName = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('storage/product'), $gambarName);

            if ($product->gambar && $product->gambar != 'default.png') {
                Storage::delete('product/' . $product->gambar);
            }
        }

        Product::where('id', $product->id)->update([
            "category_id" => $request->kategori,
            "name" => $request->nama_produk,
            "harga_beli" => str_replace(',', '', $request->harga_beli),
            "harga_jual" => str_replace(',', '', $request->harga_jual),
            "deskripsi" => $request->deskripsi,
            "gambar" => $gambarName
        ]);

        $deleteVariation = [];
        foreach ($request->id_varian as $index => $id) {
            if (empty($request->nama_varian[$index])) {
                $deleteVariation[] = $request->id_varian[$index];
                continue;
            }

            if (!empty($id)) {
                ProductVariation::where('id', $id)->update([
                    "name" => $request->nama_varian[$index],
                    "harga_beli" => str_replace(',', '', $request->harga_beli_varian[$index]),
                    "harga_jual" => str_replace(',', '', $request->harga_jual_varian[$index])
                ]);
            } else {
                ProductVariation::create([
                    "product_id" => $product->id,
                    "name" => $request->nama_varian[$index],
                    "harga_beli" => str_replace(',', '', $request->harga_beli_varian[$index]),
                    "harga_jual" => str_replace(',', '', $request->harga_jual_varian[$index]),
                    "stok" => 0
                ]);
            }
        }

        ProductVariation::where('product_id', $product->id)->whereIn('id', $deleteVariation)->delete();
        return redirect('/products')->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        if ($product->gambar && $product->gambar != 'default.png') {
            Storage::delete('product/' . $product->gambar);
        }

        ProductVariation::where('product_id', $product->id)->delete();

        return response()->json([
            'success' => true,
            'msg' => 'Produk berhasil dihapus',
            'data' => $product
        ]);
    }
}

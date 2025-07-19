<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Pairing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Installations;
use App\Models\Tenant\Product;
use App\Models\Tenant\ProductVariation;
use App\Models\Tenant\Transaction;
use App\Utils\Tanggal;
use Exception;
use Illuminate\Support\Facades\DB;

class PairingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Daftar Pemasangan Baru';
        return view('pairing.index')->with(compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $installations = Installations::where('pairing', '0')->with([
            'customer'
        ])->get();

        $title = 'Tambah Pemasangan Baru';
        return view('pairing.create')->with(compact('title', 'installations'));
    }

    public function searchProduct()
    {
        $queryRequest = request()->get('query');

        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->where(function ($query) use ($queryRequest) {
                $query->where('products.name', 'like', '%' . $queryRequest . '%')
                    ->orWhere('categories.name', 'like', '%' . $queryRequest . '%');
            })
            ->where('stok', '>', 0)
            ->select('products.*', 'categories.name as category_name')
            ->with([
                'variations' => function ($query) {
                    $query->where('stok', '>', 0);
                }
            ])
            ->orderBy('products.name', 'asc')
            ->orderBy('categories.name', 'asc')
            ->get();

        $countNumber = 1;
        $listProducts = [];
        foreach ($products as $product) {
            if ($countNumber == 10) {
                break;
            }

            if (count($product->variations) > 0) {
                foreach ($product->variations as $variation) {
                    $listProducts[] = [
                        'id' => $product->id,
                        'variation_id' => $variation->id,
                        'name' => $product->name . ' - ' . $variation->name,
                        'harga_beli' => $variation->harga_beli,
                        'harga_jual' => $variation->harga_jual,
                        'category_name' => $product->category_name,
                        'stok' => $variation->stok,
                        'deskripsi' => $variation->deskripsi
                    ];
                }
            } else {
                $listProducts[] = [
                    'id' => $product->id,
                    'variation_id' => null,
                    'name' => $product->name,
                    'harga_beli' => $product->harga_beli,
                    'harga_jual' => $product->harga_jual,
                    'category_name' => $product->category_name,
                    'stok' => $product->stok,
                    'deskripsi' => $product->deskripsi
                ];
            }

            $countNumber++;
        }

        return response()->json($listProducts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "instalasi" => "required",
            "tanggal_pemasangan" => "required",
            "total_qty" => "required",
            "total_harga_jual" => "required",
            "total_subtotal" => "required",
        ]);

        DB::beginTransaction();

        try {
            $product = Product::whereIn('id', $request->product_id)->get()->pluck([], 'id')->toArray();
            $variation = ProductVariation::whereIn('id', $request->variation_id)->get()->pluck([], 'id')->toArray();

            $hpp = 0;
            $insertPairing = [];
            for ($i = 0; $i < count($request->product_id); $i++) {
                $product_id = $request->product_id[$i];
                $variation_id = $request->variation_id[$i];
                $jumlah = $request->jumlah[$i];
                $harga_jual = intval(str_replace(',', '', $request->harga_jual[$i]));
                $subtotal = intval(str_replace(',', '', $request->subtotal[$i]));

                $insertPairing[] = [
                    'installation_id' => $request->instalasi,
                    "product_id" => $product_id,
                    "product_variation_id" => is_numeric($variation_id) ? $variation_id : 0,
                    "tgl_pemasangan" => Tanggal::tglNasional($request->tanggal_pemasangan),
                    "harga" => $harga_jual,
                    "jumlah" => $jumlah,
                    "total" => $subtotal,
                ];

                if (is_numeric($variation_id)) {
                    $harga_beli = $variation[$variation_id]['harga_beli'];
                    ProductVariation::where('id', $variation_id)->update(['stok' => $variation[$variation_id]['stok'] - $jumlah]);
                } else {
                    $harga_beli = $product[$product_id]['harga_beli'];
                    Product::where('id', $product_id)->update(['stok' => $product[$product_id]['stok'] - $jumlah]);
                }

                $hpp += ($harga_jual - $harga_beli) * $jumlah;
            }

            Pairing::insert($insertPairing);

            $trx_id = 'PR-' . rand(1000, 9999);
            Transaction::create([
                'business_id' => '1',
                'tgl_transaksi' => Tanggal::tglNasional($request->tanggal_pemasangan),
                'rekening_debit' => 70,
                'rekening_kredit' => 12,
                'user_id' => auth()->user()->id,
                'usage_id' => '0',
                'installation_id' => $request->instalasi,
                'purchase_id' => '0',
                'total' => intval(str_replace(',', '', $request->total_subtotal - $hpp)),
                'transaction_id' => $trx_id,
                'relasi' => '-',
                'keterangan' => '-',
                'urutan' => '0',
            ]);

            Transaction::create([
                'business_id' => '1',
                'tgl_transaksi' => Tanggal::tglNasional($request->tanggal_pemasangan),
                'rekening_debit' => 70,
                'rekening_kredit' => 51,
                'user_id' => auth()->user()->id,
                'usage_id' => '0',
                'installation_id' => $request->instalasi,
                'purchase_id' => '0',
                'total' => intval(str_replace(',', '', $hpp)),
                'transaction_id' => $trx_id,
                'relasi' => '-',
                'keterangan' => '-',
                'urutan' => '0',
            ]);

            Installations::where('id', $request->instalasi)->update([
                'pairing' => '1',
            ]);

            DB::commit();

            return redirect('/pairings')->with('success', 'Pemasangan berhasil disimpan!');
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pairing $pairing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pairing $pairing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pairing $pairing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pairing $pairing)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Account;
use App\Models\Tenant\Product;
use App\Models\Tenant\ProductPurchase;
use App\Models\Tenant\ProductVariation;
use App\Models\Tenant\Purchase as TenantPurchase;
use App\Models\Tenant\Transaction;
use App\Utils\Tanggal;
use Exception;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Daftar Pembelian';
        return view('purchase.index')->with(compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Account::where('kode_akun', 'like', '1.1.01%')->get();

        $title = 'Tambah Pembelian';
        return view('purchase.create')->with(compact('title', 'accounts'));
    }

    public function searchProduct()
    {
        $query = request()->get('query');

        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.name', 'like', '%' . $query . '%')
            ->orWhere('categories.name', 'like', '%' . $query . '%')
            ->select('products.*', 'categories.name as category_name')
            ->with('variations')
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
            "tanggal_pembelian" => "required",
            "nomor_ref" => "required",
            "total_qty" => "required",
            "total_harga_beli" => "required",
            "total_subtotal" => "required"
        ]);

        DB::beginTransaction();

        try {
            $status = $request->status;

            $purchase = TenantPurchase::create([
                "user_id" => auth()->user()->id,
                "no_ref" => $request->nomor_ref,
                "tgl_beli" => Tanggal::tglNasional($request->tanggal_pembelian),
                "total_harga_beli" => intval(str_replace(',', '', $request->total_harga_beli)),
                "total_qty" => $request->total_qty,
                "total" => intval(str_replace(',', '', $request->total_subtotal)),
                "status" => $status,
                "catatan" => $request->catatan,
            ]);

            $productPurchase = [];
            for ($i = 0; $i < count($request->product_id); $i++) {
                $productPurchase[] = [
                    "product_id" => $request->product_id[$i],
                    "product_variation_id" => is_numeric($request->variation_id[$i]) ? $request->variation_id[$i] : 0,
                    "purchase_id" => $purchase->id,
                    "harga_beli" => intval(str_replace(',', '', $request->harga_beli[$i])),
                    "qty" => $request->jumlah[$i],
                    "total" => intval(str_replace(',', '', $request->subtotal[$i]))
                ];

                if (is_numeric($request->variation_id[$i])) {
                    dd($request->variation_id[$i]);
                    $product = ProductVariation::find($request->variation_id[$i]);
                    $product->stok += $request->jumlah[$i];
                    $product->save();
                } else {
                    $product = Product::find($request->product_id[$i]);
                    $product->stok += $request->jumlah[$i];
                    $product->save();
                }
            }

            ProductPurchase::insert($productPurchase);

            if ($status != 'belum_dibayar') {
                Transaction::create([
                    'business_id' => '1',
                    'tgl_transaksi' => Tanggal::tglNasional($request->tanggal_pembelian),
                    'rekening_debit' => '12',
                    'rekening_kredit' => $request->sumber_dana,
                    'user_id' => auth()->user()->id,
                    'usage_id' => '0',
                    'installation_id' => '0',
                    'purchase_id' => $purchase->id,
                    'total' => intval(str_replace(',', '', $request->jumlah_bayar)),
                    'transaction_id' => $request->nomor_ref,
                    'relasi' => '-',
                    'keterangan' => $request->catatan,
                    'urutan' => '0',
                ]);
            }

            DB::commit();

            return redirect('/purchases')->with('success', 'Pembelian berhasil disimpan!');
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}

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
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $purchases = TenantPurchase::with([
                'transactions' => function ($query) {
                    $query->where('rekening_debit', '12');
                },
                'product_purchases',
                'product_purchases.product',
                'product_purchases.variation',
            ]);

            return DataTables::eloquent($purchases)
                ->addIndexColumn()
                ->addColumn('dibayar', function ($row) {
                    $sum_trx = 0;
                    foreach ($row->transactions as $trx) {
                        $sum_trx += $trx->total;
                    }

                    return $sum_trx;
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="' . $row->id . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="' . $row->id . '" style="">
                                        <a class="dropdown-item show-purchase" href="#">Lihat</a>
                                        <a class="dropdown-item edit-purchase" href="/purchases/' . $row->id . '/edit">Edit</a>
                                        <a class="dropdown-item delete-purchase" href="#">Hapus</a>
                                    </div>
                                </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

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
                    $product = ProductVariation::find($request->variation_id[$i]);
                    $product->stok += $request->jumlah[$i];
                    $product->save();
                }

                $product = Product::find($request->product_id[$i]);
                $product->stok += $request->jumlah[$i];
                $product->save();
            }

            ProductPurchase::insert($productPurchase);

            if ($status != 'belum_dibayar' && intval(str_replace(',', '', $request->jumlah_bayar)) > 0) {
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
    public function show(TenantPurchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenantPurchase $purchase)
    {
        $accounts = Account::where('kode_akun', 'like', '1.1.01%')->get();

        $title = 'Edit Pembelian Nomor ' . $purchase->no_ref;
        return view('purchase.edit')->with(compact('title', 'purchase', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TenantPurchase $purchase)
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

            TenantPurchase::where('id', $purchase->id)->update([
                "user_id" => auth()->user()->id,
                "no_ref" => $request->nomor_ref,
                "tgl_beli" => Tanggal::tglNasional($request->tanggal_pembelian),
                "total_harga_beli" => intval(str_replace(',', '', $request->total_harga_beli)),
                "total_qty" => $request->total_qty,
                "total" => intval(str_replace(',', '', $request->total_subtotal)),
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

                $penambahanStok = $request->jumlah[$i];
                if ($request->product_purchase_id[$i]) {
                    $oldPproductPurchase = ProductPurchase::where('id', $request->product_purchase_id[$i])->first();
                    $penambahanStok = $request->jumlah[$i] - $oldPproductPurchase->qty;
                }

                if (is_numeric($request->variation_id[$i])) {
                    $product = ProductVariation::find($request->variation_id[$i]);
                    $product->stok += $penambahanStok;
                    $product->save();
                } else {
                    $product = Product::find($request->product_id[$i]);
                    $product->stok += $penambahanStok;
                    $product->save();
                }
            }

            ProductPurchase::where('purchase_id', $purchase->id)->delete();
            ProductPurchase::insert($productPurchase);

            if ($status != 'belum_dibayar' && intval(str_replace(',', '', $request->jumlah_bayar)) > 0) {
                Transaction::where('purchase_id', $purchase->id)->delete();
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
     * Remove the specified resource from storage.
     */
    public function destroy(TenantPurchase $purchase)
    {
        foreach ($purchase->product_purchases as $product_purchase) {
            if ($product_purchase->product_variation_id > 0) {
                $product = ProductVariation::find($product_purchase->product_variation_id);
                $product->stok -= $product_purchase->qty;
                $product->save();
            } else {
                $product = Product::find($product_purchase->product_id);
                $product->stok -= $product_purchase->qty;
                $product->save();
            }
        }

        ProductPurchase::where('purchase_id', $purchase->id)->delete();
        Transaction::where('purchase_id', $purchase->id)->delete();
        TenantPurchase::where('id', $purchase->id)->delete();

        return response()->json([
            'success' => true,
            'msg' => 'Pembelian berhasil dihapus',
            'data' => $purchase
        ]);
    }
}

<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Maintenance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Installations;
use App\Models\Tenant\Product;
use App\Models\Tenant\ProductVariation;
use App\Models\Tenant\Transaction;
use App\Utils\Tanggal;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $maintenance = Transaction::where([
                ['rekening_debit', '71'],
                ['rekening_kredit', '12'],
                ['transaction_id', 'like', 'MT-%']
            ])->with([
                'maintenance.product',
                'maintenance.productVariation',
                'maintenance.pairing.product',
                'maintenance.pairing.productVariation',
                'Installations',
                'Installations.customer',
            ]);

            return DataTables::eloquent($maintenance)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="' . $row->id . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="' . $row->id . '" style="">
                                        <a class="dropdown-item show-maintenance" href="#">Lihat</a>
                                        <a class="dropdown-item delete-maintenance" href="#">Hapus</a>
                                    </div>
                                </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $title = "Daftar Maintenance";
        return view('maintenance.index')->with(compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $installations = Installations::where('pairing', '1')->with([
            'customer',
            'pairings.product',
            'pairings.product.category',
            'pairings.productVariation'
        ])->get();

        $title = "Tambah Maintenance";
        return view('maintenance.create')->with(compact('title', 'installations'));
    }

    public function searchProduct()
    {
        $category = request()->get('category');
        $queryRequest = request()->get('query');

        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->where(function ($query) use ($queryRequest) {
                $query->where('products.name', 'like', '%' . $queryRequest . '%')
                    ->orWhere('categories.name', 'like', '%' . $queryRequest . '%');
            })
            ->where('stok', '>', 0)
            ->where('category_id', $category)
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
                        'deskripsi' => $product->deskripsi
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
            "tanggal_maintenance" => "required",
        ]);

        DB::beginTransaction();

        try {
            $product = Product::whereIn('id', $request->product_id)->get()->pluck([], 'id')->toArray();
            $variation = ProductVariation::whereIn('id', $request->product_variation_id)->get()->pluck([], 'id')->toArray();

            $trx_id = 'MT-' . rand(1000, 9999);
            $transaction = Transaction::create([
                'business_id' => '1',
                'tgl_transaksi' => Tanggal::tglNasional($request->tanggal_maintenance),
                'rekening_debit' => 71,
                'rekening_kredit' => 12,
                'user_id' => auth()->user()->id,
                'usage_id' => '0',
                'installation_id' => $request->instalasi,
                'purchase_id' => '0',
                'total' => array_sum($request->harga_jual),
                'transaction_id' => $trx_id,
                'relasi' => '-',
                'keterangan' => "Maintenance - " . $request->instalasi,
                'urutan' => '0',
            ]);

            $total = 0;
            $daftarMaintenance = [];
            $timestamp = date("Y-m-d H:i:s");
            for ($i = 0; $i < count($request->product_id); $i++) {
                $product_id = $request->product_id[$i];
                $product_variation_id = $request->product_variation_id[$i];
                $pairing_id = $request->pairing_id[$i];
                $jumlah = $request->jumlah[$i];
                $harga_jual = intval(str_replace(',', '', $request->harga_jual[$i]));
                $subtotal = intval(str_replace(',', '', $request->subtotal[$i]));
                $catatan = $request->catatan[$i];

                $daftarMaintenance[] = [
                    "transaction_id" => $transaction->id,
                    "pairing_id" => $pairing_id,
                    "installation_id" => $request->instalasi,
                    "product_id" => $product_id,
                    "product_variation_id" => $product_variation_id,
                    "tgl_maintenance" => Tanggal::tglNasional($request->tanggal_maintenance),
                    "harga" => $harga_jual,
                    "jumlah" => $jumlah,
                    "total" => $subtotal,
                    "status" => 1,
                    "catatan" => $catatan,
                    "created_at" => $timestamp,
                    "updated_at" => $timestamp
                ];

                if (is_numeric($product_variation_id)) {
                    ProductVariation::where('id', $product_variation_id)->update(['stok' => $variation[$product_variation_id]['stok'] - $jumlah]);
                }

                Product::where('id', $product_id)->update(['stok' => $product[$product_id]['stok'] - $jumlah]);

                $total += $subtotal;
            }
            Maintenance::insert($daftarMaintenance);

            DB::commit();

            return redirect('/maintenances')->with('success', 'Maintenance berhasil disimpan!');
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($maintenance)
    {
        $transaction = Transaction::where('id', $maintenance)->with([
            'maintenance.product',
            'maintenance.productVariation'
        ])->first();

        foreach ($transaction->maintenance as $mc) {
            if ($mc->productVariation) {
                $productVariation = ProductVariation::find($mc->productVariation->id);
                if ($productVariation) {
                    $productVariation->stok += $mc->jumlah;
                    $productVariation->save();
                }
            }

            $product = Product::find($mc->product_id);
            if ($product) {
                $product->stok += $mc->jumlah;
                $product->save();
            }
        }

        Maintenance::where('transaction_id', $transaction->id)->delete();
        Transaction::where('id', $transaction->id)->delete();

        return response()->json([
            'success' => true,
            'msg' => 'Maintenance berhasil dihapus',
            'maintenance' => $transaction
        ]);
    }
}

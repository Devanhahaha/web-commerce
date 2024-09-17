<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\ProductCust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductCustController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['productCust'] = Product::all();
        return view('productcust', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Show the checkout form for the specified product.
     */
    public function checkout($id)
    {
        $productcust = Product::findOrFail($id);
        return view('checkout', compact('productcust'));
    }

    /**
     * Show the checkout form for the specified ProductCust.
     */
    public function showCheckout($id)
    {
        $productcust = ProductCust::findOrFail($id);
        return view('checkout', compact('productcust'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'nominal' => 'required|numeric',
            'gambar' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $jenis = 'PRODUCT';
            $prefix = "TRX-$jenis-";
            $uniquePart = uniqid();
            $code = strtoupper($prefix . substr($uniquePart, -6));
        
            $transaksi = Transaksi::create([
                'user_id' => Auth::user()->id,
                'order_id' => $code,
                'status' => 'belum di kirim',
                'jenis_transaksi' => $jenis,
                'jenis_pembayaran' => 'online'
            ]);

            $file = $request->file('gambar');
            $path = 'files/product/';
            $nameFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path), $nameFile);
        
            $nominal = str_replace('.', '', $request->nominal);
        
            Product::create([
                'nama_product' => $request->name,
                'jenis' => $request->jenis,
                'merk' => $request->merk,
                'deskripsi' => $request->deskripsi,
                'nominal' => $nominal,
                'gambar' => $path . $nameFile
            ]);

            // Membuat Transaksi Midtrans
            $transaction_details = [
                'order_id' => $transaksi->order_id,
                'gross_amount' => (int) $nominal, // no decimal allowed for creditcard
            ];

            $customer_details = [
                'first_name' => $request->name,
                'email' => Auth::user()->email,
                'phone' => $request->number,
            ];

            $enable_payments = ["credit_card", "cimb_clicks", "bca_klikbca",
                                "bca_klikpay", "bri_epay", "echannel", "permata_va",
                                "bca_va", "bni_va", "bri_va", "other_va", "gopay",
                                "indomaret", "danamon_online", "akulaku", "shopeepay"];

            $transactionMidtrans = [
                'enabled_payments' => $enable_payments,
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
            ];
        
            $url_transaction = Snap::createTransaction($transactionMidtrans)->redirect_url;

            $transaksi->url_transaksi = $url_transaction;
            $transaksi->save();

            DB::commit();
            return redirect($url_transaction);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

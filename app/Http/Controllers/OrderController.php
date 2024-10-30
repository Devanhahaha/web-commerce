<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\ProductCust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'catatan' => 'nullable|string',
            'kurir' => 'required|string',
            'provinsi' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'ongkir' => 'required',
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
                'status' => 'belum di kirim', // Adjust status
                'jenis_transaksi' => $jenis,
                'jenis_pembayaran' => $request->payment_method,
            ]);

            $url = 'https://api.rajaongkir.com/starter/province';

            $province = $response = Http::withHeaders([
                'key' => '6f4308547a4430b68f2481ba03aa93c2'
            ])->get($url);

            $data = $response->json();
            
            // Filter data untuk menemukan nama provinsi berdasarkan ID
            $namaProvinsi = collect($data['rajaongkir']['results'])
                ->firstWhere('province_id', $request->provinsi)['province'] ?? 'Provinsi tidak ditemukan';
            
                $url = 'https://api.rajaongkir.com/starter/city';

                    // Memanggil API untuk mendapatkan seluruh data kabupaten
                    $response = Http::withHeaders([
                        'key' => '6f4308547a4430b68f2481ba03aa93c2'
                    ])->get($url);
            
                    $data = $response->json();
            
                    // Filter data untuk menemukan nama kabupaten berdasarkan ID
                    $namaKabupaten = collect($data['rajaongkir']['results'])
                        ->firstWhere('city_id', $request->kabupaten)['city_name'] ?? 'Kabupaten tidak ditemukan';
            
            $total = 0;
            $cart = session()->get('cart', []);
            foreach ($request->product_id as $i => $productId) {
                $order = ProductCust::create([
                    'product_id' => $productId,
                    'transaksi_id' => $transaksi->id,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'catatan' => $request->catatan,
                    'kurir' => $request->kurir,
                    'provinsi' => $namaProvinsi,
                    'kabupaten' => $namaKabupaten,
                    'ongkir' => $request->ongkir,
                    'quantity' => $request->quantity[$i],
                    'sub_total' => $request->sub_total[$i],
                ]);
                $product = Product::find($productId);
                $subtotal = $product->nominal * $request->quantity[$i];
                $total += $subtotal;

                $product->stok = $product->stok - $request->quantity[$i];
                $product->save();

                if (isset($cart[$productId]) && $cart[$productId]['user_id'] == Auth::user()->id) {
                    unset($cart[$productId]); // Hapus produk dari cart
                }
            }

            $total += $request->ongkir;

            session()->put('cart', $cart);

            if ($request->payment_method === 'online') {
                $transaction_details = [
                    'order_id' => $transaksi->order_id,
                    'gross_amount' => (int)$total, // no decimal allowed for creditcard
                ];

                $customer_details = [
                    'first_name' => Auth::user()->first_name,
                    'email' => Auth::user()->email,
                    'phone' => $request->no_hp,
                ];

                $enable_payments = [
                    "credit_card",
                    "cimb_clicks",
                    "bca_klikbca",
                    "bca_klikpay",
                    "bri_epay",
                    "echannel",
                    "permata_va",
                    "bca_va",
                    "bni_va",
                    "bri_va",
                    "other_va",
                    "gopay",
                    "indomaret",
                    "danamon_online",
                    "akulaku",
                    "shopeepay"
                ];

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
            } else {
                DB::commit();
                $transaksi = Transaksi::findOrFail($transaksi->id);
                $order = ProductCust::where('transaksi_id', $transaksi->id)->first();
                $product = Product::whereIn('id', $request->product_id)->get();

                return view('orders.show', compact('transaksi', 'order', 'product'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function ship($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'sudah di kirim';
        $transaksi->save();

        return back()->with('status', 'Status pengiriman telah diubah menjadi "sudah di kirim".');
    }

    public function confirm($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'barang diterima';
        $transaksi->save();

        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }

    public function requestCancel($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        if ($transaksi->status === 'belum di kirim') {
            $transaksi->status = 'pembatalan diajukan';
            $transaksi->save();
            return redirect()->back()->with('success', 'Pembatalan pesanan telah diajukan.');
        }
        return redirect()->back()->with('error', 'Pembatalan pesanan tidak dapat diajukan.');
    }

    public function confirmCancel($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        if ($transaksi->status === 'pembatalan diajukan') {
            $transaksi->status = 'dibatalkan';
            $transaksi->save();
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }
        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }



    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $order = ProductCust::where('transaksi_id', $transaksi->id)->first();
        $product = Product::findOrFail($order->product_id);

        return view('orders.show', compact('transaksi', 'order', 'product'));
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}

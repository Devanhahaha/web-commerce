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
        'product_id' => 'required|exists:products,id',
        'alamat' => 'required|string|max:255',
        'no_hp' => 'required|string|max:20',
        'catatan' => 'nullable|string',
        'payment_method' => 'required|in:online,cod', // Add this line
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

        $order = new ProductCust();
        $order->product_id = $request->product_id;
        $order->transaksi_id = $transaksi->id;
        $order->alamat = $request->alamat;
        $order->no_hp = $request->no_hp;
        $order->catatan = $request->catatan;
        $order->save();

        if ($request->payment_method === 'online') {
            $transaction_details = [
                'order_id' => $transaksi->order_id,
                'gross_amount' => (int) Product::find($request->product_id)->nominal, // no decimal allowed for creditcard
            ];

            $customer_details = [
                'first_name' => Auth::user()->first_name,
                'email' => Auth::user()->email,
                'phone' => $request->no_hp,
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
        } else {
            DB::commit();
            return redirect()->route('orders.show', $transaksi->id)->with('status', 'Order berhasil dibuat dengan metode COD.');
        }

    } catch (\Exception $e) {
        DB::rollBack();
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

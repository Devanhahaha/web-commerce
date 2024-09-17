<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction(Request $request)
    {
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('payment', compact('snapToken'));
    }

    public function success()
    {
        return view('success');
    }

    public function notification(Request $request)
    {
        try {
            $data = (object)$request->data;
            
            $payment = Transaksi::where('order_id', 'REG-'.$data->virtualAccount)->firstOrFail()->update([
                'status'    => 1
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Transaksi Berhasil diterima app.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
        
        // echo "<pre><code>" .json_encode(json_decode($json), JSON_PRETTY_PRINT).'</code></pre>';
    }

}

<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . uniqid(),
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
        ];

        $snapToken = MidtransService::createTransaction($params);
        return view('payment', compact('snapToken'));
    }
    public function success()
    {
        return view('success');
    }
    public function notification(Request $request)
    {
        try {
            $data = $request->validate([
                'order_id' => 'required|exists:transaksis,id',
            ]);

            Transaksi::findOrFail($data['order_id'])->update(['status' => 'lunas']);
            return response()->json([
                'status' => true,
                'message' => 'Transaksi Berhasil diterima.',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Transaksi tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}

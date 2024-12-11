<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Midtrans\Config;
use App\Http\Controllers\Midtrans\Transaction;
use App\Http\Controllers\Midtrans\ApiRequestor;
use App\Http\Controllers\Midtrans\SnapApiRequestor;
use App\Http\Controllers\Midtrans\Notification;
use App\Http\Controllers\Midtrans\CoreApi;
use App\Http\Controllers\Midtrans\Snap;
use App\Http\Controllers\Midtrans\Sanitizer;
use App\Models\Transaksi;

class MidtransController extends Controller
{
    public function notification(Request $request)
    {
        $this->configureMidtrans();
        $notification = (new Notification())->getResponse()->getData();
        $order_id = $notification->order_id;

        $transaction = Transaksi::where('order_id', $order_id)->first();
        if (!$transaction) {
            return $this->generateResponse(false, "Update Data Failed", 600);
        }

        $payment_status = $this->determinePaymentStatus(
            $notification->transaction_status,
            $notification->payment_type,
            $notification->fraud_status
        );

        $this->updateTransactionStatus($order_id, $payment_status);
        return $this->generateResponse(true, "Update Data Success", 201);
    }
    private function configureMidtrans()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }
    private function generateResponse($status, $message, $code)
    {
        return response()->json([
            "status" => $status,
            "message" => $message,
            "code" => $code,
        ], 201);
    }
    private function determinePaymentStatus($status, $type, $fraud)
    {
        if ($status == 'capture' && $type == 'credit_card') {
            return ($fraud == 'challenge') ? 1 : 4;
        }
        return match ($status) {
            'settlement' => 4,
            'pending' => 1,
            'deny', 'expire', 'cancel' => 8,
            default => 0,
        };
    }
    private function updateTransactionStatus($order_id, $payment_status)
    {
        if ($payment_status == 4) {
            Transaksi::where('order_id', $order_id)->update(['status' => 'lunas']);
        }
    }
    public static function SendNotification($request = '')
    {
        // This method is intentionally left blank. Future implementation goes here.
    }
}

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
        // Set Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');

        // Instance midtrans notification
        $notification = new Notification();
        $notification = $notification->getResponse()->getData();


        // Assign ke variabel untuk mempermudah code
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;
        $payment_type = $notification->payment_type;
        $gross_amount = (int)$notification->gross_amount;


        $transaction = Transaksi::where('order_id', $order_id)->first();

        // Cari transaksi berdasarkan ID
        if (empty($transaction)) {
            return response()->json([
                "status" => false,
                "message" => "Update Data Failed",
                "code" => 600
            ], 201);
        }

        // Handle notifikasi status midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $payment_status = 1;
                }else{
                    $payment_status = 4;
                }
            }
        }else if ($status == 'settlement') {
            $payment_status = 4;
        }else if ($status == 'pending') {
            $payment_status = 1;
        }else if ($status == 'deny') {
            $payment_status = 8;
        }else if ($status == 'expire') {
            $payment_status = 8;
        }else if ($status == 'cancel') {
            $payment_status = 8;
        }

        if ($payment_status == 4) {
           $transaction = Transaksi::where('order_id', $order_id)->update([
                'status'=> 'lunas',
            ]);
        }

        if (!empty($transaction)) {
            return response()->json([
                "status" => true,
                "message" => "Update Data Success",
                "code" => 201,
            ], 201);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Update Data Failed",
                "code" => 600
            ], 201);
        }
    }

    public function finish(Request $request)
    {
        return view('success');
    }

    public function unfinished(Request $request)
    {
        echo "Transaction Unfinished yet :( <br>";
        echo json_decode($request);
    }

    public function error(Request $request)
    {
        echo "Transaction Fail :| <br>";
        echo json_decode($request);
    }

    /* Request Params untuk Notifikasi (Example)
            $paramNotif = [
                'id_user'   => $save->id_user,
                'title'     => 'Pesanan',
                'body'      => 'Pesanan ID : '.$save->id_transaction.' Telah Dibuat! Silahkan selesaikan pembayaran.',
                'screen'    => 'checkout',
                'notificationData' => $save->getRawOriginal()
            ];

            // MidtransController::SendNotification($paramNotif);
    */
    public static function SendNotification($request = '')
    {
    
    }
    
}

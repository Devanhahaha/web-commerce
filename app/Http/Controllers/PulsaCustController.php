<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Pulsa;
use App\Models\Wallet;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PulsaCustController extends Controller
{
    public function __construct()
    {
        $this->initializeMidtrans();
    }
    public function index()
    {
        return view('pulsaCust');
    }
    private function initializeMidtrans()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validateStoreRequest($request);

            $transaction = $this->createTransaction($request);
            $this->createPulsaEntry($transaction, $request);

            $this->reduceStock($request->nominal, $request->jenis);

            $midtransUrl = $this->handleMidtransTransaction($transaction, $request);
            $transaction->update(['url_transaksi' => $midtransUrl]);

            DB::commit();
            return redirect($midtransUrl);
        } catch (\App\Exceptions\InsufficientStockException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error("Transaction Error: " . $e->getMessage());
            return redirect()->back()->withErrors('Transaction failed. Please try again.');
        }
    }
    private function validateStoreRequest(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha',
            'number' => 'required|numeric',
            'nominal' => 'required|numeric',
            'jenis' => 'required|alpha',
        ]);
    }
    private function createTransaction()
    {
        $orderId = $this->generateOrderId('PULSA');
        return Transaksi::create([
            'user_id' => Auth::id(),
            'order_id' => $orderId,
            'status' => 'pending',
            'jenis_transaksi' => 'PULSA',
            'jenis_pembayaran' => 'online',
        ]);
    }
    private function createPulsaEntry($transaction, Request $request)
    {
        $nominal = str_replace('.', '', $request->nominal);
        Pulsa::create([
            'transaksi_id' => $transaction->id,
            'nama' => $request->name,
            'no_telp' => $request->number,
            'nominal' => $nominal,
            'harga' => $request->harga,
            'tipe_kartu' => $request->jenis,
        ]);
    }
    private function handleMidtransTransaction($transaction, Request $request)
    {
        $transactionDetails = [
            'order_id' => $transaction->order_id,
            'gross_amount' => $request->harga,
        ];
        $customerDetails = [
            'first_name' => $request->name,
            'email' => Auth::user()->email,
            'phone' => $request->number,
        ];
        $enabledPayments = ['credit_card', 'gopay', 'shopeepay', 'bank_transfer'];

        $midtransPayload = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'enabled_payments' => $enabledPayments,
        ];

        return Snap::createTransaction($midtransPayload)->redirect_url;
    }
    private function reduceStock($nominal, $jenis)
    {
        $wallet = Wallet::where('name', 'Pulsa ' . $jenis)->first();

        if (!$wallet || $wallet->value < $nominal) {
            throw new \App\Exceptions\InsufficientStockException("Insufficient stock for $jenis.");
        }

        $wallet->decrement('value', $nominal);
    }
    private function generateOrderId($type)
    {
        return strtoupper("TRX-$type-" . substr(uniqid(), -6));
    }
}

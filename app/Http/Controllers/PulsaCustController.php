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
use App\Http\Controllers\MidtransController;
use App\Models\Transaction; // Tambahkan ini jika belum ada

class PulsaCustController extends Controller
{
    public function index()
    {
        return view('pulsaCust');
    }

    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function create()
    {
        // Tambahkan fungsi ini jika diperlukan
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // membuat transaksi
        $request->validate([
            'name' => 'required|alpha',
            'number' => 'required|numeric',
            'nominal' => 'required|numeric',
            'jenis' => 'required|alpha'
        ]);
        
        DB::beginTransaction();
        try {
            $jenis = 'PULSA';
            $prefix = "TRX-$jenis-";
            $uniquePart = uniqid();
            $code = strtoupper($prefix . substr($uniquePart, -6));
        
            $transaksi = Transaksi::create([
                'user_id' => Auth::user()->id,
                'order_id' => $code,
                'status' => 'belum lunas',
                'jenis_transaksi' => $jenis,
                'jenis_pembayaran' => 'online'
            ]);
        
            $nominal = str_replace('.', '', $request->nominal);
        
            Pulsa::create([
                'transaksi_id' => $transaksi->id,
                'nama' => $request->name,
                'no_telp' => $request->number,
                'nominal' => $nominal,
                'tipe_kartu' => $request->jenis,
            ]);
            

            // Membuat Transaksi Midtrans
            $transaction_details = [
                'order_id' => $transaksi->id,
                'gross_amount' => $request->nominal, // no decimal allowed for creditcard
            ];

            $customer_details = [
                'first_name'    => $request->name,
                'email'         => Auth::user()->emai,
                'phone'         => $request->number,
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
            dd($e->getMessage());
        }

        $this->kurangiStokPulsa($nominal, $request->jenis);
        return redirect()->route('pulsaCust.success');
    }

    /**
     * Get Snap token for the transaction.
     */
    public function token(Request $request)
    {
        $transactionDetails = [
            'order_id' => uniqid(),
            'gross_amount' => $request->nominal + 2000 
        ];

        $customerDetails = [
            'first_name' => $request->name,
            'phone' => $request->number,
        ];

        $transaction = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'enabled_payments' => ['gopay', 'shopeepay', 'alfamart', 'indomaret', 'bank_transfer']
        ];

        $snapToken = Snap::getSnapToken($transaction);

        return response()->json(['token' => $snapToken]);
    }

    private function kurangiStokPulsa($nominal, $jenis) {
        
        $pulsa = Wallet::where('name', 'Pulsa '. $jenis)->first();

        
        if ($pulsa) {
            $stokBaru = $pulsa->value - $nominal; 
            $pulsa->update(['value' => $stokBaru]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Tambahkan fungsi ini jika diperlukan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Tambahkan fungsi ini jika diperlukan
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Tambahkan fungsi ini jika diperlukan
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tambahkan fungsi ini jika diperlukan
    }
}

<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Transaksi;
use App\Models\Bayartagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BayarTagihanCustController extends Controller
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
        return view('bayar_tagihanCust');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|alpha',
            'jenis_tagihan' => 'required|in:PLN,BPJS',
            'nomor_tagihan' => 'required|string|max:255',
            'nominal' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $jenis = 'BAYARTAGIHAN';
            $prefix = "TRX-$jenis-";
            $uniquePart = uniqid();
            $code = strtoupper($prefix . substr($uniquePart, -6));

            $transaksi = Transaksi::create([
                'user_id' => Auth::user()->id,
                'order_id' => $code,
                'status' => 'lunas',
                'jenis_transaksi' => $jenis,
                'jenis_pembayaran' => 'online'
            ]);

            $nominal = str_replace('.', '', $request->nominal);

            Bayartagihan::create([
                'transaksi_id' => $transaksi->id,
                'nama' => $request->name,
                'tipe_tagihan' => $request->jenis_tagihan,
                'no_tagihan' => $request->nomor_tagihan,
                'nominal' => $nominal,
                'harga' => $request->harga,
            ]);

            // Membuat Transaksi Midtrans
            $transaction_details = [
                'order_id' => $transaksi->id,
                'gross_amount' => $request->harga, // no decimal allowed for creditcard
            ];

            $customer_details = [
                'first_name'    => $request->name,
                'email'         => Auth::user()->email,
                'phone'         => $request->number,
            ];

            $enable_payments = [
                "credit_card", "cimb_clicks", "bca_klikbca",
                "bca_klikpay", "bri_epay", "echannel", "permata_va",
                "bca_va", "bni_va", "bri_va", "other_va", "gopay",
                "indomaret", "danamon_online", "akulaku", "shopeepay"
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
        } catch (\Exception $e) {
            dd($e->getMessage());
        }


        return redirect()->route('bayartagihanCust.success');
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

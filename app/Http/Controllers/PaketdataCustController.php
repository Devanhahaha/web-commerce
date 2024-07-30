<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Wallet;
use App\Models\Paketdata;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaketDataCustController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function index()
    {

        $data['paket'] = Wallet::where('name', 'LIKE', '%Paketdata%')->get();
        return view('paket_dataCust', $data);
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'name' => 'required|alpha',
            'number' => 'required|numeric',
            'jenis' => 'required|alpha',
            'nominal' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $jenis = 'PAKETDATA';
            $prefix = "TRX-$jenis-";
            $uniquePart = uniqid();
            $code = strtoupper($prefix . substr($uniquePart, -6));

            $data = explode(' - ', $request->nominal);
            $cash =  preg_replace("/[^0-9]/", "", $data[1]);


            $transaksi = Transaksi::create([
                'user_id' => Auth::user()->id,
                'order_id' => $code,
                'status' => 'belum lunas',
                'jenis_transaksi' => $jenis,
                'jenis_pembayaran' => 'online'
            ]);

            $nominal = str_replace('.', '', $data[0]);

            Paketdata::create([
                'transaksi_id' => $transaksi->id,
                'nama' => $request->name,
                'no_telp' => $request->number,
                'tipe_kartu' => $request->jenis,
                'harga' => $cash,
                'nominal' => $nominal,
            ]);

            $transaction_details = [
                'order_id' => $transaksi->id,
                'gross_amount' => $cash, // no decimal allowed for creditcard
            ];

            $customer_details = [
                'first_name'    => $request->name,
                'email'         => Auth::user()->emai,
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


        return redirect()->route('paketdataCust.success');
    }
}

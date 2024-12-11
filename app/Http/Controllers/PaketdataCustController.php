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
        $this->initializeMidtransConfig();
    }
    private function initializeMidtransConfig()
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
        $this->validateRequest($request);

        DB::beginTransaction();

        try {
            $transaksi = $this->createTransaksi($request);

            // Create Paketdata, no need to assign to a variable if it's not used later
            $this->createPaketData($request, $transaksi);

            $url_transaction = $this->createMidtransTransaction($request, $transaksi);

            $transaksi->update(['url_transaksi' => $url_transaction]);

            DB::commit();

            return redirect($url_transaction);
        } catch (\Exception $e) {
            DB::rollBack();

            // Log error and provide user-friendly feedback
            logger()->error('Transaction failed: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Failed to process your transaction. Please try again later.']);
        }
    }
    private function validateRequest(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha',
            'number' => 'required|numeric',
            'jenis' => 'required|alpha',
            'nominal' => 'required|string',
        ]);
    }
    private function createTransaksi(): Transaksi
    {
        $code = $this->generateTransactionCode('PAKETDATA');

        return Transaksi::create([
            'user_id' => Auth::id(),
            'order_id' => $code,
            'status' => 'lunas',
            'jenis_transaksi' => 'PAKETDATA',
            'jenis_pembayaran' => 'online',
        ]);
    }
    private function createPaketData(Request $request, Transaksi $transaksi): Paketdata
    {
        [$nominal, $cash] = $this->extractNominalAndCash($request->nominal);

        return Paketdata::create([
            'transaksi_id' => $transaksi->id,
            'nama' => $request->name,
            'no_telp' => $request->number,
            'tipe_kartu' => $request->jenis,
            'harga' => $cash,
            'nominal' => $nominal,
        ]);
    }
    private function createMidtransTransaction(Request $request, Transaksi $transaksi): string
    {
        [$cash] = $this->extractNominalAndCash($request->nominal);

        $transaction_details = [
            'order_id' => $transaksi->order_id,
            'gross_amount' => $cash,
        ];

        $customer_details = [
            'first_name' => $request->name,
            'email' => Auth::user()->email,
            'phone' => $request->number,
        ];

        $transactionMidtrans = [
            'enabled_payments' => $this->getEnabledPaymentMethods(),
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        return Snap::createTransaction($transactionMidtrans)->redirect_url;
    }
    private function generateTransactionCode(string $type): string
    {
        $uniquePart = strtoupper(substr(uniqid(), -6));
        return "TRX-{$type}-{$uniquePart}";
    }
    private function extractNominalAndCash(string $nominalString): array
    {
        $data = explode(' - ', $nominalString);
        $cash = preg_replace("/\D/", "", $data[1]);
        $nominal = str_replace('.', '', $data[0]);

        return [$nominal, $cash];
    }
    private function getEnabledPaymentMethods(): array
    {
        return [
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
    }
}

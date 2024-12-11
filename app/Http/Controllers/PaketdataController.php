<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Paketdata;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Factories\PaketDataFactory;
use Illuminate\Support\Facades\Auth;

class PaketdataController extends Controller
{
    const JENIS_PAKET = 'PAKETDATA';
    const STATUS_LUNAS = 'lunas';
    const PEMBAYARAN_CASH = 'cash';

    public function index()
    {
        $data['paket'] = Wallet::where('name', 'LIKE', '%Paketdata%')->get();
        return view('paket_data', $data);
    }
    public function store(Request $request)
    {
        $this->validateRequest($request);

        $transaksi = $this->createTransaction($request);

        $processedData = $this->processNominalAndCash($request->nominal);

        $this->createPaketData($request, $transaksi, $processedData);

        $this->kurangiStokPaketdata([
            'nominal' => $processedData['nominal'],
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('laporanpaketdata.index');
    }
    private function validateRequest(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha',
            'number' => 'required|numeric',
            'jenis' => 'required|alpha',
            'nominal' => 'required',
        ]);
    }
    private function createTransaction()
    {
        $prefix = "TRX-" . self::JENIS_PAKET . "-";
        $uniquePart = uniqid();
        $code = strtoupper($prefix . substr($uniquePart, -6));

        return Transaksi::create([
            'user_id' => Auth::user()->id,
            'order_id' => $code,
            'status' => self::STATUS_LUNAS,
            'jenis_transaksi' => self::JENIS_PAKET,
            'jenis_pembayaran' => self::PEMBAYARAN_CASH,
        ]);
    }
    private function processNominalAndCash($nominal)
    {
        $data = explode(' - ', $nominal);
        return [
            'nominal' => str_replace('.', '', $data[0]),
            'cash' => preg_replace('/\D/', '', $data[1]),
        ];
    }
    private function createPaketData(Request $request, $transaksi, $processedData)
    {
        Paketdata::create([
            'transaksi_id' => $transaksi->id,
            'nama' => $request->name,
            'no_telp' => $request->number,
            'tipe_kartu' => $request->jenis,
            'harga' => $processedData['cash'],
            'nominal' => $processedData['nominal'],
        ]);
    }
    private function kurangiStokPaketdata($data)
    {
        $paketdata = Wallet::where('name', 'Paketdata ' . $data['jenis'] . " " . $data['nominal'])->first();

        if ($paketdata) {
            $stokBaru = $paketdata->value - 1;
            $paketdata->update(['value' => $stokBaru]);
        }
    }
}

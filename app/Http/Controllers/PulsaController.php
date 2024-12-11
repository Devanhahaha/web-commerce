<?php

namespace App\Http\Controllers;

use App\Models\Pulsa;
use App\Models\Wallet;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Factories\PulsaFactory;
use Illuminate\Support\Facades\Auth;

class PulsaController extends Controller
{
    protected $factory;

    public function __construct()
    {
        $this->factory = new PulsaFactory();
    }
    public function index()
    {
        return view('pulsa');
    }
    public function create()
    {
        return view('addpulsa');
    }
    public function store(Request $request)
    {
        $this->validateRequest($request);

        $code = $this->generateOrderId('PULSA');
        $transaksi = $this->createTransaction($code);

        $nominal = str_replace('.', '', $request->nominal);
        $this->createPulsaEntry($transaksi->id, $request, $nominal);

        $this->updateStock($nominal, $request->jenis);

        return redirect()->route('laporanpulsa.index');
    }
    private function validateRequest(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha',
            'number' => 'required|numeric',
            'nominal' => 'required|numeric',
            'harga' => 'required|integer',
            'jenis' => 'required|alpha'
        ]);
    }
    private function generateOrderId(string $prefix): string
    {
        $uniquePart = uniqid();
        return strtoupper("TRX-$prefix-" . substr($uniquePart, -6));
    }
    private function createTransaction(string $code)
    {
        return Transaksi::create([
            'user_id' => Auth::user()->id,
            'order_id' => $code,
            'status' => 'lunas',
            'jenis_transaksi' => 'PULSA',
            'jenis_pembayaran' => 'cash'
        ]);
    }
    private function createPulsaEntry(int $transaksiId, Request $request, $nominal)
    {
        Pulsa::create([
            'transaksi_id' => $transaksiId,
            'nama' => $request->name,
            'no_telp' => $request->number,
            'nominal' => $nominal,
            'harga' => $request->harga,
            'tipe_kartu' => $request->jenis,
        ]);
    }
    private function updateStock($nominal, $jenis)
    {
        $pulsa = Wallet::where('name', 'Pulsa ' . $jenis)->first();

        if ($pulsa) {
            $pulsa->update(['value' => $pulsa->value - $nominal]);
        }
    }
}

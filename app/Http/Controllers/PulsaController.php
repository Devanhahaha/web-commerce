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
    public function __construct() {
        $this->factory = new PulsaFactory();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pulsa');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addpulsa');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi request
    $request->validate([
        'name' => 'required|alpha',
        'number' => 'required|numeric',
        'nominal' => 'required|numeric',
        'jenis' => 'required|alpha'
    ]);
    
    $jenis = 'PULSA';
    $prefix = "TRX-$jenis-";
    $uniquePart = uniqid();
    $code = strtoupper($prefix . substr($uniquePart, -6));

    $transaksi = Transaksi::create([
        'user_id' => Auth::user()->id,
        'order_id' => $code,
        'status' => 'lunas',
        'jenis_transaksi' => $jenis,
        'jenis_pembayaran' => 'cash'
    ]);

    $nominal = str_replace('.', '', $request->nominal);

    Pulsa::create([
        'transaksi_id' => $transaksi->id,
        'nama' => $request->name,
        'no_telp' => $request->number,
        'nominal' => $nominal,
        'harga' => $request->harga,
        'tipe_kartu' => $request->jenis,
    ]);
    
    
    // Decrement the stock of the Pulsa
    $this->kurangiStokPulsa($nominal, $request->jenis);

    return redirect()->route('laporanpulsa.index');
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

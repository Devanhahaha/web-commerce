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

    protected $factory;
    public function __construct() {
        $this->factory = new PaketDataFactory();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['paket']=Wallet::where('name', 'LIKE', '%Paketdata%')->get();
        return view('paket_data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addpaket_data');
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
            'jenis' => 'required|alpha',
            'nominal' => 'required',
        ]);
        
    
    $jenis = 'PAKETDATA';
    $prefix = "TRX-$jenis-";
    $uniquePart = uniqid();
    $code = strtoupper($prefix . substr($uniquePart, -6));

    $data = explode(' - ',$request->nominal);
    $cash =  preg_replace("/[^0-9]/", "", $data[1]);
    

    $transaksi = Transaksi::create([
        'user_id' => Auth::user()->id,
        'order_id' => $code,
        'status' => 'lunas',
        'jenis_transaksi' => $jenis,
        'jenis_pembayaran' => 'cash'
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
    
    
    
    $this->kurangiStokPaketdata($nominal, $request->jenis);

    return redirect()->route('laporanpaketdata.index');

    
}
    private function kurangiStokPaketdata($nominal, $jenis) {
        
    $paketdata = Wallet::where('name', 'Paketdata '. $jenis ." ". $nominal)->first();

    
    if ($paketdata) {
        $stokBaru = $paketdata->value - 1; 
        $paketdata->update(['value' => $stokBaru]);
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
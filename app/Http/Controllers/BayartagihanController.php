<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Bayartagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BayartagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bayar_tagihan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addbayar_tagihan');
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

        $jenis = 'BAYARTAGIHAN';
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

        Bayartagihan::create([
            'transaksi_id' => $transaksi->id,
            'nama' => $request->name,
            'tipe_tagihan' => $request->jenis_tagihan,
            'no_tagihan' => $request->nomor_tagihan,
            'nominal' => $nominal,
            'harga' => $request->harga,
        ]);
        return redirect()->route('laporanbayartagihan.index');
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

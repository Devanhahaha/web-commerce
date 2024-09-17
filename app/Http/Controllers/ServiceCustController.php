<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceCustController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('serviceCust');
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
            'alamat' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'keluhan' => 'required|string|max:255',
            'number' => 'required|numeric',
        ]);

        $jenis = 'SERVICES';
        $prefix = "TRX-$jenis-";
        $uniquePart = uniqid();
        $code = strtoupper($prefix . substr($uniquePart, -6));

        $transaksi = Transaksi::create([
            'user_id' => Auth::user()->id,
            'order_id' => $code,
            'status' => 'belum lunas',
            'jenis_transaksi' => $jenis,
            'jenis_pembayaran' => 'cash'
        ]);

        Services::create([
            'transaksi_id' => $transaksi->id,
            'nama' => $request->name,
            'alamat' => $request->alamat,
            'jenis_hp' => $request->jenis,
            'keluhan' => $request->keluhan,
            'kontak' => $request->number,
        ]);
        return redirect()->route('riwayatTransaksiServices.index');
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
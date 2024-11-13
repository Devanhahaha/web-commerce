<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaksi;
use App\Models\Bayartagihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BayarTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bayartagihan = Bayartagihan::get();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $bayartagihan,
        ], 200);

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
        try {

            $jenis = 'BAYARTAGIHAN';
            $prefix = "TRX-$jenis-";
            $uniquePart = uniqid();
            $code = strtoupper($prefix . substr($uniquePart, -6));

            $transaksi = Transaksi::create([
                'user_id' => auth()->guard('api')->user()->id,
                'order_id' => $code,
                'status' => 'lunas',
                'jenis_transaksi' => $jenis,
                'jenis_pembayaran' => 'cash'
            ]);

            $nominal = str_replace('.', '', $request->nominal);

            $bayartagihan = Bayartagihan::create([
                'transaksi_id' => $transaksi->id,
                'nama' => $request->nama,
                'tipe_tagihan' => $request->tipe_tagihan,
                'no_tagihan' => $request->no_tagihan,
                'nominal' => $nominal,
                'harga' => $request->harga,
            ]);

            return response()->json([
                "status" => true,
                "message" => "success submitting data",
                "data" => $bayartagihan,
            ], 200);
        }catch (\Throwable $th) {
            return response()->json([
                "status" => 500,
                "message" => "Error submitting data",
                "error" => $th->getMessage()
            ], 500);
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

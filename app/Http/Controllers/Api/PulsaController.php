<?php

namespace App\Http\Controllers\Api;

use App\Models\Pulsa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PulsaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pulsa = Pulsa::get();
        return response()->json([
            'status' => true,
            'message' => 'apalah',
            'data' => $pulsa,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $jenis = 'PULSA';
            $prefix = "TRX-$jenis-";
            $uniquePart = uniqid();
            $code = strtoupper($prefix . substr($uniquePart, -6));

            $transaksi = Transaksi::create([
                'user_id' => 1,
                'order_id' => $code,
                'status' => 'lunas',
                'jenis_transaksi' => $jenis,
                'jenis_pembayaran' => 'cash'
            ]);

            $nominal = str_replace('.', '', $request->nominal);

            $pulsa = Pulsa::create([
                'transaksi_id' => $transaksi->id,
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'nominal' => $nominal,
                'harga' => $request->harga,
                'tipe_kartu' => $request->tipe_kartu,
            ]);

            return response()->json([
                "status" => true,
                "message" => "success submitting data",
                "data" => $pulsa,
            ], 200);
        } catch (\Throwable $th) {
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

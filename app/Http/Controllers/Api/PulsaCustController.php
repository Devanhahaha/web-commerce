<?php

namespace App\Http\Controllers\Api;

use App\Models\Pulsa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PulsaCustController extends Controller
{

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
                'user_id' => auth()->guard('api')->user()->id,
                'order_id' => $code,
                'status' => 'belum lunas',
                'jenis_transaksi' => $jenis,
                'jenis_pembayaran' => 'online'
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

    public function midtransCallback(Request $request)
    {
        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id; 

        // Cari transaksi berdasarkan order_id
        $transaksi = Transaksi::where('order_id', $orderId)->first();

        if (!$transaksi) {
            return response()->json([
                "status" => 404,
                "message" => "Transaksi tidak ditemukan",
            ], 404);
        }

        // Periksa status pembayaran dan update status transaksi
        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $transaksi->status = 'lunas';  // Pembayaran berhasil
        } elseif ($transactionStatus === 'pending') {
            $transaksi->status = 'belum lunas';  // Pembayaran masih menunggu
        } elseif ($transactionStatus === 'cancel' || $transactionStatus === 'expire' || $transactionStatus === 'deny') {
            $transaksi->status = 'gagal';  // Pembayaran gagal
        }

        // Simpan perubahan status
        $transaksi->save();

        return response()->json([
            "status" => true,
            "message" => "Status transaksi diperbarui",
        ], 200);
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

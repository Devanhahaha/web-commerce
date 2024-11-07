<?php

namespace App\Http\Controllers\Api;

use App\Models\PaketData;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Contracts\Providers\Auth as JWTAuthProvider;
use Illuminate\Support\Facades\Auth;


class PaketdataController extends Controller
{
    public function index()
    {
        $paketdata = PaketData::get();
        return response()->json([
            'status' => true,
            'message' => 'apalah',
            'data' => $paketdata,
        ], 200);
    }

    public function store(Request $request){
        try {
            $jenis = 'PAKETDATA';
            $prefix = "TRX-$jenis-";
            $uniquePart = uniqid();
            $code = strtoupper($prefix . substr($uniquePart, -6));

            $data = explode(' - ',$request->nominal);
            if (count($data) < 2) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid nominal format. Expected format: "text - number".',
                ], 400);
            }
    
            $cash =  preg_replace("/[^0-9]/", "", $data[1]);
            

            $transaksi = Transaksi::create([
                'user_id' => auth()->guard('api')->user()->id,
                'order_id' => $code,
                'status' => 'lunas',
                'jenis_transaksi' => $jenis,
                'jenis_pembayaran' => 'cash'
            ]);

            $nominal = str_replace('.', '', $data[0]);

            $paketdata = Paketdata::create([
                'transaksi_id' => $transaksi->id,
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'tipe_kartu' => $request->tipe_kartu,
                'harga' => $cash,
                'nominal' => $nominal,
            ]);

            return response()->json([
                "status" => true,
                "message" => "success submitting data",
                "data" => $paketdata,
            ], 200);
            }   catch (\Throwable $th) {
                    return response()->json([
                        "status" => 500,
                        "message" => "Error submitting data",
                        "error" => $th->getMessage()
                    ], 500);
            }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    public function index()
    {
        return view('services');
    }
    public function create()
    {
        return view('addservices');
    }
    public function store(Request $request)
    {
        $rules = 'required|string|max:255';
        $request->validate([
            'name' => 'required|alpha',
            'alamat' =>  $rules,
            'jenis' =>  $rules,
            'keluhan' =>  $rules,
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
        return redirect()->route('laporanservices.index');
    }
    public function updateNominal(Request $request)
    {
        $transaksiId = $request->input('id');
        $nominal = $request->input('nominal');

        $transaksi = Transaksi::find($transaksiId);
        if ($transaksi && $transaksi->jenis_transaksi == 'SERVICES') {
            $transaksi->services->nominal = $nominal;
            $transaksi->services->save();

            // Update the status to 'lunas'
            $transaksi->status = 'lunas';
            $transaksi->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}

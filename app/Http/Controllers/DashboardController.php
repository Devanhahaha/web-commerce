<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $transaksi = Transaksi::all();

    $transaksiPerBulan = $transaksi->groupBy(function ($item) {
        return $item->created_at->format('Y-m');
    });

    $keuntunganPerBulan = $transaksiPerBulan->map(function ($item, $key) {
        return [
            'total' => count($item),
            'pulsa' => $item->where('jenis_transaksi', 'PULSA')->count(),
            'paketData' => $item->where('jenis_transaksi', 'PAKETDATA')->count(),
            'bayarTagihan' => $item->where('jenis_transaksi', 'BAYARTAGIHAN')->count(),
            'services' => $item->where('jenis_transaksi', 'SERVICES')->count(),
            'product' => $item->where('jenis_transaksi', 'PRODUCT')->count(),
        ];
    });
    return view('dashboard', compact('keuntunganPerBulan'));
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
        //
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

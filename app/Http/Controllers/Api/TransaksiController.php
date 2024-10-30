<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksiData = DB::table('transaksis')
        ->select(DB::raw("MONTHNAME(created_at) as bulan"), DB::raw("COUNT(id) as total_transaksi")) // Pastikan menggunakan COUNT(id) atau COUNT(*) untuk aggregasi yang valid
        ->groupBy(DB::raw("YEAR(created_at), MONTH(created_at)"))  // Kelompokkan berdasarkan tahun dan bulan
        ->orderBy(DB::raw("YEAR(created_at), MONTH(created_at)"))
        ->where(DB::raw("YEAR(created_at)"), date('Y'))
        ->get();

// Convert the data to JSON format


// Output the JSON
return response()->json($transaksiData);
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

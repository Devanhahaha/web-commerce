<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaketData;
use Illuminate\Http\Request;

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
}

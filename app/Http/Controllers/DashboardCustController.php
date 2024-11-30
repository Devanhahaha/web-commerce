<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardCustController extends Controller
{
    public function index()
    {
        return view('dashboardcust');
    }
}

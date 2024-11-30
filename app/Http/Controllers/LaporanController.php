<?php
namespace App\Http\Controllers;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan pagination untuk membatasi jumlah data yang dimuat
        $data['transaksi'] = Transaksi::with(['pulsa', 'paketdata', 'bayartagihan', 'services', 'product'])
                                       ->latest()
                                       ->paginate(10); // Limit data per halaman
        return view('laporan', $data);
    }
}

// Baris kosong di akhir file

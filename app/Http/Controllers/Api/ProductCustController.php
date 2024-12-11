<?php

namespace App\Http\Controllers\Api;

use Midtrans\Snap;

use Midtrans\Config;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\ProductCust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductCustController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productcust = ProductCust::with('product')->get();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $productcust,
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
        // Validasi input dari user
        $validatedData = $request->validate([
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'catatan' => 'nullable|string',
            'kurir' => 'required|string',
            'provinsi' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'ongkir' => 'required',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();
        try {
            // Membuat kode transaksi unik
            $jenis = 'PRODUCT';
            $prefix = "TRX-$jenis-";
            $uniquePart = uniqid();
            $code = strtoupper($prefix . substr($uniquePart, -6));

            // Membuat entri transaksi
            $transaksi = Transaksi::create([
                'user_id' => Auth::user()->id,
                'order_id' => $code,
                'status' => 'belum di kirim',
                'jenis_transaksi' => $jenis,
                'jenis_pembayaran' => $request->payment_method,
            ]);

            $total = 0;
            $cart = session()->get('cart', []);  // Ambil cart dari session

            // Loop untuk setiap produk yang dipesan
            foreach ($request->product_id as $i => $productId) {
                // Cari produk berdasarkan ID
                $product = Product::find($productId);

                // Jika produk tidak ditemukan, return error 404
                if (!$product) {
                    return response()->json([
                        'error' => "Product with ID $productId not found.",
                    ], 404); // Respond with 404 Not Found
                }

                // Membuat entri untuk produk yang dipesan
                $order = ProductCust::create([
                    'product_id' => $productId,
                    'transaksi_id' => $transaksi->id,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'catatan' => $request->catatan,
                    'kurir' => $request->kurir,
                    'provinsi' => $request->provinsi,
                    'kabupaten' => $request->kabupaten,
                    'ongkir' => $request->ongkir,
                    'quantity' => $request->quantity[$i],
                    'sub_total' => $request->sub_total[$i],
                ]);

                // Menghitung subtotal produk
                $subtotal = $product->nominal * $request->quantity[$i];
                $total += $subtotal;

                // Update stok produk
                $product->stok = $product->stok - $request->quantity[$i];
                $product->save();
            }

            // Tambahkan ongkir ke total
            $total += $request->ongkir;

            // Update cart di session setelah transaksi berhasil
            session()->put('cart', $cart);

            // Proses pembayaran (jika ada)

            // Commit transaksi jika tidak ada error
            DB::commit();

            // Return response sukses dengan status 201 Created
            return response()->json([
                'message' => 'Order successfully created.',
                'order' => $transaksi,
                'total' => $total,
            ], 201); // Respond with 201 Created status
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage(),
            ], 500); // Respond with 500 Internal Server Error
        }
    }


    public function getMidtransToken(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'total_amount' => 'required|numeric', // Jumlah total untuk transaksi
            'phone' => 'required|string|max:15', // Nomor telepon pengguna
        ]);
        Log::info('Total Amount: ' . $request->total_amount);
        try {
            // Membuat transaksi Midtrans
            $transaction_details = [
                'order_id' => uniqid('TRX-ORDERPRODUCT-'), // ID transaksi unik
                'gross_amount' => $request->total_amount, // Jumlah total transaksi
            ];
            Log::info('Transaction Details: ' . json_encode($transaction_details));
            // Detail pelanggan
            $customer_details = [
                'first_name' => Auth::user()->first_name, // Nama depan pengguna
                'email' => Auth::user()->email,           // Email pengguna
                'phone' => $request->phone,               // Nomor telepon pengguna
            ];
    
            // Daftar metode pembayaran yang diaktifkan
            $enable_payments = [
                "credit_card",
                "cimb_clicks",
                "bca_klikbca",
                "bca_klikpay",
                "bri_epay",
                "echannel",
                "permata_va",
                "bca_va",
                "bni_va",
                "bri_va",
                "other_va",
                "gopay",
                "indomaret",
                "danamon_online",
                "akulaku",
                "shopeepay"
            ];
    
            // Konfigurasi data transaksi Midtrans
            $transactionMidtrans = [
                'enabled_payments' => $enable_payments,
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
            ];
    
            // Mendapatkan token transaksi dari Midtrans
            $snapToken = Snap::getSnapToken($transactionMidtrans);
    
            // Mengembalikan token dalam response
            return response()->json([
                'token' => $snapToken
            ], 200);
        } catch (\Exception $e) {
            // Menangani error jika terjadi masalah
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
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

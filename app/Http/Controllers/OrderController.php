<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductCust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Exceptions\RajaOngkirException;

class OrderController extends Controller
{
    const VALIDATION_RULES = [
        'string_max_255' => 'required|string|max:255',
        'string_max_15' => 'required|string|max:15',
        'nullable_string' => 'nullable|string|max:255',
        'required' => 'required',
    ];

    const STATUS_PENDING = 'belum di kirim';
    const STATUS_SHIPPED = 'sudah di kirim';
    const STATUS_RECEIVED = 'barang diterima';

    public function store(Request $request)
    {
        try {
            // Validasi input
            $this->validateRequest($request);

            // Ambil nama provinsi dan kabupaten
            $namaProvinsi = $this->getProvinceName($request->provinsi);
            $namaKabupaten = $this->getCityName($request->kabupaten);

            // Simpan data order
            $order = $this->createOrder($request, $namaProvinsi, $namaKabupaten);

            // Simpan data produk dalam order
            $this->createProductCustEntries($order);

            // Kirim response sukses
            return response()->json([
                'message' => 'Order berhasil dibuat',
                'order' => $order,
            ], 201);
        } catch (\Exception $e) {
            // Log error
            Log::error('Order Store Error', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'error' => 'Terjadi kesalahan saat membuat order',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    private function validateRequest(Request $request)
    {
        $request->validate([
            'alamat' => self::VALIDATION_RULES['string_max_255'],
            'no_hp' => self::VALIDATION_RULES['string_max_15'],
            'catatan' => self::VALIDATION_RULES['nullable_string'],
            'kurir' => self::VALIDATION_RULES['required'],
            'provinsi' => self::VALIDATION_RULES['string_max_255'],
            'kabupaten' => self::VALIDATION_RULES['string_max_255'],
            'ongkir' => self::VALIDATION_RULES['required'],
        ]);
    }
    private function getProvinceName($provinceId)
    {
        $response = Http::withHeaders(['key' => env('RAJA_ONGKIR_KEY')])
            ->get('https://api.rajaongkir.com/starter/province');

        if ($response->failed() || !isset($response['rajaongkir']['results'])) {
            throw new RajaOngkirException('Gagal mengambil data provinsi dari API Raja Ongkir.');
        }

        return collect($response->json()['rajaongkir']['results'])
            ->firstWhere('province_id', $provinceId)['province'] ?? 'Provinsi tidak ditemukan';
    }
    private function getCityName($cityId)
    {
        $response = Http::withHeaders(['key' => env('RAJA_ONGKIR_KEY')])
            ->get('https://api.rajaongkir.com/starter/city');

        if ($response->failed() || !isset($response['rajaongkir']['results'])) {
            throw new RajaOngkirException('Gagal mengambil data kabupaten dari API Raja Ongkir.');
        }

        return collect($response->json()['rajaongkir']['results'])
            ->firstWhere('city_id', $cityId)['city_name'] ?? 'Kabupaten tidak ditemukan';
    }
    private function createOrder(Request $request, $namaProvinsi, $namaKabupaten)
    {
        return Order::create([
            'user_id' => Auth::id(),
            'kode_transaksi' => 'TRX-PRODUCT-' . time(),
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'catatan' => $request->catatan,
            'kurir' => $request->kurir,
            'provinsi' => $namaProvinsi,
            'kabupaten' => $namaKabupaten,
            'ongkir' => $request->ongkir,
            'status' => self::STATUS_PENDING,
        ]);
    }
    private function createProductCustEntries(Order $order)
    {
        $cartItems = ProductCust::where('user_id', Auth::id())
            ->where('is_checkout', false)
            ->get();

        foreach ($cartItems as $item) {
            $order->products()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'subtotal' => $item->quantity * $item->price,
            ]);
            $item->product->decrement('stock', $item->quantity);
            $item->update(['is_checkout' => true]);
        }
    }
}

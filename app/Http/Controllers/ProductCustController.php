<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\ProductCust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductCustController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }
    public function index()
    {
        $data['productCust'] = Product::all();
        return view('productcust', $data);
    }
    public function checkout(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $quantity = $request->qty ?? 1;
        $total = $product->nominal * $quantity;

        return view('checkout', [
            'co' => [$product],
            'quantity' => $quantity,
            'total' => $total,
            'type' => $request->type
        ]);
    }
    public function showCheckout($id)
    {
        $productcust = ProductCust::findOrFail($id);
        return view('checkout', compact('productcust'));
    }
    public function checkoutCart(Request $request)
    {
        $user_id = Auth::id();
        $cart = collect(session('cart'))->filter(fn($item) => $item['user_id'] == $user_id);

        if (!$request->has('selected_products') || empty($request->selected_products)) {
            return redirect()->back()->with('error', 'Pilih produk terlebih dahulu!');
        }

        $checkoutItems = [];
        foreach ($request->selected_products as $id) {
            $product = Product::find($id);
            $cartItem = $cart->get($id);

            if ($product && $product->stok >= $cartItem['quantity']) {
                $checkoutItems[] = $cartItem;
            } else {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk produk: ' . $product->nama_product);
            }
        }

        return view('checkout', ['co' => $checkoutItems]);
    }
    public function checkoutSelected(Request $request)
    {
        $selectedProducts = $request->input('selected_products', []);

        if (empty($selectedProducts)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih untuk checkout.');
        }

        $cart = session('cart', []);
        $selectedItems = array_filter($cart, fn($key) => in_array($key, $selectedProducts), ARRAY_FILTER_USE_KEY);

        session()->put('selectedItems', $selectedItems);
        return redirect()->route('checkout');
    }
    private function kurangiStokProduct($quantity, $jenis)
    {
        $product = Product::where('jenis', $jenis)->first();

        if ($product) {
            $product->decrement('stok', $quantity);
        }
    }
    public function store(Request $request)
    {
        $rules = 'required|string|max:255';
        $validated = $request->validate([
            'name' => $rules,
            'jenis' => $rules,
            'merk' => $rules,
            'deskripsi' => 'required|string',
            'nominal' => 'required|numeric',
            'gambar' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $orderId = $this->generateOrderId('PRODUCT');

            $transaksi = Transaksi::create([
                'user_id' => Auth::id(),
                'order_id' => $orderId,
                'status' => 'belum di kirim',
                'jenis_transaksi' => 'PRODUCT',
                'jenis_pembayaran' => 'online',
            ]);

            $filePath = $this->uploadFile($request->file('gambar'), 'files/product/');

            $nominal = str_replace('.', '', $request->nominal);
            $quantity = $request->input('quantity', 1);
            $ongkir = (int) str_replace('.', '', $request->ongkir ?? 0);
            $totalNominal = ($nominal * $quantity) + $ongkir;

            Product::create([
                'nama_product' => $validated['name'],
                'jenis' => $validated['jenis'],
                'merk' => $validated['merk'],
                'deskripsi' => $validated['deskripsi'],
                'nominal' => $nominal,
                'gambar' => $filePath,
            ]);

            $this->kurangiStokProduct($quantity, $validated['jenis']);

            $transactionDetails = [
                'order_id' => $transaksi->order_id,
                'gross_amount' => $totalNominal,
            ];

            $customerDetails = [
                'first_name' => $validated['name'],
                'email' => Auth::user()->email,
                'phone' => $request->number,
            ];

            $enablePayments = [
                'credit_card',
                'cimb_clicks',
                'bca_klikbca',
                'bca_klikpay',
                'bri_epay',
                'echannel',
                'permata_va',
                'bca_va',
                'bni_va',
                'bri_va',
                'other_va',
                'gopay',
                'indomaret',
                'danamon_online',
                'akulaku',
                'shopeepay'
            ];

            $transactionMidtrans = [
                'enabled_payments' => $enablePayments,
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
            ];

            $urlTransaction = Snap::createTransaction($transactionMidtrans)->redirect_url;
            $transaksi->update(['url_transaksi' => $urlTransaction]);

            DB::commit();
            return redirect($urlTransaction);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    private function generateOrderId($prefix)
    {
        $uniquePart = strtoupper(substr(uniqid(), -6));
        return "$prefix-TRX-$uniquePart";
    }
    private function uploadFile($file, $path)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path($path), $fileName);
        return $path . $fileName;
    }
}

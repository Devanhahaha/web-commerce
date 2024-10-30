<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function addToCart(Request $request)
     {
         $productId = $request->input('product_id');
         $product = Product::find($productId);
 
         if(!$product) {
             return redirect()->back()->with('error', 'Product not found');
         }
 
         $cart = session()->get('cart', []);
 
         // Check if product is already in cart
         if(isset($cart[$productId]) && isset($cart[$productId]['user_id']) ? $cart[$productId]['user_id'] == Auth::user()->id : false) {
             $cart[$productId]['quantity']++;
         } else {
             $cart[$productId] = [
                 "user_id" => Auth::user()->id,
                 "id" => $product->id,
                 "nama_product" => $product->nama_product,
                 "jenis" => $product->jenis,
                 "merk" => $product->merk,
                 "deskripsi" => $product->deskripsi,
                 "nominal" => $product->nominal,
                 "gambar" => $product->gambar,
                 "quantity" => 1
             ];
         }
 
         session()->put('cart', $cart);
         return redirect()->back()->with('success', 'Product Berhasil Di Masukan Ke Dalam Keranjang!');
     }
 
     // Display Cart
    //  public function viewCart()
    //  {
    //     $cart = session()->get('cart');
    //     return view('cart.index', compact('cart'));
    //  }
 
     // Remove product from cart
     public function removeFromCart($id)
{
    $cart = session()->get('cart');

    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
}
    public function index()
    {
        return view('cart');
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
        $cart = session()->get('cart');

        if ($request->action == 'increase') {
            $cart[$id]['quantity']++;
        } elseif ($request->action == 'decrease' && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        }
    
        session()->put('cart', $cart);
    
        return redirect()->back()->with('success', 'Quantity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

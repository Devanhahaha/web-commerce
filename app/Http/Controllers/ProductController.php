<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    private const PRODUCT_IMAGE_PATH = 'files/product/';
    public function index()
    {
        $data['product'] = Product::all();
        return view('product', $data);
    }
    public function create()
    {
        return view('addproduct');
    }
    public function store(ProductRequest $request)
    {
        $gambarPath = $this->uploadFile($request->file('gambar'), self::PRODUCT_IMAGE_PATH);

        Product::create([
            'nama_product' => $request->name,
            'jenis' => $request->jenis,
            'merk' => $request->merk,
            'deskripsi' => $request->deskripsi,
            'nominal' => str_replace('.', '', $request->nominal),
            'stok' => $request->stok,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('product.index')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }
    public function update(ProductRequest $request, Product $product)
    {
        $product->fill([
            'nama_product' => $request->name,
            'jenis' => $request->jenis,
            'merk' => $request->merk,
            'deskripsi' => $request->deskripsi,
            'nominal' => str_replace('.', '', $request->nominal),
            'stok' => $request->stok,
        ]);

        if ($request->hasFile('gambar')) {
            $product->gambar = $this->uploadFile($request->file('gambar'), self::PRODUCT_IMAGE_PATH);
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product edited successfully.');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
    private function uploadFile($file, $path)
    {
        $nameFile = $file->getClientOriginalName();
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
        $file->move($path, $nameFile);
        return $path . $nameFile;
    }
}

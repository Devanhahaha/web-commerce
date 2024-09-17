<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['product'] = Product::get();
        return view('product', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addproduct');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $file = $request->file('gambar');
        $path = 'files/product/';
        $nameFile = $file->getClientOriginalName();


        $nominal = str_replace('.', '', $request->nominal);
        $request->validate([
            'name' => 'required|string',
            'jenis' => 'required|string',
            'merk' => 'required|string',
            'deskripsi' => 'required|string',
            'nominal' => 'required',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,svg,webp',
        ]);

        Product::create([
            'nama_product' => $request->name,
            'jenis' => $request->jenis,
            'merk' => $request->merk,
            'deskripsi' => $request->deskripsi,
            'nominal' => $nominal,
            'gambar' => $path . $nameFile
        ]);

        if (!File::isDirectory($path)) File::makeDirectory($path, 0755, true, true);

        $file->move($path, $nameFile);

        return redirect()->route('product.index')->with('success', 'Data berhasil ditambahkan');
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
        try {
            $product = Product::findOrFail($id);
            return view('product.edit', compact('product'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Product not found.');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);


            $product->nama_product = $request->name;
            $product->jenis = $request->jenis;
            $product->merk = $request->merk;
            $product->deskripsi = $request->deskripsi;
            $product->nominal = str_replace('.', '', $request->nominal);


            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $path = 'files/product/';
                $nameFile = $file->getClientOriginalName();


                $product->gambar = $path . $nameFile;


                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }
                $file->move($path, $nameFile);
            }


            $product->save();

            return redirect()->route('product.index')->with('success', 'Product edited successfully.');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Product not found.');
        }
    }

    /**
     * Remove the specified resource from storage.P
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}

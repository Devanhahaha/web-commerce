<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    private function handleFileUpload($file, $path)
    {
        $nameFile = $file->getClientOriginalName();

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }

        $file->move($path, $nameFile);

        return $path . $nameFile;
    }
    public function index()
    {
        try {
            $products = Product::all();

            return response()->json([
                "status" => 200,
                "message" => "Data retrieved successfully",
                "data" => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => "Error fetching data",
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $file = $request->file('gambar');
            $path = 'files/product/';
            $nominal = str_replace('.', '', $request->nominal);

            $productData = [
                'nama_product' => $request->nama_product,
                'jenis' => $request->jenis,
                'merk' => $request->merk,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'nominal' => $nominal,
                'gambar' => $this->handleFileUpload($file, $path)
            ];

            $product = Product::create($productData);

            return response()->json([
                "status" => 200,
                "message" => "Data successfully submitted",
                "data" => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => "Error submitting data",
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $product->nama_product = $request->nama_product;
            $product->jenis = $request->jenis;
            $product->merk = $request->merk;
            $product->deskripsi = $request->deskripsi;
            $product->stok = $request->stok;
            $product->nominal = str_replace('.', '', $request->nominal);

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $path = 'files/product/';

                $product->gambar = $this->handleFileUpload($file, $path);
            }

            $product->save();

            return response()->json([
                "status" => 200,
                "message" => "Data successfully updated",
                "data" => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => "Error updating data",
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);

            if (File::exists($product->gambar)) {
                File::delete($product->gambar);
            }

            $product->delete();

            return response()->json([
                "status" => 200,
                "message" => "Data successfully deleted"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => "Error deleting data",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}

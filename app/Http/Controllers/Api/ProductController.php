<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $product = Product::all();

            return response()->json([
                "status" => 200,
                "message" => "Data retrieved successfully",
                "data" => $product
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 500,
                "message" => "Error fetching data",
                "error" => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $file = $request->file('gambar');
            $path = 'files/product/';
            $nameFile = $file->getClientOriginalName();

            $nominal = str_replace('.', '', $request->nominal);

            $product = Product::create([
                'nama_product' => $request->nama_product,
                'jenis' => $request->jenis,
                'merk' => $request->merk,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'nominal' => $nominal,
                'gambar' => $path.$nameFile
            ]);

            if (!File::isDirectory($path)) File::makeDirectory($path, 0755, true, true);

            $file->move($path, $nameFile);

            return response()->json([
                "status" => 200,
                "message" => "Data successfully submitted",
                "data" => $product
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 500,
                "message" => "Error submitting data",
                "error" => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            $product->nama_product = $request->nama_product;
            $product->jenis = $request->jenis;
            $product->merk = $request->merk;
            $product->deskripsi = $request->deskripsi;
            $product->stok = $request->stok;
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

            
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 500,
                "message" => "Error updating data",
                "error" => $th->getMessage()
            ], 500);
        }
        return response()->json([
            "status" => 200,
            "message" => "Data successfully updated",
            "data" => $product
        ]);
    }

    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                "status" => 200,
                "message" => "Data successfully deleted"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 500,
                "message" => "Error deleting data",
                "error" => $th->getMessage()
            ], 500);
        }
    }
}

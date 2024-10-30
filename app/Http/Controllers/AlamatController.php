<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getProvinsi()
{
    $apiKey = '6f4308547a4430b68f2481ba03aa93c2';
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', 'https://api.rajaongkir.com/starter/province', [
        'headers' => [
            'key' => $apiKey
        ]
    ]);
    
    $provinsi = json_decode($response->getBody(), true);
    return response()->json($provinsi);
}

public function getKabupaten($provinsi_id)
{
    $apiKey = '6f4308547a4430b68f2481ba03aa93c2';
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', 'https://api.rajaongkir.com/starter/city', [
        'headers' => [
            'key' => $apiKey
        ],
        'query' => ['province' => $provinsi_id]
    ]);

    $kabupaten = json_decode($response->getBody(), true);
    return response()->json($kabupaten);
}

public function getOngkir(Request $request)
{
    $apiKey = '6f4308547a4430b68f2481ba03aa93c2';
    $origin = 501; // ID kota asal pengiriman (contoh: Jakarta)
    $destination = $request->kabupaten; // ID kabupaten tujuan
    $weight = 1; // Berat barang dalam gram
    $courier = $request->kurir; // Kurir yang dipilih oleh pengguna (jne, pos, tiki, dll.)

    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'https://api.rajaongkir.com/starter/cost', [
        'headers' => [
            'key' => $apiKey
        ],
        'form_params' => [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ]
    ]);

    $ongkir = json_decode($response->getBody(), true);

    if (isset($ongkir['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'])) {
        $value = $ongkir['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'];
        return response()->json(['ongkir' => $value]);
    } else {
        return response()->json(['ongkir' => 'Tidak tersedia']);
    }
}


    
    public function index()
    {
        //
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

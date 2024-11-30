<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Konstanta untuk API key (gunakan .env untuk keamanan)
    const API_KEY = '6f4308547a4430b68f2481ba03aa93c2';

    // Atau gunakan konfigurasi:
    protected $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    // Reusable function untuk header
    private function getHeaders()
    {
        return [
            'headers' => [
                'key' => self::API_KEY
            ]
        ];
    }

    // Metode: dapatkanProvinsi
    private function requestRajaOngkir($method, $endpoint, $options = [])
    {
        try {
            $response = $this->client->request($method, $endpoint, array_merge($this->getHeaders(), $options));
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function getProvinsi()
    {
        $response = $this->requestRajaOngkir('GET', 'https://api.rajaongkir.com/starter/province');
        $provinsi = json_decode($response->getBody(), true);
        return response()->json($provinsi);
    }

        public function getkabupaten(Request $request)
    {
        $request->validate([
            'provinsi_id' => 'required|integer'
        ]);

        $response = $this->requestRajaOngkir('GET', 'https://api.rajaongkir.com/starter/city', [
            'query' => ['province' => $request->provinsi_id]
        ]);

        return response()->json($response);
    }



    public function getOngkir(Request $request)
    {
        $asal = config('rajaongkir.origin_city_id', 501); // ID kota asal dari konfigurasi
        $berat = $request->berat ?? 1000; // Berat default 1000 gram jika tidak ada input
    
        $response = $this->client->request('POST', 'https://api.rajaongkir.com/starter/cost', array_merge(
            $this->getHeaders(),
            [
                'form_params' => [
                    'origin' => $asal,
                    'destination' => $request->kabupaten,
                    'weight' => $berat,
                    'courier' => $request->kurir,
                ]
            ]
        ));
    
        $ongkir = json_decode($response->getBody(), true);
        return response()->json($ongkir);
    }
}

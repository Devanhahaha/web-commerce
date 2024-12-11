<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;

class Transaction extends Controller
{
    private static function configureMidtrans()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
    }

    private static function getApiEndpoint($id, $action)
    {
        return Config::getBaseUrl() . '/' . $id . '/' . $action;
    }
    public static function status($id)
    {
        self::configureMidtrans();
        $data = ApiRequestor::get(
            self::getApiEndpoint($id, 'status'),
            Config::$serverKey,
            false
        );
        return response()->json($data);
    }
    public static function approve($id)
    {
        self::configureMidtrans();
        return ApiRequestor::post(
            self::getApiEndpoint($id, 'approve'),
            Config::$serverKey,
            false
        )->status_code;
    }
    public static function cancel($id)
    {
        self::configureMidtrans();
        return ApiRequestor::post(
            self::getApiEndpoint($id, 'cancel'),
            Config::$serverKey,
            false
        )->status_code;
    }
}

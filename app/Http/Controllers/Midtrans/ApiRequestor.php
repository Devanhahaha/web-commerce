<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;
use App\Exceptions\CurlException;
use App\Exceptions\ApiException;

class ApiRequestor extends Controller
{
    public static function get($url, $server_key, $data_hash)
    {
        return self::remoteCall($url, $server_key, $data_hash, false);
    }

    public static function post($url, $server_key, $data_hash)
    {
        return self::remoteCall($url, $server_key, $data_hash, true);
    }

    public static function remoteCall($url, $server_key, $data_hash, $post = true)
    {
        $ch = curl_init();
        $curl_options = self::buildCurlOptions($url, $server_key, $data_hash, $post);
        curl_setopt_array($ch, $curl_options);
        self::configureSsl($ch);
        $result = curl_exec($ch);
        return self::processResult($result, $ch);
    }

    private static function buildCurlOptions($url, $server_key, $data_hash, $post)
    {
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => self::buildHeaders($server_key),
            CURLOPT_RETURNTRANSFER => true,
        ];
        if ($post) {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = $data_hash ? json_encode($data_hash) : '';
        }
        return $options;
    }

    private static function buildHeaders($server_key)
    {
        return [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($server_key . ':'),
        ];
    }

    private static function configureSsl($ch)
    {
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    private static function processResult($result, $ch)
    {
        if ($result === false) {
            throw new CurlException('CURL Error: ' . curl_error($ch), curl_errno($ch));
        }

        $result_array = json_decode($result);
        if (!in_array($result_array->status_code, [200, 201, 202, 407])) {
            throw new ApiException(
                self::buildErrorMessage($result_array),
                $result_array->status_code
            );
        }
        return $result_array;
    }

    private static function buildErrorMessage($result_array)
    {
        $message = 'Midtrans Error (' . $result_array->status_code . '): ' . $result_array->status_message;
        if (isset($result_array->validation_messages)) {
            $message .= '. Validation Messages (' . implode(", ", $result_array->validation_messages) . ')';
        }
        return $message;
    }
}

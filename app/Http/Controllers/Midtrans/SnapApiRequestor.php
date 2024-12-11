<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


/**
 * Send request to Snap API
 * Better don't use this class directly, use Snap
 */

class SnapApiRequestor extends Controller
{
    /**
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     */
    public static function get($url, $server_key, $data_hash)
    {
        return self::remoteCall($url, $server_key, $data_hash, false);
    }

    /**
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     */
    public static function post($url, $server_key, $data_hash)
    {
        return self::remoteCall($url, $server_key, $data_hash, true);
    }

    /**
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     * @param bool    $post
     */
    public static function remoteCall($url, $server_key, $data_hash, $post = true)
    {
        $ch = curl_init();
        $curl_options = self::prepareCurlOptions($url, $server_key, $data_hash, $post);
        curl_setopt_array($ch, $curl_options);

        $result = self::executeCurl($ch, $url);
        $info = curl_getinfo($ch);

        return self::processResult($result, $info, $url);
    }
    private static function prepareCurlOptions($url, $server_key, $data_hash, $post)
    {
        $curl_options = [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($server_key . ':')
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        if ($post) {
            $curl_options[CURLOPT_POST] = true;
            $curl_options[CURLOPT_POSTFIELDS] = $data_hash ? json_encode($data_hash) : '';
        }

        return $curl_options;
    }
    private static function executeCurl($ch)
    {
        $result = curl_exec($ch);

        if ($result === false) {
            throw new CurlException('CURL Error: ' . curl_error($ch), curl_errno($ch));
        }

        return $result;
    }
    private static function processResult($result, $info)
    {
        $result_array = json_decode($result);

        if ($info['http_code'] != 201) {
            throw new ApiException('Midtrans Error (' . $info['http_code'] . '): ' . $result, $info['http_code']);
        }

        return $result_array;
    }
}

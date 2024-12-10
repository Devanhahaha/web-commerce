<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;

class Sanitizer extends Controller
{
    private $filters;

    public function __construct()
    {
        $this->filters = [];
    }
    /**
     * Validates and modifies data in the provided JSON object.
     *
     * @param mixed[] $json
     */
    public static function jsonRequest(&$json)
    {
        $keys = ['item_details', 'customer_details'];
        foreach ($keys as $key) {
            if (!isset($json[$key])) {
                continue;
            }
            $camel = static::upperCamelize($key);
            $function = "field$camel";
            if (method_exists(static::class, $function)) {
                static::$function($json[$key]);
            }
        }
    }
    private static function upperCamelize($string)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }
}

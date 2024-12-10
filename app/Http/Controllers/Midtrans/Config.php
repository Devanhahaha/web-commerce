<?php

namespace App\Http\Controllers\Midtrans;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Midtrans Configuration
 */
class MidtransConfig
{
    public $serverKey;
    public $clientKey;
    public $isProduction;
    public $is3ds;
    public $appendNotifUrl;
    public $overrideNotifUrl;
    public $isSanitized;
    public $curlOptions;

    public function __construct(array $config = [])
    {
        $this->serverKey = $config['serverKey'] ?? null;
        $this->clientKey = $config['clientKey'] ?? null;
        $this->isProduction = $config['isProduction'] ?? false;
        $this->is3ds = $config['is3ds'] ?? false;
        $this->appendNotifUrl = $config['appendNotifUrl'] ?? null;
        $this->overrideNotifUrl = $config['overrideNotifUrl'] ?? null;
        $this->isSanitized = $config['isSanitized'] ?? false;
        $this->curlOptions = $config['curlOptions'] ?? [];
    }
}

class Config
{
    const BASE_URLS = [
        'sandbox' => 'https://api.sandbox.midtrans.com/v2',
        'production' => 'https://api.midtrans.com/v2',
    ];

    const SNAP_BASE_URLS = [
        'sandbox' => 'https://app.sandbox.midtrans.com/snap/v1',
        'production' => 'https://app.midtrans.com/snap/v1',
    ];

    private static $config;

    public static function initialize(MidtransConfig $config)
    {
        self::$config = $config;
    }

    public static function getBaseUrl()
    {
        return self::$config->isProduction
            ? self::BASE_URLS['production']
            : self::BASE_URLS['sandbox'];
    }

    public static function getSnapBaseUrl()
    {
        return self::$config->isProduction
            ? self::SNAP_BASE_URLS['production']
            : self::SNAP_BASE_URLS['sandbox'];
    }
}

<?php

namespace App\Http\Controllers\Midtrans;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


/**
 * Create Snap payment page and return snap token
 */
class Snap extends Controller
{
    /**
     * @param  array $params Payment options
     * @return string Snap token.
     * @throws Exception curl error or midtrans error
     */
    public static function getSnapToken($params)
    {
        return Snap::createTransaction($params);
    }

    /**
     * @param  array $params Payment options
     * @return object Snap response (token and redirect_url).
     * @throws Exception curl error or midtrans error
     */
    public static function createTransaction($params)
    {
        $params = self::addCreditCardConfig($params);

        if (isset($params['item_details'])) {
            $params['transaction_details']['gross_amount'] = self::calculateGrossAmount($params['item_details']);
        }

        if (Config::$isSanitized) {
            Sanitizer::jsonRequest($params);
        }

        self::configureNotificationHeaders();

        $params = array_replace_recursive(self::getDefaultPayloads(), $params);

        return SnapApiRequestor::post(
            Config::getSnapBaseUrl() . '/transactions',
            Config::$serverKey,
            $params
        );
    }
    private static function addCreditCardConfig($params)
    {
        $params['credit_card'] = ['secure' => Config::$is3ds];
        return $params;
    }
    private static function calculateGrossAmount($items)
    {
        $grossAmount = 0;
        foreach ($items as $item) {
            $grossAmount += $item['quantity'] * $item['price'];
        }
        return $grossAmount;
    }
    private static function configureNotificationHeaders()
    {
        if (Config::$appendNotifUrl) {
            Config::$curlOptions[CURLOPT_HTTPHEADER][] = 'X-Append-Notification: ' . Config::$appendNotifUrl;
        }

        if (Config::$overrideNotifUrl) {
            Config::$curlOptions[CURLOPT_HTTPHEADER][] = 'X-Override-Notification: ' . Config::$overrideNotifUrl;
        }
    }
    private static function getDefaultPayloads()
    {
        return [
            'credit_card' => [
                'secure' => Config::$is3ds,
            ],
        ];
    }
}

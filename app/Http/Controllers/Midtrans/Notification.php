<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;

class Notification extends Controller
{
    private $response;
    private $transactionService;

    public function __construct($input_data, $transactionService)
    {
        $this->transactionService = $transactionService;

        $raw_notification = json_decode($input_data, true);

        if (!isset($raw_notification['transaction_id'])) {
            throw new \InvalidArgumentException("Invalid input: Missing 'transaction_id'");
        }

        $this->response = $this->transactionService->status($raw_notification['transaction_id']);
    }

    public function getTransactionStatus()
    {
        return $this->response->transaction_status ?? null;
    }

    public function getOrderId()
    {
        return $this->response->order_id ?? null;
    }

    public function getResponse()
    {
        return $this->response;
    }
}

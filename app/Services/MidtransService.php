<?php

namespace App\Services;

use App\Models\Pricing;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use Midtrans\Notification;

class MidtransService {
  public function __construct() 
  {
      // Set Midtrans Configuration
      Config::$serverKey = config('midtrans.serveKey');
      Config::$isProduction = config('midtrans.isProduction');
      Config::$isSanitized = config('midtrans.isSanitized');
      Config::$isProduction = config('midtrans.is3ds');

  }

  public function createSnapToken(array $params): string
  {
    try {
      return Snap::getSnapToken($params);
    } catch (\Exception $e) {
      Log::error('Failed to create snap token : ' . $e->getMessage());
      throw $e;
    }
  }

  public function handleNotification(): array
  {
    try {
      $notification = new Notification(); // Automatically load data from the request

      return [
        'order_id' => $notification->order_id,
        'transaction_status' => $notification->transaction_status,
        'gorss_amount' => $notification->gross_amount,
        'custom_field1' => $notification->field1,
        'custom_field2' => $notification->field2,
      ];
    } catch (\Exception $e) {
      Log::error('Failed to create snap token : ' . $e->getMessage());
      throw $e;
    }
  }
}
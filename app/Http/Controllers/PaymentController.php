<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Rent;

class PaymentController extends Controller
{
    public function receiveNotification(Request $request)
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Create notification instance
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;

        // Assuming order_id is the Rent ID
        $rent = Rent::find($orderId);

        if (!$rent) {
            return response()->json(['message' => 'Rent not found'], 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $rent->payment_status = 'paid';
        } elseif ($transactionStatus == 'pending') {
            $rent->payment_status = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $rent->payment_status = 'unpaid';
        }

        $rent->save();

        return response()->json(['message' => 'Notification processed']);
    }
}

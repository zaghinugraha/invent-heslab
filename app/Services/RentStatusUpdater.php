<?php

namespace App\Services;

use App\Models\Rent;
use Carbon\Carbon;

class RentStatusUpdater
{
    public function updateStatuses()
    {
        $today = Carbon::today();

        // Update rents to 'overdue' where 'end_date' is past and status is 'active'
        Rent::where('order_status', 'active')
            ->whereDate('end_date', '<', $today)
            ->update(['order_status' => 'overdue']);

        // Update rents to 'active' where 'payment_status' is 'paid' and 'start_date' is today or earlier
        Rent::where('payment_status', 'paid')
            ->where('order_status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->update(['order_status' => 'active']);

        // Update rents to 'cancelled' where 'payment_status' is 'unpaid' and past 'start_date'
        Rent::where('payment_status', 'unpaid')
            ->whereDate('start_date', '<', $today)
            ->update(['order_status' => 'cancelled']);

        // Update rents to 'rejected' where status is 'waiting' and past 'start_date'
        Rent::where('order_status', 'waiting')
            ->whereDate('start_date', '<', $today)
            ->update(['order_status' => 'rejected']);
    }
}

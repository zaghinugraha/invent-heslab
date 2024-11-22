<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rent;
use Carbon\Carbon;

class UpdateRentStatus extends Command
{
    protected $signature = 'rents:update-statuses';
    protected $description = 'Update rent statuses based on conditions';

    public function handle()
    {
        $today = Carbon::today();

        $rents = Rent::whereIn('order_status', ['approved', 'active', 'overdue', 'waiting'])->get();

        foreach ($rents as $rent) {
            // Update rent status to 'overdue' where 'end_date' is past and status is 'active'
            if ($rent->order_status === 'active' && $rent->end_date < $today) {
                $rent->order_status = 'overdue';
                $rent->save();
            }

            // Update rent status to 'active' where 'payment_status' is 'paid' and 'start_date' is today or earlier
            if ($rent->payment_status === 'paid' && $rent->order_status === 'approved' && $rent->start_date <= $today) {
                $rent->order_status = 'active';
                $rent->save();
            }

            // Update rent status to 'cancelled' where 'payment_status' is 'unpaid' and past 'start_date'
            if ($rent->payment_status === 'unpaid' && $rent->start_date < $today) {
                $rent->order_status = 'cancelled';
                $rent->save();
            }

            // Update rent status to 'rejected' where status is 'waiting' and past 'start_date'
            if ($rent->order_status === 'waiting' && $rent->start_date < $today) {
                $rent->order_status = 'rejected';
                $rent->save();
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RentStatusUpdater;
use App\Models\Rent;
use Carbon\Carbon;

class UpdateRentStatus extends Command
{
    protected $signature = 'rents:update-statuses';
    protected $description = 'Update rent statuses based on conditions';

    public function handle(RentStatusUpdater $updater)
    {
        $updater->updateStatuses();
        $this->info('Rent statuses updated successfully.');
    }
}

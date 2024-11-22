<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AdminHistoryController extends Controller
{
    public function history()
    {

        // Fetch rents with statuses: cancelled, rejected, returned
        $rents = Rent::with('items.product')
            ->whereIn('order_status', ['cancelled', 'rejected', 'returned'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate counts for status cards
        $cancelledCount = $rents->where('order_status', 'cancelled')->count();
        $rejectedCount = $rents->where('order_status', 'rejected')->count();
        $returnedCount = $rents->where('order_status', 'returned')->count();

        return view('dashboard-admin-history', compact('rents', 'rejectedCount', 'returnedCount', 'cancelledCount'));
    }
}

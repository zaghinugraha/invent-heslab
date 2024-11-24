<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AdminHistoryController extends Controller
{
    public function history(Request $request)
    {

        $search = $request->input('search');

        // Fetch rents with statuses: cancelled, rejected, returned
        $query = Rent::with('user', 'items.product')
            ->whereIn('order_status', ['cancelled', 'rejected', 'returned']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nim_nip', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($qUser) use ($search) {
                        $qUser->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('items.product', function ($qProduct) use ($search) {
                        $qProduct->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $rents = $query->orderBy('created_at', 'desc')->paginate(10)->appends(['search' => $search]);

        // Calculate counts for status cards
        $cancelledCount = $rents->where('order_status', 'cancelled')->count();
        $rejectedCount = $rents->where('order_status', 'rejected')->count();
        $returnedCount = $rents->where('order_status', 'returned')->count();

        return view('dashboard-admin-history', compact('rents', 'rejectedCount', 'returnedCount', 'cancelledCount'));
    }
}

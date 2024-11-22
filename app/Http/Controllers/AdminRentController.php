<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminRentController extends Controller
{
    public function index()
    {
        $rents = Rent::with('user', 'items.product')
            ->whereIn('order_status', ['approved', 'active', 'overdue', 'waiting'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $today = Carbon::today();

        foreach ($rents as $rent) {
            // Update rent status to 'overdue' where 'end_date' is past and status is 'active'
            if ($rent->order_status === 'active' && $rent->end_date < $today) {
                $rent->order_status = 'overdue';
                $rent->save();
            }

            // Update rent status to 'active' where 'payment_status' is 'paid' and 'start_date' is today
            if ($rent->payment_status === 'paid' && $rent->order_status !== 'active' && $rent->start_date === $today) {
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

        // Calculate counts for status cards
        $approvedCount = Rent::where('order_status', 'approved')->count();
        $onRentCount = Rent::where('order_status', 'active')->count();
        $overdueCount = Rent::where('order_status', 'overdue')->count();
        $waitingCount = Rent::where('order_status', 'waiting')->count();

        return view('dashboard-admin-rent', compact('rents', 'onRentCount', 'overdueCount', 'waitingCount', 'approvedCount'));
    }

    public function approve(Rent $rent)
    {
        // Update rent status to 'approved'
        $rent->order_status = 'approved';
        $rent->save();

        return redirect()->back()->with('success', 'Rent request approved successfully.');
    }

    public function reject(Rent $rent)
    {
        // Update rent status to 'rejected'
        $rent->order_status = 'rejected';
        $rent->save();

        return redirect()->back()->with('success', 'Rent request rejected successfully.');
    }

    public function getKtmImage($id)
    {
        $rent = Rent::findOrFail($id);
        return response($rent->ktm_image)->header('Content-Type', 'image/jpeg');
    }

    public function getBeforeDocumentation($id)
    {
        $rent = Rent::findOrFail($id);
        if ($rent->before_documentation) {
            return response($rent->before_documentation)->header('Content-Type', 'image/jpeg');
        }
        abort(404);
    }

    public function getAfterDocumentation($id)
    {
        $rent = Rent::findOrFail($id);
        if ($rent->after_documentation) {
            return response($rent->after_documentation)->header('Content-Type', 'image/jpeg');
        }
        abort(404);
    }
}

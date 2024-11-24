<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\RentStatusUpdater;

class AdminRentController extends Controller
{

    protected $rentStatusUpdater;

    public function __construct(RentStatusUpdater $rentStatusUpdater)
    {
        $this->rentStatusUpdater = $rentStatusUpdater;
    }
    public function index()
    {

        $this->rentStatusUpdater->updateStatuses();
        $rents = Rent::with('user', 'items.product')
            ->whereIn('order_status', ['approved', 'active', 'overdue', 'waiting'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);


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
        $startDate = Carbon::parse($rent->start_date);
        $currentDate = Carbon::now();
        if ($currentDate->gte($startDate)) {
            $rent->order_status = 'active';
        }
        if ($rent->user->role !== 'Regular') {
            $rent->payment_status = 'paid';
        }
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

    public function returned(Rent $rent)
    {
        // Update rent status to 'returned'
        $rent->order_status = 'returned';
        $rent->returned_date = Carbon::now();
        $rent->save();

        return redirect()->back()->with('success', 'Rent marked as returned successfully.');
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

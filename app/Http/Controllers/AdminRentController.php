<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use App\Notifications\RentApprovedNotification;
use App\Notifications\RentRejectedNotification;
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
    public function index(Request $request)
    {

        $this->rentStatusUpdater->updateStatuses();

        $search = $request->input('search');

        $query = Rent::with('user', 'items.product')
            ->whereIn('order_status', ['approved', 'active', 'overdue', 'waiting']);

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

        if (!$rent->user->hasType('Regular')) {
            $rent->payment_status = 'paid';
            if ($currentDate->gte($startDate)) {
                $rent->order_status = 'active';
            }
        }
        $rent->save();

        $rent->user->notify(new RentApprovedNotification($rent));

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Rent $rent)
    {
        // Update rent status to 'rejected'
        $rent->order_status = 'rejected';
        $rent->save();

        $rent->user->notify(new RentRejectedNotification($rent));

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function returned(Rent $rent)
    {
        // Update rent status to 'returned'
        $rent->order_status = 'returned';
        $rent->return_date = Carbon::now();
        $rent->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil dikembalikan.');
    }

    public function invalid(Rent $rent)
    {
        // Reset Documentation Pictures
        $rent->after_documentation = null;
        $rent->save();

        return redirect()->back()->with('success', 'Dokumentasi peminjaman berhasil direset.');
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

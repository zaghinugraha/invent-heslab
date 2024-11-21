<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\RentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Gloudemans\Shoppingcart\Facades\Cart;

class RentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nim_nip' => 'required|string|max:20',
            'phone' => 'required|string|max:15',
            'ktm_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192', // Validasi gambar
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Simpan file gambar KTM
            if ($request->hasFile('ktm_image')) {
                $ktmImagePath = $request->file('ktm_image')->store('ktm_images', 'public');
            }

            // Ambil item di keranjang
            $cartItems = Cart::instance('cart')->content();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Cart is empty. Please add items to the cart.');
            }

            // Buat pemesanan baru di tabel rent
            $rent = Rent::create([
                'user_id' => Auth::id(),
                'order_date' => now(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_cost' => Cart::instance('cart')->total(0, '', ''),
                'payment_method' => $request->payment_method,
                'payment_status' => 'unavailable',
                'order_status' => 'waiting',
                'notes' => $request->notes,
                'nim_nip' => $request->nim_nip,
                'phone' => $request->phone,
                'ktm_image' => $ktmImagePath ?? null,
            ]);

            // Simpan setiap item di keranjang ke tabel rent_items
            foreach ($cartItems as $item) {
                RentItem::create([
                    'rent_id' => $rent->id,
                    'item_id' => $item->id,
                    'quantity' => $item->qty,
                    'price_per_unit' => $item->price,
                    'subtotal' => $item->qty * $item->price,
                ]);
            }

            // Kosongkan keranjang setelah pemesanan disimpan
            Cart::instance('cart')->destroy();

            DB::commit();

            return redirect()->route('rent.show', $rent->id)->with('success', 'Rent order successfully created.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        // Tampilkan detail rent order
        $rent = Rent::with('items')->findOrFail($id);

        return view('rent.show', compact('rent'));
    }

    public function fetch()
    {
        // Update rents to 'overdue' where 'end_date' is past and status is 'active'
        Rent::where('user_id', Auth::id())
            ->where('order_status', 'active')
            ->whereDate('end_date', '<', now()->toDateString())
            ->update(['order_status' => 'overdue']);

        // Fetch rent orders for the authenticated user
        $rents = Rent::with('items.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate counts for status cards
        $approvedCount = $rents->where('order_status', 'approved')->count();
        $onRentCount = $rents->where('order_status', 'active')->count();
        $overdueCount = $rents->where('order_status', 'overdue')->count();
        $waitingCount = $rents->where('order_status', 'waiting')->count();

        return view('dashboard-reg-rent', compact('rents', 'onRentCount', 'overdueCount', 'waitingCount', 'approvedCount'));
    }

    public function submitDocumentation(Request $request)
    {
        try {
            $request->validate([
                'rent_id' => 'required|exists:rent,id',
                'documentation' => 'required|image|mimes:jpg,jpeg,png|max:8192', // Max 2MB
                'documentation_type' => 'required|in:before,after',
            ]);

            $rent = Rent::findOrFail($request->rent_id);

            // Ensure the authenticated user owns the rent
            if ($rent->user_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            $today = now()->toDateString();
            $startDate = $rent->start_date;
            $endDate = $rent->end_date;

            // Handle 'before' documentation
            if ($request->documentation_type == 'before' && !$rent->before_documentation) {
                // Before documentation deadline: start_date to start_date + 1 day
                if ($today >= $startDate && $today <= $endDate) {
                    // Store Before Documentation
                    $docContent = file_get_contents($request->file('documentation')->getRealPath());
                    $rent->before_documentation = $docContent;
                    $rent->save();

                    return redirect()->back()->with('success', 'Before documentation submitted successfully.');
                } else {
                    return redirect()->back()->with('error', 'Cannot submit before documentation at this time.');
                }
            }
            // Handle 'after' documentation
            elseif ($request->documentation_type == 'after' && !$rent->after_documentation) {
                // After documentation deadline: end_date only
                if ($today >= $startDate && $today <= $endDate) {
                    // Store After Documentation
                    $docContent = file_get_contents($request->file('documentation')->getRealPath());
                    $rent->after_documentation = $docContent;
                    $rent->save();

                    return redirect()->back()->with('success', 'After documentation submitted successfully.');
                } else {
                    return redirect()->back()->with('error', 'Cannot submit after documentation at this time.');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid documentation submission.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancel(Rent $rent)
    {
        // Ensure the authenticated user owns the rent
        if ($rent->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Update the rent status to 'cancelled'
        $rent->order_status = 'cancelled';
        $rent->save();

        return redirect()->back()->with('success', 'Rent cancelled successfully.');
    }
}

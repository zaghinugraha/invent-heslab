@extends('layouts.dashboard-reg')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title', 'Rent Status')

@section('heading', 'Rent Status')
@section('headingDesc', 'Rent Status')
@section('description',
    '
    This is a list of items that you have rented. Use the search column to find a specific record, or navigate the page to
    view more history.
    ')
@section('warnings')
    @if ($overdueCount > 0)
        <div class="bg-red-100 border border-red-400 text-red-500 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">
                You have {{ $overdueCount }} overdue rent(s). Please return the item(s)
                immediately.</span>
            </span>
        </div>
    @endif

    @if ($approvedAndUnpaidCount > 0)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">
                You have {{ $unpaidCount }} unpaid rent(s). Please pay the rent(s)
                immediately.</span>
            </span>
        </div>
    @endif

@endsection
@section('sidebar')
    <aside id="sidebar" class="transition-width w-64 h-max fixed top-16 bottom-16 lg:relative p-2">
        <div class="bg-white rounded p-2">
            <nav class="space-y-2 bg-white rounded p-2">
                <a href="{{ route('dashboard-reg-items') }}"
                    class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line x1="5" y1="7" x2="19" y2="7" stroke="#000000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <line x1="5" y1="12" x2="19" y2="12" stroke="#000000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <line x1="5" y1="17" x2="19" y2="17" stroke="#000000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar-text">Item List</span>
                </a>
                <a href="{{ route('dashboard-reg-rent') }}"
                    class="flex items-center space-x-2 text-white bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M18 2H6C5.44772 2 5 2.44772 5 3V22L7.5 20L9.5 22L12 20L14.5 22L16.5 20L19 22V3C19 2.44772 18.5523 2 18 2Z"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9 6H15" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M9 10H15" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M9 14H10" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar-text">Rent Status</span>
                </a>
                <a href="{{ route('dashboard-reg-history') }}"
                    class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#000000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 6V12L16 16" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar-text ml-3">History</span>
                </a>
            </nav>
        </div>
    </aside>
@endsection

@section('modals')
    <div x-show="documentationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('documentationModal', value => document.body.classList.toggle('overflow-hidden', value))">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 mb-8 max-h-full overflow-y-auto">
            <h2 class="text-xl font-semibold mb-4"
                x-text="documentationType === 'before' ? 'Submit Before Documentation' : 'Submit After Documentation'"></h2>
            <form id="documentationForm" action="{{ route('rent.documentation') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="rent_id" :value="rentId">
                <input type="hidden" name="documentation_type" :value="documentationType">
                <div class="mb-4">
                    <label for="documentation" class="block text-sm font-medium text-gray-700">Upload Documentation
                        Picture</label>
                    <input type="file" name="documentation" id="documentation" accept="image/*" required
                        class="mt-1 block w-full border-gray-300 rounded-md">
                    @error('documentation')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="documentationModal = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="flex flex-col items-center">

        <!-- Table -->
        <div class="overflow-x-auto w-full">
            <table class="min-w-full table-auto border">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Item(s)</th>
                        <th class="px-4 py-2 border">Total Price</th>
                        <th class="px-4 py-2 border">Rent Date</th>
                        <th class="px-4 py-2 border">Return Date</th>
                        @if (auth()->user()->hasType('Regular'))
                            <th class="px-4 py-2 border">Payment</th>
                        @endif
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Documentation Status</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($rents as $index => $rent)
                        <tr class="hover:bg-gray-50 text-center text-sm">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border text-left">
                                <ul>
                                    @foreach ($rent->items as $rentItem)
                                        <li>{{ $rentItem->product->name }} x{{ $rentItem->quantity }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-2 border">Rp {{ number_format($rent->total_cost, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border">{{ $rent->start_date }}</td>
                            <td class="px-4 py-2 border">{{ $rent->end_date }}</td>
                            @if (auth()->user()->hasType('Regular'))
                                <td class="px-4 py-2 border text-center">
                                    @if ($rent->payment_status == 'paid')
                                        <!-- Button Greyed Out - Already Paid -->
                                        <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed"
                                            title="Already paid" disabled>
                                            Pay Now
                                        </button>
                                    @else
                                        @if ($rent->order_status == 'waiting')
                                            <!-- Button Greyed Out - Not Approved Yet -->
                                            <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed"
                                                title="Not approved yet" disabled>
                                                Pay Now
                                            </button>
                                        @elseif ($rent->order_status == 'approved')
                                            <!-- Active Button - Redirects to Payment Gateway -->
                                            <a href="#"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                                Pay Now
                                            </a>
                                        @else
                                            <!-- Default State -->
                                            <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed"
                                                disabled>
                                                Pay Now
                                            </button>
                                        @endif
                                    @endif
                                </td>
                            @endif
                            <td class="px-4 py-2 border">
                                <span
                                    class="inline-block px-2 py-1 text-white rounded
                                @if ($rent->order_status == 'active') bg-blue-500
                                @elseif($rent->order_status == 'waiting')
                                bg-yellow-500
                                @elseif($rent->order_status == 'overdue')
                                bg-red-500
                                @elseif($rent->order_status == 'approved')
                                bg-green-500 @endif
                            ">{{ ucfirst($rent->order_status) }}</span>
                            </td>
                            <td class="px-4 py-2 border text-left text-sm">
                                @if ($rent->before_documentation)
                                    <p>
                                        <span>Before: </span>
                                        <span class="text-green-600 font-bold">Submitted</span>
                                    </p>
                                @else
                                    <p>
                                        <span>Before: </span>
                                        <span class="text-red-600 font-bold">Not Submitted</span>
                                    </p>
                                @endif

                                @if ($rent->after_documentation)
                                    <p>
                                        <span>After: </span>
                                        <span class="text-green-600 font-bold">Submitted</span>
                                    </p>
                                @else
                                    <p>
                                        <span>After: </span>
                                        <span class="text-red-600 font-bold">Not Submitted</span>
                                    </p>
                                @endif
                            </td>
                            <td class="px-4 py-2 border text-center text-sm">
                                <!-- Actions Buttons -->
                                @php
                                    $today = \Carbon\Carbon::now()->toDateString();
                                    $startDate = $rent->start_date;
                                    $endDate = $rent->end_date;
                                @endphp

                                @if ($rent->payment_status == 'paid')
                                    <!-- Submit Before Documentation Button -->
                                    @if (!$rent->before_documentation && $today >= $startDate && $today <= $endDate)
                                        <button class="bg-green-500 hover:bg-green-600 text-white px-2 py-2 rounded"
                                            @click="documentationModal = true; rentId = {{ $rent->id }}; documentationType = 'before';">
                                            Before-rent Documentation
                                        </button>
                                    @elseif ($rent->before_documentation && !$rent->after_documentation && $today >= $startDate && $today <= $endDate)
                                        <button class="bg-green-500 hover:bg-green-600 text-white px-2 py-2 rounded"
                                            @click="documentationModal = true; rentId = {{ $rent->id }}; documentationType = 'after';">
                                            After-rent Documentation
                                        </button>
                                    @elseif ($rent->before_documentation && $rent->after_documentation)
                                        <span class="text-green-600 font-semibold">All Documentation
                                            Submitted</span>
                                    @else
                                        <span class="text-gray-600 font-semibold">Unavailable</span>
                                    @endif
                                @else
                                    <!-- Cancel Button -->
                                    @if ($rent->payment_status !== 'paid' && $today < $startDate)
                                        <form action="{{ route('rent.cancel', $rent) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded"
                                                onclick="return confirm('Are you sure you want to cancel this rent?');">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No rent data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $rents->links() }}
        </div>
    </div>
@endsection

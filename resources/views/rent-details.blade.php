@extends('layouts.dashboard-admin')

@section('title', 'Rent Details')

@section('heading', 'Rent Details')
@section('sidebar')
    <aside id="sidebar" class="transition-width w-64 h-max fixed top-16 bottom-16 lg:relative p-2">
        <div class="bg-white rounded p-2">
            <nav class="space-y-2 bg-white rounded p-2">
                <a href="{{ route('dashboard-admin-items') }}"
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
                <a href="{{ route('dashboard-admin-rent') }}"
                    class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                <a href="{{ route('dashboard-admin-history') }}"
                    class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#000000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 6V12L16 16" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar-text ml-3">History</span>
                </a>
                <a href="{{ route('users.index') }}"
                    class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="7" r="4" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M4 21V17C4 15.8954 4.89543 15 6 15H18C19.1046 15 20 15.8954 20 17V21" stroke="#000000"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar-text ml-3">Manage Users</span>
                </a>
            </nav>
        </div>
    </aside>
@endsection

@section('breadcrumb')
    <ol class="flex text-sm text-gray-500">
        <li><a href="{{ route('dashboard-admin-rent') }}" class="hover:underline">Rent Requests</a></li>
        <li class="mx-2">/</li>
        <li class="font-bold">
            {{ $rent->id }}
        </li>
    </ol>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg my-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            {{ $rent->user->name }}'s Rent Details
        </h2>
        <!-- Rent Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-4">
                <!-- Display rent details -->
                <div class="flex items-center">
                    <span class="w-1/3 font-semibold">ID:</span>
                    <span class="w-2/3">{{ $rent->user_id }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 font-semibold">NIM/NIP:</span>
                    <span class="w-2/3">{{ $rent->nim_nip }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 font-semibold">Phone:</span>
                    <span class="w-2/3">{{ $rent->phone }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 font-semibold">Order Date:</span>
                    <span class="w-2/3">{{ $rent->order_date }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 font-semibold">Start Date:</span>
                    <span class="w-2/3">{{ $rent->start_date }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 font-semibold">End Date:</span>
                    <span class="w-2/3">{{ $rent->end_date }}</span>
                </div>
                @if ($rent->returned_date)
                    <div class="flex items-center">
                        <span class="w-1/3 font-semibold">Returned Date:</span>
                        <span class="w-2/3">{{ $rent->returned_date }}</span>
                    </div>
                @endif
                <div class="flex items-center">
                    <span class="w-1/3 font-semibold">Total Days:</span>
                    <span class="w-2/3">
                        @php
                            $start = new DateTime($rent->start_date);
                            $end = new DateTime($rent->end_date);
                            $interval = $start->diff($end);
                            echo $interval->days;
                        @endphp
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 font-semibold">Total Cost:</span>
                    <span class="w-2/3">
                        @if (!$rent->user->hasType('Regular'))
                            Free
                        @else
                            Rp {{ number_format($rent->total_cost, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                @if ($rent->user->hasType('Regular'))
                    <div class="flex items-center">
                        <span class="w-1/3 font-semibold">Payment Status:</span>
                        <span class="w-2/3">
                            @if ($rent->payment_status == 'paid')
                                <span class="bg-green-500 text-white px-2 py-1 rounded-lg">Paid</span>
                            @else
                                <span class="bg-red-500 text-white px-2 py-1 rounded-lg">Unpaid</span>
                            @endif
                        </span>
                    </div>
                @endif
                <div class="flex items-center">
                    <span class="w-1/3 font-semibold">Rent Status:</span>
                    <span class="w-2/3">
                        <span
                            class="inline-block px-2 py-1 text-white rounded-lg
                            @if ($rent->order_status == 'cancelled') bg-gray-500
                            @elseif($rent->order_status == 'rejected') bg-red-500
                            @elseif($rent->order_status == 'returned') bg-blue-500
                            @elseif($rent->order_status == 'approved') bg-green-500
                            @elseif($rent->order_status == 'active') bg-blue-500
                            @elseif($rent->order_status == 'overdue') bg-red-500
                            @elseif($rent->order_status == 'waiting') bg-yellow-500 @endif">
                            {{ $rent->order_status }}
                        </span>
                    </span>
                </div>
            </div>
            <div>
                <p class="font-bold mb-2">Items:</p>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach ($rent->items as $item)
                        <li>{{ $item->product->name }} x{{ $item->quantity }}</li>
                    @endforeach
                </ul>
                <div class="mt-4">
                    <p class="font-bold">Notes:</p>
                    <p class="text-gray-700">{{ $rent->notes }}</p>
                </div>
            </div>
        </div>

        <!-- Images -->
        <div
            class="grid grid-cols-1 md:grid-cols-{{ $rent->before_documentation && $rent->after_documentation ? '3' : '2' }} gap-6 mt-8">
            <div class="text-center">
                <p class="font-semibold mb-2">KTM Image:</p>
                <img src="{{ url('/admin/rent/' . $rent->id . '/ktm-image') }}" alt="KTM Image"
                    class="w-full h-auto rounded-lg shadow">
            </div>
            @if ($rent->before_documentation)
                <div class="text-center">
                    <p class="font-semibold mb-2">Before-rent Documentation:</p>
                    <img src="{{ url('/admin/rent/' . $rent->id . '/before-documentation') }}" alt="Before Documentation"
                        class="w-full h-auto rounded-lg shadow">
                </div>
            @endif
            @if ($rent->after_documentation)
                <div class="text-center">
                    <p class="font-semibold mb-2">After-rent Documentation:</p>
                    <img src="{{ url('/admin/rent/' . $rent->id . '/after-documentation') }}" alt="After Documentation"
                        class="w-full h-auto rounded-lg shadow">
                </div>
            @endif
        </div>

        @if ($rent->order_status == 'waiting')
            <!-- Approve and Reject Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <form action="{{ route('rent.approve', $rent) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
                        Approve
                    </button>
                </form>
                <form action="{{ route('rent.reject', $rent) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
                        Reject
                    </button>
                </form>
            </div>
        @elseif (
            ($rent->order_status == 'active' || $rent->order_status == 'overdue') &&
                $rent->before_documentation_url &&
                $rent->after_documentation_url)
            <!-- Return Button -->
            <div class="flex justify-end space-x-4 mt-8">
                <form action="{{ route('rent.return', $rent) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
                        User ini telah mengembalikan barang
                    </button>
                </form>
                <!-- Reset Documentation Picture because they're not valid -->
                <form action="{{ route('rent.invalid', $rent) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
                        Dokumentasi tidak valid
                    </button>
            </div>
        @endif
    </div>
@endsection

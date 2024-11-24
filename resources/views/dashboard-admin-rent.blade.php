@extends('layouts.dashboard-admin')

@section('title', 'Rent Request')

@section('heading', 'Rent Request')
@section('headingDesc', 'Rent Request')
@section('description', 'ACC PEMINJAMAN BWANG!')

@section('sidebar')
    <aside id="sidebar" class="transition-width w-64 h-full fixed top-16 bottom-16 lg:relative lg:h-screen p-2">
        <div class="bg-white rounded p-2">
            <nav class="space-y-2 bg-white rounded p-2">
                <a href="{{ route('dashboard-admin-items') }}"
                    class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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
                    <span class="sidebar-text">Rent Request</span>
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

@section('content')
    <div class="flex flex-col items-center">
        <!-- Status Cards -->
        <div class="space-y-4 mb-4 w-full mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 w-full mx-auto">
                <!-- Approved Card -->
                <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-green-500 text-white font-semibold py-2">Approved</div>
                    <div class="bg-white py-4 text-2xl font-bold text-black">{{ $approvedCount }}</div>
                </div>

                <!-- On loan Card -->
                <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-blue-500 text-white font-semibold py-2">On Rent</div>
                    <div class="bg-white py-4 text-2xl font-bold text-black">{{ $onRentCount }}</div>
                </div>

                <!-- Overdue Card -->
                <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-red-500 text-white font-semibold py-2">Overdue</div>
                    <div class="bg-white py-4 text-2xl font-bold text-black">{{ $overdueCount }}</div>
                </div>

                <!-- Waiting Card -->
                <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-yellow-500 text-white font-semibold py-2">Waiting</div>
                    <div class="bg-white py-4 text-2xl font-bold text-black">{{ $waitingCount }}</div>
                </div>
            </div>
            <div class="w-full flex justify-end">
                <form action="{{ route('dashboard-admin-rent') }}" method="GET" class="flex w-1/2">
                    <input type="text" name="search" placeholder="Search"
                        class="w-full px-4 py-2 border rounded-l-lg focus:outline-none"
                        value="{{ request()->query('search') }}" />
                    <button type="submit" class="bg-gray-300 px-4 rounded-r-lg">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M21.707 20.293l-6.388-6.388A7.455 7.455 0 0018 10.5a7.5 7.5 0 10-7.5 7.5c1.8 0 3.464-.63 4.904-1.681l6.388 6.388a1 1 0 001.415-1.414zM10.5 16a5.5 5.5 0 110-11 5.5 5.5 0 010 11z">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto w-full">
            <table class="min-w-full table-auto border">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">NIM/NIP</th>
                        <th class="px-4 py-2 border">Item</th>
                        <th class="px-4 py-2 border">Price</th>
                        <th class="px-4 py-2 border">Details</th>
                        <th class="px-4 py-2 border">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($rents as $index => $rent)
                        <tr class="hover:bg-gray-50 text-center">
                            <td class="px-4 py-2 border">{{ $rent->id }}</td>
                            <td class="px-4 py-2 border">{{ $rent->user->name }}</td>
                            <td class="px-4 py-2 border">{{ $rent->nim_nip }}</td>
                            <td class="px-4 py-2 border text-left">
                                <ul>
                                    @foreach ($rent->items as $item)
                                        <li>{{ $item->product->name }} x{{ $item->quantity }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-2 border">Rp {{ number_format($rent->total_cost, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('rent.details', $rent->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                        Details
                                    </a>
                                </div>
                            </td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">No rent requests available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $rents->links() }}
        </div>
    </div>
@endsection

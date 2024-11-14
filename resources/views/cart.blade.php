@extends('layouts.dashboard-reg')

@section('title', 'Rent Form')

@section('heading', 'Rent Form')
@section('sidebar')
    <aside id="sidebar" class="transition-width w-64 h-full fixed top-16 bottom-16 lg:relative lg:h-screen p-2">
        <div class="bg-white rounded p-2">
            <nav class="space-y-2 bg-white rounded p-2">
                <a href="{{ route('dashboard-reg-items') }}"
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
                <a href="{{ route('dashboard-reg-rent') }}"
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

@section('breadcrumb')
    <ol class="flex text-sm text-gray-500">
        <li><a href="{{ route('dashboard-reg-items') }}" class="hover:underline">Item List</a></li>
        <li class="mx-2">/</li>
        <li class="font-bold">Cart</li>
    </ol>
@endsection

@section('content')
    <div class="container mx-auto px-4">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Cart Items -->
        <div class="flex gap-8 p-8">
            <!-- Form Section -->
            <div class="w-1/2">
                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">NIM/NIP</label>
                        <input type="text" name="nim_nip" value="{{ old('nim_nip') }}" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">No. Wa Aktif</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Foto KTM</label>
                        <input type="file" name="ktm_image" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500" />
                    </div>
                    <div class="flex gap-4 mb-6">
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-medium mb-2">Rent Date</label>
                            <input type="date" name="rent_date" value="{{ old('rent_date') }}" required
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-medium mb-2">Return Date</label>
                            <input type="date" name="return_date" value="{{ old('return_date') }}" required
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <p class="text-red-500 text-sm italic">* Pastikan Data Sudah Benar</p>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="mt-6 w-full bg-blue-600 text-white font-semibold py-3 rounded hover:bg-blue-700 focus:outline-none">
                        Rent Now
                    </button>
                </form>
            </div>

            <!-- Cart Section -->
            <div class="w-1/2">
                @if ($cartItems->isNotEmpty())
                    <div class="border border-blue-300 bg-blue-50 rounded p-4">
                        @foreach ($cartItems as $item)
                            <div class="flex items-center gap-4 mb-4">
                                <img src="data:image/jpeg;base64,{{ base64_encode($item->options->product_image) }}"
                                    alt="{{ $item->name }}" class="w-16 h-16 rounded-lg object-cover">
                                <div class="flex-grow">
                                    <h3 class="text-xl font-semibold text-blue-700">{{ $item->name }}</h3>
                                    <p class="text-sm text-gray-600">Quantity: {{ $item->qty }}</p>
                                    <p class="text-lg text-blue-700 font-medium">Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <!-- Remove Item Form -->
                                <form action="{{ route('cart.remove', $item->rowId) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach

                        <!-- Cart Summary -->
                        <div class="mt-6 border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center font-semibold text-lg">
                                <span>Total</span>
                                <span class="text-blue-700">Rp {{ Cart::instance('cart')->subtotal(0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Clear Cart Button -->
                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="w-full bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center justify-center h-full">
                        <div>
                            <h3 class="text-xl font-semibold text-blue-700">Your cart is empty.</h3>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

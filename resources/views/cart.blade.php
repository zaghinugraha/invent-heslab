@extends('layouts.dashboard-reg')

@section('title', 'Keranjang Peminjaman')

@section('heading', 'Keranjang Peminjaman')
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
                    <span class="sidebar-text">Daftar Barang</span>
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
                    <span class="sidebar-text">Status Peminjaman</span>
                </a>
                <a href="{{ route('dashboard-reg-history') }}"
                    class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#000000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 6V12L16 16" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar-text ml-3">Riwayat</span>
                </a>
            </nav>
        </div>
    </aside>
@endsection

@section('breadcrumb')
    <ol class="flex text-sm text-gray-500">
        <li><a href="{{ route('dashboard-reg-items') }}" class="hover:underline">Daftar Barang</a></li>
        <li class="mx-2">/</li>
        <li class="font-bold">Keranjang Peminjaman</li>
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
        <div class="flex flex-col lg:flex-row gap-8 p-8">
            <!-- Cart Section -->
            <div class="w-full lg:w-1/2 order-1 lg:order-2">
                @if ($cartItems->isNotEmpty())
                    <div class="border-2 border-blue-300 bg-blue-50 rounded p-4 shadow-lg">
                        @foreach ($cartItems as $item)
                            <div class="cart-item flex flex-row items-start gap-4 mb-4" data-row-id="{{ $item->rowId }}"
                                data-price-per-week="{{ auth()->user()->hasType('Regular') ? $item->price : 0 }}"
                                data-quantity="{{ $item->qty }}">

                                <!-- Product Image -->
                                <img src="data:image/jpeg;base64,{{ base64_encode($item->options->product_image) }}"
                                    alt="{{ $item->name }}" class="w-20 h-20 rounded-lg object-cover shadow-md">

                                <!-- Product Details -->
                                <div class="flex-grow">
                                    <h3 class="text-xl font-bold text-blue-700">{{ $item->name }}</h3>
                                    <div class="flex items-center mt-2 w-full">
                                        <!-- Quantity Update Form -->
                                        <form action="{{ route('cart.update', $item->rowId) }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            @method('PUT')
                                            <div class="flex items-center border border-blue-500 rounded overflow-hidden">
                                                <button type="button" onclick="decreaseQuantity('{{ $item->rowId }}')"
                                                    class="px-2 py-1 text-gray-600 hover:bg-gray-200 focus:outline-none">
                                                    &minus;
                                                </button>
                                                <input type="text" name="quantity" id="quantity-{{ $item->rowId }}"
                                                    value="{{ $item->qty }}"
                                                    class="w-12 text-center focus:outline-none bg-transparent"
                                                    oninput="validateQuantity(this, {{ $item->options->max_quantity }})">
                                                <button type="button"
                                                    onclick="increaseQuantity('{{ $item->rowId }}', {{ $item->options->max_quantity }})"
                                                    class="px-2 py-1 text-gray-600 hover:bg-gray-200 focus:outline-none">
                                                    &#43;
                                                </button>
                                            </div>
                                            <div class="flex-grow"></div>
                                            <div class="flex items-center ml-2 mt-2 sm:mt-0">
                                                <button type="submit" class="text-blue-600 hover:text-blue-800">
                                                    <!-- Update Icon -->
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                        <form action="{{ route('cart.remove', $item->rowId) }}" method="POST"
                                            class="inline ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <!-- Remove Icon -->
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <!-- Price -->
                                    <p class="text-sm text-gray-400 font-semibold">
                                        @if (!auth()->user()->hasType('Regular'))
                                            Gratis
                                        @else
                                            Rp {{ number_format($item->price, 0, ',', '.') }} / Minggu
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <hr class="mb-4">
                        @endforeach

                        <!-- Cart Summary -->
                        <div class="mt-6 pt-4">
                            <div class="flex justify-between items-center font-semibold text-lg">
                                <span>Total :</span>
                                <span class="text-blue-700" id="total-price">
                                    @if (!auth()->user()->hasType('Regular'))
                                        Gratis
                                    @else
                                        Rp {{ Cart::instance('cart')->subtotal(0, ',', '.') }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Clear Cart Button -->
                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="w-full bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600">
                                Bersihkan Keranjang
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-2 border-blue-300 bg-blue-50 rounded p-4 shadow-lg">
                        <div class="flex items-center justify-center h-1/2">
                            <div>
                                <h3 class="text-xl font-semibold text-blue-700">Keranjang mu kosong.</h3>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Form Section -->
            <div class="w-full lg:w-1/2 order-2 lg:order-1">
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

                <form action="{{ route('rent.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h1 class="block text-gray-700 text-xl gradient-text font-bold mb-2">Isi formulir di bawah</h1>
                    <hr class="mb-4">
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">NIM/NIP</label>
                        <input type="text" name="nim_nip" value="{{ old('nim_nip') }}" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Nomor WhatsApp Aktif</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Upload Foto KTM</label>
                        <input type="file" name="ktm_image"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
                            required />
                    </div>
                    <div class="flex gap-4 mb-6">
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Mulai Pinjam</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                required min="{{ \Carbon\Carbon::now()->addDays(2)->format('Y-m-d') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Pengembalian</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                min="{{ date('Y-m-d', strtotime('+1 week')) }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">
                            Metode Pembayaran
                        </label>
                        <select name="payment_method" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                            @if (auth()->user()->hasType('Regular'))
                                <option value="credit_card">Kartu Kredit</option>
                                <option value="bank_transfer">Transfer Bank</option>
                                <option value="e_wallet">E-Wallet</option>
                            @else
                                <option value="free">Gratis</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Catatan</label>
                        <textarea name="notes"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="mt-6 w-full bg-blue-600 text-white font-semibold py-3 rounded hover:bg-blue-700 focus:outline-none">
                        Pinjam Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isRegularUser = {{ auth()->user()->hasType('Regular') ? 'true' : 'false' }};
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        startDateInput.addEventListener('change', onStartDateChange);
        endDateInput.addEventListener('change', updatePrice);

        function onStartDateChange() {
            const startDateValue = startDateInput.value;
            if (startDateValue) {
                const startDate = new Date(startDateValue);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (startDate < today) {
                    alert("Rent date cannot be earlier than today.");
                    startDateInput.value = today.toISOString().split('T')[0];
                    return;
                }

                // Set minimum end date (start date + 7 days)
                const minEndDate = getMinEndDate(startDate);
                endDateInput.value = '';
                endDateInput.setAttribute('min', minEndDate.toISOString().split('T')[0]);
            }
            updatePrice();
        }

        function updatePrice() {
            const startDateValue = startDateInput.value;
            const endDateValue = endDateInput.value;

            if (startDateValue && endDateValue) {
                const startDate = new Date(startDateValue);
                const endDate = new Date(endDateValue);

                const timeDiff = endDate - startDate;
                const days = timeDiff / (1000 * 3600 * 24);

                if (days < 7) {
                    alert("Minimum rental period is 1 week.");
                    const minEndDate = getMinEndDate(startDate);
                    endDateInput.value = minEndDate.toISOString().split('T')[0];
                    return;
                }

                const weeks = Math.ceil(days / 7);
                let totalPrice = 0;

                if (isRegularUser) {
                    const cartItems = document.querySelectorAll('.cart-item');
                    cartItems.forEach(function(cartItem) {
                        const pricePerWeek = parseFloat(cartItem.dataset.pricePerWeek);
                        const quantity = parseInt(cartItem.dataset.quantity);
                        const itemTotal = pricePerWeek * weeks * quantity;
                        totalPrice += itemTotal;
                    });
                    document.getElementById('total-price').textContent = 'Rp ' + formatNumber(totalPrice);
                }

            }
        }

        function getMinEndDate(startDate) {
            const minEndDate = new Date(startDate);
            minEndDate.setDate(minEndDate.getDate() + 7);
            return minEndDate;
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Initialize min attributes on page load
        (function initializeDates() {
            const today = new Date();
            today.setDate(today.getDate() + 2); // Set to tomorrow
            today.setHours(0, 0, 0, 0);
            startDateInput.setAttribute('min', today.toISOString().split('T')[0]);

            const startDateValue = startDateInput.value || today.toISOString().split('T')[0];
            const startDate = new Date(startDateValue);
            const minEndDate = getMinEndDate(startDate);
            endDateInput.setAttribute('min', minEndDate.toISOString().split('T')[0]);
        })();

        // Initialize price on page load
        updatePrice();
    });

    function decreaseQuantity(rowId) {
        var input = document.getElementById('quantity-' + rowId);
        var value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        }
    }

    function increaseQuantity(rowId, maxQuantity) {
        var input = document.getElementById('quantity-' + rowId);
        var value = parseInt(input.value);
        if (value < maxQuantity) {
            input.value = value + 1;
        }
    }

    function validateQuantity(input, maxQuantity) {
        var value = parseInt(input.value);
        if (isNaN(value) || value < 1) {
            input.value = 1;
        } else if (value > maxQuantity) {
            input.value = maxQuantity;
        }
    }
</script>

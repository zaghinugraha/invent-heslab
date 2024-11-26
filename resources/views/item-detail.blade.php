@extends('layouts.dashboard-reg')

@section('title', $product['name'])

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('heading', $product['name'])
@section('sidebar')
    <aside id="sidebar" class="transition-width w-64 h-full fixed top-16 bottom-16 lg:relative lg:h-screen p-2">
        <div class="bg-white rounded p-2">
            <nav class="space-y-2 bg-white rounded p-2">
                <a href="{{ route('dashboard-reg-items') }}"
                    class="flex items-center space-x-2 text-white bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded">
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
        <li class="font-bold">{{ $product['name'] }}</li>
    </ol>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto p-6 flex flex-col lg:flex-row gap-6">
        <div class="w-full lg:w-1/3">
            <div class="border border-gray-300 rounded-lg overflow-hidden mb-4">
                <img src="{{ route('product.image', $product->uuid) }}" alt="{{ $product->name }}"
                    class="w-full h-32 object-cover rounded-md mb-4">
            </div>
            <!-- Thumbnail Images -->
            <div class="flex gap-2 overflow-x-auto">
                <img src="{{ route('product.image', $product->uuid) }}" alt="Thumbnail"
                    class="w-14 h-14 border border-gray-300 rounded-lg flex-shrink-0">
                <img src="{{ route('product.image', $product->uuid) }}" alt="Thumbnail"
                    class="w-14 h-14 border border-gray-300 rounded-lg flex-shrink-0">
                <img src="{{ route('product.image', $product->uuid) }}" alt="Thumbnail"
                    class="w-14 h-14 border border-gray-300 rounded-lg flex-shrink-0">
                <img src="{{ route('product.image', $product->uuid) }}" alt="Thumbnail"
                    class="w-14 h-14 border border-gray-300 rounded-lg flex-shrink-0">
            </div>
        </div>
        <div class="w-full lg:w-2/3">
            <!-- Product Title and Stock -->
            <div class="flex flex-col sm:flex-row justify-between items-start">
                <h1 class="text-2xl font-bold text-gray-800">{{ $product['name'] }}</h1>
                <span class="text-sm text-gray-500 mt-2 sm:mt-0">Stock: <span
                        class="font-semibold text-gray-800">{{ $product->quantity }}</span></span>
            </div>

            <!-- Price -->
            <p class="text-xl text-gray-700 font-semibold mt-2">
                @if (!auth()->user()->hasType('Regular'))
                    Free
                @else
                    Rp{{ number_format($product['price'], 0, ',', '.') }},-
                @endif
            </p>

            <!-- Quantity Selector and Buttons -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 mt-4">
                <!-- Quantity Selector -->
                <div class="flex items-center border border-gray-300 rounded">
                    <button class="px-3 py-1 text-gray-700" onclick="updateQuantity('decrease')">-</button>
                    <input type="text" id="quantity-input" value="1" min="1"
                        max="{{ $product->quantity }}" class="w-12 text-center border-0 focus:outline-none"
                        onchange="validateQuantity(this)">
                    <button class="px-3 py-1 text-gray-700" onclick="updateQuantity('increase')">+</button>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2 mt-2 sm:mt-0">
                    @if ($product->quantity > 0)
                        <button onclick="addToCart({{ $product->id }})"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add to Cart
                        </button>
                        <button class="border border-blue-600 text-blue-600 px-4 py-2 rounded hover:bg-blue-50">
                            Rent Now
                        </button>
                    @else
                        <button class="bg-gray-300 text-gray-600 px-4 py-2 rounded cursor-not-allowed" disabled
                            title="Out of Stock">
                            Add to Cart
                        </button>
                        <button class="border border-gray-300 text-gray-600 px-4 py-2 rounded cursor-not-allowed" disabled
                            title="Out of Stock">
                            Rent Now
                        </button>
                    @endif
                </div>
            </div>

            <!-- Tabs (Specification and Maintenance) -->
            <div class="flex gap-4 mt-6 border-b border-gray-200">
                <button onclick="showTab('specification')" id="specification-tab"
                    class="text-blue-600 font-semibold pb-2 border-b-2 border-blue-600">
                    Specification
                </button>
                <button onclick="showTab('maintenance')" id="maintenance-tab"
                    class="text-gray-500 hover:text-gray-700 pb-2">
                    Maintenance
                </button>
            </div>

            <!-- Specification Content -->
            <div id="specification-content"
                class="transition-all duration-300 ease-in-out opacity-100 max-h-64 overflow-auto">
                <p class="text-gray-600 mt-4">
                    {{ $product['notes'] }}
                </p>

                <ul class="text-gray-600 mt-2 list-disc list-inside space-y-1">
                    {!! $product['specification'] !!}
                </ul>
            </div>

            <!-- Maintenance Content -->
            <div id="maintenance-content" class="transition-all duration-300 ease-in-out opacity-0 max-h-0 overflow-auto">
                @foreach ($product->maintenance->sortByDesc('created_at') as $maintenance)
                    <div class="border-t py-2">
                        <p class="text-gray-700">
                            {{ $maintenance->created_at->format('Y-m-d') }} - {!! nl2br(e($maintenance->notes)) !!}
                        </p>
                        @if ($maintenance->documentation)
                            <img src="data:image/jpeg;base64,{{ base64_encode($maintenance->documentation) }}"
                                alt="Maintenance Picture" class="mt-2 w-32 h-32 object-cover">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function showTab(tab) {
            const specificationContent = document.getElementById('specification-content');
            const maintenanceContent = document.getElementById('maintenance-content');

            const specificationTab = document.getElementById('specification-tab');
            const maintenanceTab = document.getElementById('maintenance-tab');

            if (tab === 'specification') {
                // Show Specification Content
                specificationContent.classList.remove('opacity-0', 'max-h-0');
                specificationContent.classList.add('opacity-100', 'max-h-64');

                // Hide Maintenance Content
                maintenanceContent.classList.remove('opacity-100', 'max-h-64');
                maintenanceContent.classList.add('opacity-0', 'max-h-0');

                // Update Tab Styles
                specificationTab.classList.add('text-blue-600', 'font-semibold', 'border-b-2', 'border-blue-600');
                specificationTab.classList.remove('text-gray-500');

                maintenanceTab.classList.remove('text-blue-600', 'font-semibold', 'border-b-2', 'border-blue-600');
                maintenanceTab.classList.add('text-gray-500');
            } else if (tab === 'maintenance') {
                // Show Maintenance Content
                maintenanceContent.classList.remove('opacity-0', 'max-h-0');
                maintenanceContent.classList.add('opacity-100', 'max-h-64');

                // Hide Specification Content
                specificationContent.classList.remove('opacity-100', 'max-h-64');
                specificationContent.classList.add('opacity-0', 'max-h-0');

                // Update Tab Styles
                maintenanceTab.classList.add('text-blue-600', 'font-semibold', 'border-b-2', 'border-blue-600');
                maintenanceTab.classList.remove('text-gray-500');

                specificationTab.classList.remove('text-blue-600', 'font-semibold', 'border-b-2', 'border-blue-600');
                specificationTab.classList.add('text-gray-500');
            }
        }

        // Quantity handling functions
        function updateQuantity(action) {
            const input = document.getElementById('quantity-input');
            let currentValue = parseInt(input.value) || 1;
            const maxQuantity = parseInt(input.max);

            if (action === 'increase' && currentValue < maxQuantity) {
                input.value = currentValue + 1;
            } else if (action === 'decrease' && currentValue > 1) {
                input.value = currentValue - 1;
            }
        }

        function validateQuantity(input) {
            let value = parseInt(input.value) || 1;
            const maxQuantity = parseInt(input.max);

            if (value < 1) value = 1;
            if (value > maxQuantity) value = maxQuantity;

            input.value = value;
        }

        // Add to cart function
        function addToCart(productId) {
            const quantity = document.getElementById('quantity-input').value;

            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart display if you have a cart counter in your layout
                        if (document.querySelector('.cart-count')) {
                            document.querySelector('.cart-count').textContent = data.cartCount;
                        }

                        // Show success message
                        showFlashMessage(data.message, 'success');

                        // Update cart contents if on cart page
                        if (typeof updateCartDisplay === 'function') {
                            updateCartDisplay(data);
                        }
                    } else {
                        showFlashMessage(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showFlashMessage('Error adding item to cart', 'error');
                });
        }

        // Flash message function (if not already defined)
        function showFlashMessage(message, type) {
            const flashDiv = document.createElement('div');
            flashDiv.className = `fixed top-20 right-10 p-4 rounded shadow-lg ${
                type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
            }`;
            flashDiv.textContent = message;
            document.body.appendChild(flashDiv);

            setTimeout(() => {
                flashDiv.remove();
            }, 3000);
        }
    </script>
@endsection

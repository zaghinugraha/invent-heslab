@extends('layouts.dashboard-admin')

@section('title', 'Item List')

@section('heading', 'Item List')
@section('headingDesc', 'Item List')
@section('description',
    'Ini adalah daftar barang yang tersedia untuk disewa. Anda dapat menggunakan bilah pencarian
    untuk menemukan barang tertentu, atau menavigasi halaman untuk melihat lebih banyak barang.')

@section('sidebar')
    <aside id="sidebar" class="transition-width w-64 h-full fixed top-16 bottom-16 lg:relative lg:h-screen p-2">
        <div class="bg-white rounded p-2">
            <nav class="space-y-2 bg-white rounded p-2">
                <a href="{{ route('dashboard-admin-items') }}"
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

@section('modals')
    <div x-show="newItem" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('newItem', value => document.body.classList.toggle('overflow-hidden', value))">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 mb-8 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Add New Item</h2>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Item Name -->
                <div class="mb-4">
                    <label class="block text-gray-700">Item Name</label>
                    <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        required />
                </div>
                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-700">Category</label>
                    <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Brand -->
                <div class="mb-4">
                    <label class="block text-gray-700">Brand</label>
                    <input type="text" name="brand" class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        required />
                </div>

                <!-- Date Arrived -->
                <div class="mb-4">
                    <label class="block text-gray-700">Date Arrived</label>
                    <input type="date" name="dateArrival"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-700">Price</label>
                    <input type="number" name="price" class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        required />
                </div>
                <!-- Quantity -->
                <div class="mb-4">
                    <label class="block text-gray-700">Quantity</label>
                    <input type="number" name="quantity" class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        required />
                </div>
                <!-- Alert Quantity -->
                <div class="mb-4">
                    <label class="block text-gray-700">Alert Quantity</label>
                    <input type="number" name="quantity_alert"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Source -->
                <div class="mb-4">
                    <label class="block text-gray-700">Source</label>
                    <input type="text" name="source" class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        required />
                </div>
                <!-- Specification -->
                <div class="mb-4">
                    <label class="block text-gray-700">Specification</label>
                    <textarea name="specification" class="w-full px-4 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <!-- Notes -->
                <div class="mb-4">
                    <label class="block text-gray-700">Notes</label>
                    <textarea name="notes" class="w-full px-4 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <!-- Product Image -->
                <div class="mb-4">
                    <label class="block text-gray-700">Product Image</label>
                    <input type="file" name="product_image"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" />
                </div>
                <!-- Form Buttons -->
                <div class="flex justify-end">
                    <button type="button" @click="newItem = false"
                        class="mr-2 bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Item</button>
                </div>
            </form>
        </div>
    </div>
    <div x-show="editItem" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('editItem', value => document.body.classList.toggle('overflow-hidden', value))">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 mb-8 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Edit Item</h2>
            <form :action="'/products/' + selectedProduct.uuid" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <!-- get all informasi item masukin ke dalam inputannya -->
                <!-- Item Name -->
                <div class="mb-4">
                    <label class="block text-gray-700">Item Name</label>
                    <input type="text" name="name" x-model="selectedProduct.name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-700">Category</label>
                    <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option :value="{{ $category->id }}"
                                x-bind:selected="selectedProduct.category_id == {{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Brand -->
                <div class="mb-4">
                    <label class="block text-gray-700">Brand</label>
                    <input type="text" name="brand" x-model="selectedProduct.brand"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>

                <!-- Date Arrived -->
                <div class="mb-4">
                    <label class="block text-gray-700">Date Arrived</label>
                    <input type="date" name="dateArrival" x-model="selectedProduct.dateArrival"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-700">Price</label>
                    <input type="number" name="price" x-model="selectedProduct.price"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Quantity -->
                <div class="mb-4">
                    <label class="block text-gray-700">Quantity</label>
                    <input type="number" name="quantity" x-model="selectedProduct.quantity"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Alert Quantity -->
                <div class="mb-4">
                    <label class="block text-gray-700">Alert Quantity</label>
                    <input type="number" name="quantity_alert" x-model="selectedProduct.quantity_alert"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Source -->
                <div class="mb-4">
                    <label class="block text-gray-700">Source</label>
                    <input type="text" name="source" x-model="selectedProduct.source"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Specification -->
                <div class="mb-4">
                    <label class="block text-gray-700">Specification</label>
                    <textarea name="specification" x-model="selectedProduct.specification_plain"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <!-- Notes -->
                <div class="mb-4">
                    <label class="block text-gray-700">Notes</label>
                    <textarea name="notes" x-model="selectedProduct.notes"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <!-- Product Image -->
                <div class="mb-4">
                    <label class="block text-gray-700">Product Image</label>
                    <input type="file" name="product_image"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" />
                </div>
                <!-- Maintenance Notes (Optional) -->
                <div class="mb-4">
                    <label class="block text-gray-700">Maintenance Notes (Optional)</label>
                    <textarea name="maintenance_notes" class="w-full px-4 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <!-- Maintenance Picture (Optional) -->
                <div class="mb-4">
                    <label class="block text-gray-700">Maintenance Picture (Optional)</label>
                    <input type="file" name="maintenance_picture"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" />
                </div>
                <!-- Form Buttons -->
                <div class="flex justify-end">
                    <button type="button" @click="editItem = false"
                        class="mr-2 bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update Item</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Manage Category Modal -->
    <div x-show="manageCategory" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('manageCategory', value => document.body.classList.toggle('overflow-hidden', value))" x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-2/3 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Manage Categories</h2>
            <table class="min-w-full table-auto border mb-4">
                <thead class="border">
                    <tr class="bg-blue-600 text-white">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($categories as $category)
                        <tr class="text-center">
                            <td class="px-4 py-2 border">{{ $category->id }}</td>
                            <td class="px-4 py-2 border">{{ $category->name }}</td>
                            <td class="px-4 py-2 border">
                                <button @click='selectedCategory = @json($category) ; editCategory = true;'
                                    class="bg-yellow-500 text-white px-3 py-1 rounded mr-2">
                                    Edit
                                </button>
                                <button @click='selectedCategory = @json($category); deleteCategory = true;'
                                    class="bg-red-500 text-white px-3 py-1 rounded">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-end">
                <button @click="manageCategory = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                    Close
                </button>
                <button @click="addCategory = true;" class="bg-green-500 text-white px-4 py-2 rounded">
                    Add New Category
                </button>
            </div>
        </div>
    </div>
    <!-- Add Category Modal -->
    <div x-show="addCategory" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('addCategory', value => document.body.classList.toggle('overflow-hidden', value))" x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Add New Category</h2>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <!-- Category Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required
                        placeholder="Enter category name" />
                </div>
                <!-- Form Buttons -->
                <div class="flex justify-end">
                    <button type="button" @click="addCategory = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                        Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Delete Category Modal (Are you sure you want to delete (category name)) -->
    <div x-show="deleteCategory" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('deleteCategory', value => document.body.classList.toggle('overflow-hidden', value))" x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Delete Category</h2>
            <p class="mb-4">Are you sure you want to delete <span class="font-bold"
                    x-text="selectedCategory.name"></span>?</p>
            <form :action="'/categories/' + selectedCategory.id" method="POST">
                @csrf
                @method('delete')
                <div class="flex justify-end">
                    <button type="button" @click="deleteCategory = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit Category Modal (Send category name to input field) -->
    <div x-show="editCategory" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('editCategory', value => document.body.classList.toggle('overflow-hidden', value))" x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Edit Category</h2>
            <form method="POST" :action="'/categories/' + selectedCategory.id">
                @csrf
                @method('put')
                <!-- Category Name -->
                <div class="mb-4">
                    <label for="edit-name" class="block text-gray-700">Category Name</label>
                    <input type="text" name="name" id="edit-name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" x-model="selectedCategory.name"
                        required placeholder="Enter category name" />
                </div>
                <!-- Form Buttons -->
                <div class="flex justify-end">
                    <button type="button" @click="editCategory = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content')

    <div class="space-y-4 mb-8 w-full mx-auto">
        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 w-full mx-auto">
            <!-- Maintenance Card -->
            <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
                <div class="bg-red-500 text-white font-semibold py-2">Need Maintenance</div>
                <div class="bg-white py-4 text-2xl font-bold text-black">0</div>
            </div>

            <!-- Low on Stock Card -->
            <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
                <div class="bg-yellow-600 text-white font-semibold py-2">Low on Stock</div>
                <div class="bg-white py-4 text-2xl font-bold text-black">{{ $lowStockCount }}</div>
            </div>
        </div>

        <!-- Search Bar and Add Item Button -->
        <div class="flex justify-between items-center mb-4">
            <!-- Left Side: Add Category Button -->
            <button @click="manageCategory = true"
                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                Manage Category
            </button>

            <!-- Right Side: Search Form and Add Item Button -->
            <div class="flex items-center space-x-2">
                <form action="{{ route('dashboard-admin-items') }}" method="GET" class="flex">
                    <input type="text" name="search" placeholder="Search"
                        class="w-full px-4 py-2 border rounded-l-lg focus:outline-none"
                        value="{{ request()->query('search') }}" />
                    <button type="submit" class="bg-gray-300 px-4 py-2 rounded-r-lg">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M21.707 20.293l-6.388-6.388A7.455 7.455 0 0018 10.5a7.5 7.5 0 10-7.5 7.5c1.8 0 3.464-.63 4.904-1.681l6.388 6.388a1 1 0 001.415-1.414zM10.5 16a5.5 5.5 0 110-11 5.5 5.5 0 010 11z">
                            </path>
                        </svg>
                    </button>
                </form>
                <button @click="newItem = true" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Add Item
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full table-auto border">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Brand</th>
                        <th class="px-4 py-2 border">Category</th>
                        <th class="px-4 py-2 border">Price</th>
                        <th class="px-4 py-2 border">Stock</th>
                        <th class="px-4 py-2 border">Picture</th>
                        <th class="px-4 py-2 border">Source</th>
                        <th class="px-4 py-2 border">Date Arrived</th>
                        <th class="px-4 py-2 border">Last Maintained</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                @forelse ($products as $product)
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 text-center">
                            <td class="px-4 py-2 border">{{ $product['id'] }}</td>
                            <td class="px-4 py-2 border">{{ $product['name'] }}</td>
                            <td class="px-4 py-2 border">{{ $product['brand'] }}</td>
                            <td class="px-4 py-2 border">{{ $product->category->name ?? 'No Category' }}</td>
                            <td class="px-4 py-2 border oldstyle-nums">
                                {{ number_format($product['price'], 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 border text-center diagonal-fractions"
                                style="
                @php
$maxQuantity = $products->max('quantity');
                    $minQuantity = $products->min('quantity');
                    $quantityAlert = $product->quantity_alert;

                    if ($product->quantity > $quantityAlert) {
                        // Quantities above the alert level (yellow to green)
                        $percentage = ($product->quantity - $quantityAlert) / ($maxQuantity - $quantityAlert);
                        $hue = intval(60 + ($percentage * 60)); // Hue from 60 (yellow) to 120 (green)
                    } elseif ($product->quantity < $quantityAlert) {
                        // Quantities below the alert level (yellow to red)
                        $percentage = ($quantityAlert - $product->quantity) / ($quantityAlert - $minQuantity);
                        $hue = intval(60 - ($percentage * 60)); // Hue from 60 (yellow) to 0 (red)
                    } else {
                        // Quantity equals alert level
                        $hue = 60; // Yellow
                    }
                    $color = 'hsl(' . $hue . ', 90%, 50%)'; @endphp
                background-color: {{ $color }};
            ">
                                {{ $product->quantity }}/{{ $product->quantity_alert }}
                            </td>
                            <td class="px-4 py-2 border relative group justify-center items-center">
                                <svg class="w-7 h-7 m-auto" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="16" cy="8" r="2" stroke="#1C274C" stroke-width="1.5" />
                                    <path
                                        d="M2 12.5001L3.75159 10.9675C4.66286 10.1702 6.03628 10.2159 6.89249 11.0721L11.1822 15.3618C11.8694 16.0491 12.9512 16.1428 13.7464 15.5839L14.0446 15.3744C15.1888 14.5702 16.7369 14.6634 17.7765 15.599L21 18.5001"
                                        stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                    <path
                                        d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8"
                                        stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                <div
                                    class="hidden group-hover:block absolute z-10 bg-white border border-gray-300 p-1 rounded preview-image w-max">
                                    <img src="{{ route('product.image', $product->uuid) }}" alt="{{ $product['name'] }}"
                                        class="w-32 h-32 object-cover rounded">
                                </div>
                            </td>
                            <td class="px-4 py-2 border">{{ $product['source'] }}</td>
                            <td class="px-4 py-2 border">{{ $product['dateArrival'] }}</td>
                            <td ss="px-4 py-2 border">tanggal last maintained</td>
                            <td class="px-4 py-2 border">
                                <div class="flex justify-center space-x-2">
                                    @php
                                        $productData = $product->toArray();
                                        array_walk_recursive($productData, function (&$item) {
                                            if (is_string($item)) {
                                                $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                                            }
                                        });
                                        $productJson = json_encode($productData);
                                    @endphp
                                    <button
                                        class="w-24 text-center bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600"
                                        @click="editItem = true; selectedProduct = JSON.parse(atob('{{ base64_encode($productJson) }}'))">Edit</button>
                                    <form action="{{ route('products.destroy', $product->uuid) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('delete')
                                        <button
                                            class="w-24 text-center bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600"
                                            onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        @empty
                            <td class="px-4 py-2 border text-center" colspan="11">No items found.</td>
                        </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{ $products->links() }}
    @endsection

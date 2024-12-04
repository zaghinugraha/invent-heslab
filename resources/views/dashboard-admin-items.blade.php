@extends('layouts.dashboard-admin')

@section('title', 'Daftar Barang')

@section('heading', 'Daftar Barang')
@section('headingDesc', 'Daftar Barang')
@section('description',
    'Halaman ini berisi daftar barang yang tersedia di sistem. Anda dapat menambahkan barang baru,
    mengedit barang yang sudah ada, atau menghapus barang yang sudah tidak digunakan.')

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
                    <span class="sidebar-text">Daftar Barang</span>
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
                    <span class="sidebar-text">Status Peminjaman</span>
                </a>
                <a href="{{ route('dashboard-admin-history') }}"
                    class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#000000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 6V12L16 16" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar-text ml-3">Riwayat</span>
                </a>
                <a href="{{ route('users.index') }}"
                    class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="7" r="4" stroke="#000000" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M4 21V17C4 15.8954 4.89543 15 6 15H18C19.1046 15 20 15.8954 20 17V21" stroke="#000000"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar-text ml-3">Kelola User</span>
                </a>
            </nav>
        </div>
    </aside>
@endsection

@section('modals')
    <div x-show="newItem" x-data="{
        itemName: '',
        searchResults: [],
        searchSimilarItems() {
            if (this.itemName.length > 2) {
                fetch(`{{ route('products.search') }}?q=${encodeURIComponent(this.itemName)}`)
                    .then(response => response.json())
                    .then(data => {
                        this.searchResults = data;
                    });
            } else {
                this.searchResults = [];
            }
        },
    }"
        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 mb-8 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Tambah Barang Baru</h2>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Item Name -->
                <div class="mb-4">
                    <label class="block text-gray-700">Nama Barang</label>
                    <input type="text" name="name" x-model="itemName" @input.debounce="searchSimilarItems"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />

                    <!-- Similar Items -->
                    <div x-show="searchResults.length > 0" class="mt-2 border rounded-lg p-2 bg-gray-100">
                        <p class="text-gray-700 font-semibold">Barang yang sama ketemu:</p>
                        <ul>
                            <template x-for="item in searchResults" :key="item.id">
                                <li class="p-2 border-b flex justify-between items-center">
                                    <span x-text="item.name"></span>
                                    <button
                                        class="text-center bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600"
                                        @click="editItem = true; newItem = false; selectedProduct = item">
                                        Edit
                                    </button>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-700">Kategori</label>
                    <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Brand -->
                <div class="mb-4">
                    <label class="block text-gray-700">Merek</label>
                    <input type="text" name="brand" class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        required />
                </div>

                <!-- Date Arrived -->
                <div class="mb-4">
                    <label class="block text-gray-700">Tanggal Masuk</label>
                    <input type="date" name="dateArrival"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-700">Harga</label>
                    <input type="number" name="price" class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        required />
                </div>
                <!-- Quantity -->
                <div class="mb-4">
                    <label class="block text-gray-700">Jumlah</label>
                    <input type="number" name="quantity" class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        required />
                </div>
                <!-- Alert Quantity -->
                <div class="mb-4">
                    <label class="block text-gray-700">Jumlah Minimal</label>
                    <input type="number" name="quantity_alert"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Source -->
                <div class="mb-4">
                    <label class="block text-gray-700">Sumber</label>
                    <input type="text" name="source" class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        required />
                </div>
                <!-- Specification -->
                <div class="mb-4">
                    <label class="block text-gray-700">Spesifikasi</label>
                    <textarea name="specification" class="w-full px-4 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <!-- Notes -->
                <div class="mb-4">
                    <label class="block text-gray-700">Deskripsi</label>
                    <textarea name="notes" class="w-full px-4 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <!-- Product Image -->
                <div class="mb-4">
                    <label class="block text-gray-700">Gambar Barang</label>
                    <input type="file" name="product_image"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" />
                </div>
                <!-- Form Buttons -->
                <div class="flex justify-end">
                    <button type="button" @click="newItem = false"
                        class="mr-2 bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Tambah Barang</button>
                </div>
            </form>
        </div>
    </div>
    <div x-show="editItem" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('editItem', value => document.body.classList.toggle('overflow-hidden', value))">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 mb-8 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Edit Barang</h2>
            <form :action="'/products/' + selectedProduct.uuid" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <!-- get all informasi item masukin ke dalam inputannya -->
                <!-- Item Name -->
                <div class="mb-4">
                    <label class="block text-gray-700">Nama Barang</label>
                    <input type="text" name="name" x-model="selectedProduct.name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-700">Kategori</label>
                    <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                        <option value="">Pilih Kategori</option>
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
                    <label class="block text-gray-700">Merek</label>
                    <input type="text" name="brand" x-model="selectedProduct.brand"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>

                <!-- Date Arrived -->
                <div class="mb-4">
                    <label class="block text-gray-700">Tanggal Masuk</label>
                    <input type="date" name="dateArrival" x-model="selectedProduct.dateArrival"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-700">Harga</label>
                    <input type="number" name="price" x-model="selectedProduct.price"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                {{-- Is Rentable --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Dapat Disewakan?</label>
                    <select name="is_rentable" x-model="selectedProduct.is_rentable"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>
                <!-- Quantity -->
                <div class="mb-4">
                    <label class="block text-gray-700">Jumlah</label>
                    <input type="number" name="quantity" x-model="selectedProduct.quantity"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Alert Quantity -->
                <div class="mb-4">
                    <label class="block text-gray-700">Jumlah Minimal</label>
                    <input type="number" name="quantity_alert" x-model="selectedProduct.quantity_alert"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Source -->
                <div class="mb-4">
                    <label class="block text-gray-700">Sumber</label>
                    <input type="text" name="source" x-model="selectedProduct.source"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required />
                </div>
                <!-- Specification -->
                <div class="mb-4">
                    <label class="block text-gray-700">Spesifikasi</label>
                    <textarea name="specification" x-model="selectedProduct.specification_plain"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <!-- Notes -->
                <div class="mb-4">
                    <label class="block text-gray-700">Deskripsi</label>
                    <textarea name="notes" x-model="selectedProduct.notes"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <!-- Product Image -->
                <div class="mb-4">
                    <label class="block text-gray-700">Gambar Barang</label>
                    <input type="file" name="product_image"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" />
                </div>
                <!-- Maintenance Notes (Optional) -->
                <div class="mb-4">
                    <label class="block text-gray-700">Catatan Pemeliharaan (Opsional)</label>
                    <textarea name="maintenance_notes" class="w-full px-4 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <!-- Maintenance Picture (Optional) -->
                <div class="mb-4">
                    <label class="block text-gray-700">Catatan Pemeliharaan (Opsional)</label>
                    <input type="file" name="maintenance_picture"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" />
                </div>
                <!-- Form Buttons -->
                <div class="flex justify-end">
                    <button type="button" @click="editItem = false"
                        class="mr-2 bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Perbarui Barang</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Manage Category Modal -->
    <div x-show="manageCategory" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('manageCategory', value => document.body.classList.toggle('overflow-hidden', value))" x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-2/3 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Kelola Kategori</h2>
            <table class="min-w-full table-auto border mb-4">
                <thead class="border">
                    <tr class="bg-blue-600 text-white">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Aksi</th>
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
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-end">
                <button @click="manageCategory = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                    Tutup
                </button>
                <button @click="addCategory = true;" class="bg-green-500 text-white px-4 py-2 rounded">
                    Tambah Kategori
                </button>
            </div>
        </div>
    </div>
    <!-- Add Category Modal -->
    <div x-show="addCategory" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('addCategory', value => document.body.classList.toggle('overflow-hidden', value))" x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Tambah Kategori</h2>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <!-- Category Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nama</label>
                    <input type="text" name="name" id="name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" required
                        placeholder="Masukkan nama kategori" />
                </div>
                <!-- Form Buttons -->
                <div class="flex justify-end">
                    <button type="button" @click="addCategory = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Delete Category Modal (Are you sure you want to delete (category name)) -->
    <div x-show="deleteCategory" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('deleteCategory', value => document.body.classList.toggle('overflow-hidden', value))" x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Hapus Kategori</h2>
            <p class="mb-4">Apakah anda yakin ingin menghapus kategori <span class="font-bold"
                    x-text="selectedCategory.name"></span>?</p>
            <form :action="'/categories/' + selectedCategory.id" method="POST">
                @csrf
                @method('delete')
                <div class="flex justify-end">
                    <button type="button" @click="deleteCategory = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit Category Modal (Send category name to input field) -->
    <div x-show="editCategory" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('editCategory', value => document.body.classList.toggle('overflow-hidden', value))" x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Edit Kategori</h2>
            <form method="POST" :action="'/categories/' + selectedCategory.id">
                @csrf
                @method('put')
                <!-- Category Name -->
                <div class="mb-4">
                    <label for="edit-name" class="block text-gray-700">Nama Kategori</label>
                    <input type="text" name="name" id="edit-name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none" x-model="selectedCategory.name"
                        required placeholder="Masukkan nama kategori" />
                </div>
                <!-- Form Buttons -->
                <div class="flex justify-end">
                    <button type="button" @click="editCategory = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Perbarui Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Import Excel Modal -->
    <div x-show="importExcel" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
        x-init="$watch('importExcel', value => document.body.classList.toggle('overflow-hidden', value))" x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 max-h-full overflow-y-auto">
            <h2 class="text-xl font-bold gradient-text mb-4">Import Barang dari Excel</h2>
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Excel File -->
                <div class="mb-4">
                    <label class="block text-gray-700">File Excel</label>
                    <input type="file" name="excel_file" class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        required />
                </div>
                <!-- Download Template Link -->

                <div class="mb-4">
                    <label class="block text-gray-700">Template (Wajib):</label>
                    <div class="flex justify-center">
                        <a href="{{ asset('templates/products_import_template.xlsx') }}" download
                            class="w-full font-bold text-center inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Download Template Disini
                        </a>
                    </div>
                </div>
                <!-- Form Buttons -->
                <div class="flex justify-end">
                    <button type="button" @click="importExcel = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                        Import Barang
                    </button>
                </div>
            </form>
        </div>
    @endsection

    @section('content')
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
        <div class="space-y-4 mb-8 w-full mx-auto">
            <!-- Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 w-full mx-auto">
                <!-- Maintenance Card -->
                <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-red-500 text-white font-semibold py-2">Butuh Pemeliharaan</div>
                    <div class="bg-white py-4 text-2xl font-bold text-black">{{ $needMaintenanceCount }}</div>
                </div>

                <!-- Low on Stock Card -->
                <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-yellow-600 text-white font-semibold py-2">Persediaan Rendah</div>
                    <div class="bg-white py-4 text-2xl font-bold text-black">{{ $lowStockCount }}</div>
                </div>
            </div>

            <!-- Search Bar and Add Item Button -->
            <div class="flex justify-between items-center mb-4">
                <!-- Left Side: Add Category Button -->
                <div class="flex items-center space-x-2">
                    <button @click="manageCategory = true"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                        Kelola Kategori
                    </button>
                    <button @click="importExcel = true"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center">
                        <svg fill="currentColor" class="w-6 h-6 mr-2" viewBox="0 0 1920 1920"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="m807.186 686.592 272.864 272.864H0v112.94h1080.05l-272.864 272.978 79.736 79.849 409.296-409.183-409.296-409.184-79.736 79.736ZM1870.419 434.69l-329.221-329.11C1509.688 74.07 1465.979 56 1421.48 56H451.773v730.612h112.94V168.941h790.584v451.762h451.762v1129.405H564.714v-508.233h-112.94v621.173H1920V554.52c0-45.176-17.619-87.754-49.58-119.83Zm-402.181-242.37 315.443 315.442h-315.443V192.319Z"
                                fill-rule="evenodd" />
                        </svg>
                        <span>Import from Excel</span>
                    </button>
                    <a href="{{ route('products.export') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center">
                        <svg fill="currentColor" class="w-6 h-6 mr-2" viewBox="0 0 1920 1920"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="m0 1016.081 409.186 409.073 79.85-79.736-272.867-272.979h1136.415V959.611H216.169l272.866-272.866-79.85-79.85L0 1016.082ZM1465.592 305.32l315.445 315.445h-315.445V305.32Zm402.184 242.372-329.224-329.11C1507.042 187.07 1463.334 169 1418.835 169h-743.83v677.647h112.94V281.941h564.706v451.765h451.765v903.53H787.946V1185.47H675.003v564.705h1242.353V667.522c0-44.498-18.07-88.207-49.581-119.83Z"
                                fill-rule="evenodd" />
                        </svg>
                        Export to Excel
                    </a>
                </div>

                <!-- Right Side: Search Form and Add Item Button -->
                <div class="flex items-center space-x-2">
                    <form action="{{ route('dashboard-admin-items') }}" method="GET" class="flex">
                        <input type="text" name="search" placeholder="Cari"
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
                    <button @click="newItem = true"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                        Tambah Barang
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w table-auto border">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">Merek</th>
                            <th class="px-4 py-2 border">Kategori</th>
                            <th class="px-4 py-2 border">Harga</th>
                            <th class="px-4 py-2 border">Persediaan</th>
                            <th class="px-4 py-2 border">Gambar</th>
                            <th class="px-4 py-2 border">Sumber</th>
                            <th class="px-4 py-2 border">Terakhir Dipelihara</th>
                            <th class="px-4 py-2 border">Bisa Dipinjam?</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    @forelse ($products as $product)
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50 text-center">
                                <td class="px-4 py-2 border">{{ $product['id'] }}</td>
                                <td class="px-4 py-2 border">{{ $product['name'] }}</td>
                                <td class="px-4 py-2 border">{{ $product['brand'] }}</td>
                                <td class="px-4 py-2 border">{{ $product->category->name ?? 'Tidak Ada Kategori' }}</td>
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
                                        <circle cx="16" cy="8" r="2" stroke="#1C274C"
                                            stroke-width="1.5" />
                                        <path
                                            d="M2 12.5001L3.75159 10.9675C4.66286 10.1702 6.03628 10.2159 6.89249 11.0721L11.1822 15.3618C11.8694 16.0491 12.9512 16.1428 13.7464 15.5839L14.0446 15.3744C15.1888 14.5702 16.7369 14.6634 17.7765 15.599L21 18.5001"
                                            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path
                                            d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8"
                                            stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                    <div class="relative group" onclick="togglePreview(this)">
                                        <div
                                            class="hidden group-hover:block absolute z-10 bg-white border border-gray-300 p-1 rounded preview-image w-max">
                                            <img src="{{ route('product.image', $product->uuid) }}"
                                                alt="{{ $product['name'] }}" class="w-32 h-32 object-cover rounded">
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2 border">{{ $product['source'] }}</td>
                                @php
                                    $lastMaintenance = $product->maintenance->sortByDesc('created_at')->first();
                                    $needsMaintenance = false;

                                    if ($lastMaintenance) {
                                        $maintenanceDueDate = \Carbon\Carbon::parse(
                                            $lastMaintenance->created_at,
                                        )->addWeek();
                                        $needsMaintenance = \Carbon\Carbon::now()->greaterThanOrEqualTo(
                                            $maintenanceDueDate,
                                        );
                                    } else {
                                        //need maintenance 1 week after arrival date
                                        $maintenanceDueDate = \Carbon\Carbon::parse($product->dateArrival)->addWeek();
                                        $needsMaintenance = \Carbon\Carbon::now()->greaterThanOrEqualTo(
                                            $maintenanceDueDate,
                                        );
                                    }
                                @endphp
                                <td class="px-4 py-2 border {{ $needsMaintenance ? 'text-red-500' : '' }}">
                                    @if ($lastMaintenance)
                                        {{ \Carbon\Carbon::parse($lastMaintenance->created_at)->diffForHumans() }}
                                    @else
                                        {{ \Carbon\Carbon::parse($product->dateArrival)->diffForHumans() }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">
                                    <div class="flex justify-center">
                                        @if ($product->is_rentable)
                                            <svg class="w-6 h-6 text-green-500" viewBox="0 0 20 20" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0" fill="none" width="20" height="20" />
                                                <g>
                                                    <path
                                                        d="M10 2c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm-.615 12.66h-1.34l-3.24-4.54 1.34-1.25 2.57 2.4 5.14-5.93 1.34.94-5.81 8.38z" />
                                                </g>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-red-500" viewBox="0 0 20 20" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0" fill="none" width="20" height="20" />
                                                <g>
                                                    <path
                                                        d="M10 2c4.42 0 8 3.58 8 8s-3.58 8-8 8-8-3.58-8-8 3.58-8 8-8zm5 11l-3-3 3-3-2-2-3 3-3-3-2 2 3 3-3 3 2 2 3-3 3 3z" />
                                                </g>
                                            </svg>
                                        @endif
                                    </div>
                                </td>
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
                                                onclick="return confirm('Apakah anda yakin ingin menghapus barang ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            @empty
                                <td class="px-4 py-2 border text-center" colspan="11">Tidak ada barang yang tersedia.
                                </td>
                            </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination -->
        {{ $products->links() }}
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script>
            function togglePreview(element) {
                const preview = element.querySelector('.preview-image');
                if (preview.classList.contains('hidden')) {
                    preview.classList.remove('hidden');
                    preview.classList.add('block');
                } else {
                    preview.classList.remove('block');
                    preview.classList.add('hidden');
                }
            }
        </script>
    @endsection

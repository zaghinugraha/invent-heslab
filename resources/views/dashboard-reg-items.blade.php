{{-- @class(\App\Models\Product::$product) --}}

@extends('layouts.dashboard-reg')

@section('title', 'Daftar Barang')

@section('heading', 'Daftar Barang')
@section('headingDesc', 'Daftar Barang')
@section('description',
    'Ini adalah daftar barang yang tersedia untuk disewa. Anda dapat menggunakan bilah pencarian
    untuk menemukan barang tertentu, atau menavigasi halaman untuk melihat lebih banyak barang.')

@section('sidebar')
    <aside id="sidebar" class="transition-width w-64 h-max fixed top-16 bottom-16 lg:relative p-2">
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

@section('modals')
    {{-- Filter Modal --}}
    <div x-show="showFilter" @click.away="showFilter = false"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-1/2">
            <h2 class="text-2xl font-bold mb-4 gradient-text">Filter</h2>
            <form action="{{ route('dashboard-reg-items') }}" method="GET">
                <!-- Include existing search query -->
                <input type="hidden" name="search" value="{{ $searchQuery ?? '' }}">
                <div class="flex flex-col space-y-4">
                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category" id="category" class="mt-1 block w-full px-3 py-2 border rounded-md">
                            <option value="all" {{ ($selectedCategory ?? 'all') == 'all' ? 'selected' : '' }}>Semua
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ ($selectedCategory ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Availability Filter -->
                    <div>
                        <label for="availability" class="block text-sm font-medium text-gray-700">Ketersediaan</label>
                        <select name="availability" id="availability" class="mt-1 block w-full px-3 py-2 border rounded-md">
                            <option value="all" {{ ($selectedAvailability ?? 'all') == 'all' ? 'selected' : '' }}>All
                            </option>
                            <option value="available" {{ ($selectedAvailability ?? '') == 'available' ? 'selected' : '' }}>
                                Tersedia</option>
                            <option value="unavailable"
                                {{ ($selectedAvailability ?? '') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia
                            </option>
                        </select>
                    </div>
                    <!-- Form Buttons -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Apply</button>
                        <button type="button"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg ml-2 hover:bg-gray-400"
                            @click="showFilter = false">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content')
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
    <div class="space-y-4 mb-8 w-full mx-auto">
        <!-- Search Bar and Filter Button -->
        <div class="w-full flex justify-end space-x-2">
            <form class="flex w-full" action="{{ route('dashboard-reg-items') }}" method="GET">
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
            <button @click="showFilter = !showFilter"
                class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">Filter</button>
        </div>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
        @forelse ($products as $product)
            <a href="{{ route('products.showByID', $product->id) }}" class="block">
                <div class="border border-gray-300 rounded-lg p-4 hover:shadow-lg relative">
                    <!-- Spinner -->
                    <div class="spinner-container flex items-center justify-center w-full h-32 mb-4">
                        <div class="spinner"></div>
                    </div>
                    <!-- Existing card content -->
                    <img src="{{ route('product.image', $product->uuid) }}" alt="{{ $product->name }}"
                        class="w-full h-32 object-cover rounded-md mb-4 hidden"
                        onload="this.style.display='block'; this.previousElementSibling.style.display='none';">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-gray-800 font-semibold">{{ $product->name }}</h3>

                        @if ($product->quantity <= 0 || !$product->is_rentable)
                            <span class="bg-red-100 text-red-600 text-xs font-semibold px-2 py-1 rounded-full">Tidak
                                Tersedia</span>
                        @else
                            <span
                                class="bg-green-100 text-green-600 text-xs font-semibold px-2 py-1 rounded-full">Tersedia</span>
                        @endif
                    </div>
                    @if (!auth()->user()->hasType('Regular'))
                        <p class="text-gray-600">Gratis</p>
                    @else
                        <p class="text-gray-600">Rp {{ number_format($product['price'], 0, ',', '.') }} / Minggu</p>
                    @endif
                </div>
            </a>
        @empty
            <p class="text-gray-600">Tidak ada barang yang ditemukan.</p>
        @endforelse
    </div>


    <!-- Pagination -->

    {{ $products->links() }}



    {{-- <div class="mt-4 flex justify-center"> --}}
    {{--  <nav class="inline-flex -space-x-px"> --}}
    {{--    <a href="#" class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100">Previous</a> --}}
    {{--    <a href="#" class="px-3 py-2 leading-tight text-white bg-blue-600 border border-gray-300 hover:bg-blue-700">1</a> --}}
    {{--    <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">2</a> --}}
    {{--    <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">3</a> --}}
    {{--    <span class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300">...</span> --}}
    {{--    <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">67</a> --}}
    {{--    <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">68</a> --}}
    {{--    <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100">Next</a> --}}
    {{--  </nav> --}}
    {{-- </div> --}}
@endsection

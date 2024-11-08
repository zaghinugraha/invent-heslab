@extends('layouts.dashboard-reg')

@section('title', 'Item List')

@section('heading', 'Item List')
@section('headingDesc', 'Item List')
@section('description', 'Ini adalah daftar barang yang tersedia untuk disewa. Anda dapat menggunakan bilah pencarian untuk menemukan barang tertentu, atau menavigasi halaman untuk melihat lebih banyak barang.')

@section('sidebar')
<aside id="sidebar" class="transition-width w-64 bg-gray-200 h-full fixed top-16 bottom-16 lg:relative lg:h-screen p-2">
  <div class="bg-white rounded p-2">
    <nav class="space-y-2 bg-white rounded p-2">
      <a href="{{ route('dashboard-admin-items') }}" class="flex items-center space-x-2 text-white bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <line x1="5" y1="7" x2="19" y2="7" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <line x1="5" y1="12" x2="19" y2="12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <line x1="5" y1="17" x2="19" y2="17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="sidebar-text">Item List</span>
      </a>
      <a href="{{ route('dashboard-admin-rent') }}" class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M18 2H6C5.44772 2 5 2.44772 5 3V22L7.5 20L9.5 22L12 20L14.5 22L16.5 20L19 22V3C19 2.44772 18.5523 2 18 2Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9 6H15" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9 10H15" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9 14H10" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="sidebar-text">Rent Status</span>
      </a>
      <a href="{{ route('dashboard-admin-history') }}" class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="12" cy="12" r="10" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12 6V12L16 16" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="sidebar-text ml-3">History</span>
      </a>
    </nav>
  </div>
</aside>
@endsection

@section('content')

<div class="space-y-4 mb-8 w-full mx-auto">
  <!-- Search Bar and Filter Button -->
  <div class="w-full flex justify-end space-x-2">
    <div class="flex w-full">
      <input type="text" placeholder="Search" class="w-full px-4 py-2 border rounded-l-lg focus:outline-none" />
      <button class="bg-gray-300 px-4 py-2 rounded-r-lg">
        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
          <path d="M21.707 20.293l-6.388-6.388A7.455 7.455 0 0018 10.5a7.5 7.5 0 10-7.5 7.5c1.8 0 3.464-.63 4.904-1.681l6.388 6.388a1 1 0 001.415-1.414zM10.5 16a5.5 5.5 0 110-11 5.5 5.5 0 010 11z"></path>
        </svg>
      </button>
    </div>
    <button class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
      Filter
    </button>
  </div>
</div>

<!-- Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
    @for ($i = 0; $i < 9; $i++)
        <div class="border border-gray-300 rounded-lg p-4 hover:shadow-lg relative">
            <!-- Dummy Image (You can replace with actual images if you have) -->
            <img src="https://digiwarestore.com/11109-large_default/dht11-module-temperature-humidity-sensor-temperatur-kelembaban-for-arduino-with-led-297030.jpg" alt="Sensor Image" class="w-full h-32 object-cover rounded-md mb-4">
            
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-gray-800 font-semibold">Sensor {{ $i + 1 }}</h3>
                <span class="bg-green-100 text-green-600 text-xs font-semibold px-2 py-1 rounded-full">Available</span>
            </div>

            <!-- Dummy Price -->
            <p class="text-gray-600">Rp. 13,000</p>

            <!-- Static Availability Badge -->
            <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
              <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
        </div>
    @endfor
</div>


<!-- Pagination -->
<div class="mt-4 flex justify-center">
  <nav class="inline-flex -space-x-px">
    <a href="#" class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100">Previous</a>
    <a href="#" class="px-3 py-2 leading-tight text-white bg-blue-600 border border-gray-300 hover:bg-blue-700">1</a>
    <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">2</a>
    <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">3</a>
    <span class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300">...</span>
    <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">67</a>
    <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">68</a>
    <a href="#" class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100">Next</a>
  </nav>
</div>
@endsection
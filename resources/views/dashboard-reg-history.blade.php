@extends('layouts.dashboard-reg')

@section('title', 'History')

@section('heading', 'History')
@section('headingDesc', 'History')
@section('description', 'Ini adalah daftar barang-barang yang sudah kamu pinjam. Gunakan kolom pencarian untuk menemukan catatan tertentu, atau navigasikan halaman untuk melihat riwayat lebih lanjut.')

@section('sidebar')
<aside id="sidebar" class="transition-width w-64 h-full fixed top-16 bottom-16 lg:relative lg:h-screen p-2">
  <div class="bg-white rounded p-2">
    <nav class="space-y-2 bg-white rounded p-2">
      <a href="{{ route('dashboard-reg-items') }}" class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <line x1="5" y1="7" x2="19" y2="7" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <line x1="5" y1="12" x2="19" y2="12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <line x1="5" y1="17" x2="19" y2="17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="sidebar-text">Item List</span>
      </a>
      <a href="{{ route('dashboard-reg-rent') }}" class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M18 2H6C5.44772 2 5 2.44772 5 3V22L7.5 20L9.5 22L12 20L14.5 22L16.5 20L19 22V3C19 2.44772 18.5523 2 18 2Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9 6H15" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9 10H15" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9 14H10" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="sidebar-text">Rent Request</span>
      </a>
      <a href="{{ route('dashboard-reg-history') }}" class="flex items-center space-x-2 text-white bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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

<div class="space-y-4 w-full mx-auto">
  <!-- Status Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 w-full mx-auto">
    <!-- Rejected Card -->
    <div class="text-center rounded-lg shadow-lg overflow-hidden">
      <div class="bg-red-500 text-white font-semibold py-2">Rejected</div>
      <div class="bg-white py-4 text-2xl font-bold text-black">0</div>
    </div>

    <!-- Returned Card -->
    <div class="text-center rounded-lg shadow-lg overflow-hidden">
      <div class="bg-blue-500 text-white font-semibold py-2">Returned</div>
      <div class="bg-white py-4 text-2xl font-bold text-black">0</div>
    </div>
  </div>

<!-- Table -->
<div class="overflow-x-auto rounded-lg">
  <table class="min-w-full table-auto border">
    <thead>
      <tr class="bg-blue-600 text-white">
        <th class="px-4 py-2 border">No</th>
        <th class="px-4 py-2 border">Item</th>
        <th class="px-4 py-2 border">Price</th>
        <th class="px-4 py-2 border">Rent Date</th>
        <th class="px-4 py-2 border">Return Date</th>
        <th class="px-4 py-2 border">Status</th>
        <!-- Additional headers -->
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <tr class="hover:bg-gray-50 text-center">
        <td class="px-4 py-2 border">1</td>
        <td class="px-4 py-2 border">Sensor DHT22</td>
        <td class="px-4 py-2 border">Rp 12.000</td>
        <td class="px-4 py-2 border">13/10/2024</td>
        <td class="px-4 py-2 border">18/10/2024</td>
        <td class="px-4 py-2 border">
            <span class="inline-block px-2 py-1 text-white rounded bg-red-500">Rejected</span>
          </td>
        <!-- Additional cells -->
      </tr>
      <!-- Repeat for other rows -->
    </tbody>
  </table>
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
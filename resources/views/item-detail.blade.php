@extends('layouts.dashboard-reg')

@section('title', $item['name'])

@section('heading', $item['name'])
@section('sidebar')
<aside id="sidebar" class="transition-width w-64 h-full fixed top-16 bottom-16 lg:relative lg:h-screen p-2">
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

@section('breadcrumb')
<ol class="flex text-sm text-gray-500">
    <li><a href="{{ route('dashboard-reg-items') }}" class="hover:underline">Item List</a></li>
    <li class="mx-2">/</li>
    <li class="font-bold">{{ $item['name'] }}</li>
</ol>
@endsection

@section('content')
<div class="max-w-5xl mx-auto p-6 flex flex-col lg:flex-row gap-6">
    <div class="w-full lg:w-1/3">
        <div class="border border-gray-300 rounded-lg overflow-hidden mb-4">
            <img src="{{ $item['image'] }}" alt="Product Image" class="w-full h-64 object-cover">
        </div>
    <!-- Thumbnail Images -->
        <div class="flex gap-2 overflow-x-auto">
            <img src="{{ $item['image'] }}" alt="Thumbnail" class="w-14 h-14 border border-gray-300 rounded-lg flex-shrink-0">
            <img src="{{ $item['image'] }}" alt="Thumbnail" class="w-14 h-14 border border-gray-300 rounded-lg flex-shrink-0">
            <img src="{{ $item['image'] }}" alt="Thumbnail" class="w-14 h-14 border border-gray-300 rounded-lg flex-shrink-0">
            <img src="{{ $item['image'] }}" alt="Thumbnail" class="w-14 h-14 border border-gray-300 rounded-lg flex-shrink-0">
        </div>
    </div>
    <div class="w-full lg:w-2/3">
        <!-- Product Title and Stock -->
        <div class="flex flex-col sm:flex-row justify-between items-start">
            <h1 class="text-2xl font-bold text-gray-800">{{ $item['name'] }}</h1>
            <span class="text-sm text-gray-500 mt-2 sm:mt-0">Stock: <span class="font-semibold text-gray-800">20</span></span>
        </div>
        
        <!-- Price -->
        <p class="text-xl text-gray-700 font-semibold mt-2">{{ $item['price'] }}</p>
        
        <!-- Quantity Selector and Buttons -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 mt-4">
            <!-- Quantity Selector -->
            <div class="flex items-center border border-gray-300 rounded">
                <button class="px-3 py-1 text-gray-700">-</button>
                <input type="text" value="2" class="w-12 text-center border-0 focus:outline-none">
                <button class="px-3 py-1 text-gray-700">+</button>
            </div>
            
            <!-- Buttons -->
            <div class="flex gap-2 mt-2 sm:mt-0">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add to Cart</button>
                <button class="border border-blue-600 text-blue-600 px-4 py-2 rounded hover:bg-blue-50">Rent Now</button>
            </div>
        </div>
        
        <!-- Tabs (Specification and Maintenance) -->
        <div class="flex gap-4 mt-6 border-b border-gray-200">
            <button onclick="showTab('specification')" id="specification-tab" class="text-blue-600 font-semibold pb-2 border-b-2 border-blue-600">
                Specification
            </button>
            <button onclick="showTab('maintenance')" id="maintenance-tab" class="text-gray-500 hover:text-gray-700 pb-2">
                Maintenance
            </button>
        </div>

        <!-- Specification Content -->
        <div id="specification-content" class="transition-all duration-300 ease-in-out opacity-100 max-h-full overflow-hidden">
            <p class="text-gray-600 mt-4">
                {{ $item['description'] }}
            </p>

            <ul class="text-gray-600 mt-2 list-disc list-inside space-y-1">
                <li>Humidity measuring range: 20%-95% (0 degrees -> 50 degrees) Humidity measurement error: +/-5%</li>
                <li>Temperature measurement range: 0 degrees -> 50 degrees temperature measurement error: +/- 2 degrees</li>
                <li>Operating voltage 3.3V-5V</li>
                <li>Output Type Digital Output</li>
                <li>With fixed bolt hole for easy installation</li>
                <li>Small plates PCB size: 3.2cm x 1.4cm</li>
            </ul>
        </div>

        <!-- Maintenance Content -->
        <div id="maintenance-content" class="transition-all duration-300 ease-in-out opacity-0 max-h-0 overflow-hidden">
            <p class="text-gray-600 mt-4">
                <!-- Add your maintenance information here -->
                Maintenance instructions and information about the product.
            </p>
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
            specificationContent.classList.add('opacity-100', 'max-h-full');

            // Hide Maintenance Content
            maintenanceContent.classList.remove('opacity-100', 'max-h-full');
            maintenanceContent.classList.add('opacity-0', 'max-h-0');

            // Update Tab Styles
            specificationTab.classList.add('text-blue-600', 'font-semibold', 'border-b-2', 'border-blue-600');
            specificationTab.classList.remove('text-gray-500');

            maintenanceTab.classList.remove('text-blue-600', 'font-semibold', 'border-b-2', 'border-blue-600');
            maintenanceTab.classList.add('text-gray-500');
        } else if (tab === 'maintenance') {
            // Show Maintenance Content
            maintenanceContent.classList.remove('opacity-0', 'max-h-0');
            maintenanceContent.classList.add('opacity-100', 'max-h-full');

            // Hide Specification Content
            specificationContent.classList.remove('opacity-100', 'max-h-full');
            specificationContent.classList.add('opacity-0', 'max-h-0');

            // Update Tab Styles
            maintenanceTab.classList.add('text-blue-600', 'font-semibold', 'border-b-2', 'border-blue-600');
            maintenanceTab.classList.remove('text-gray-500');

            specificationTab.classList.remove('text-blue-600', 'font-semibold', 'border-b-2', 'border-blue-600');
            specificationTab.classList.add('text-gray-500');
        }
    }
</script>
@endsection
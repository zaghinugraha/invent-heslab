<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HES Vault Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    /* Smooth transition for sidebar width */
    .transition-width {
      transition: width 0.3s ease;
    }
  </style>
</head>
<body class="bg-gray-100">
  <!-- Header -->
  <header class="flex items-center justify-between px-6 py-4 bg-white shadow-md">
    <div class="flex items-center space-x-9">
        <img src="images/logo_text.png" alt="HES Vault Logo" class="h-8">
      <button id="sidebarToggle" class="text-gray-600 focus:outline-none">
        <img id="menu-icon" src="{{ asset('svg/menu-hambuger-svgrepo-com.svg') }}" class="w-5 h-5 text-gray-400" alt="Menu">
      </button>
    </div>
    <div class="flex items-center space-x-4">
      <button class="relative">
        <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
          <!-- Bell Icon -->
          <path d="M10 21h4v-1h-4v1zm-7.293-3.293L3 16v-6c0-3.223 2.4-5.879 5.513-6.651l.499-.145C9.192 3.114 9 2.57 9 2h6c0 .57-.192 1.114-.512 1.204l.499.145C18.6 4.121 21 6.777 21 10v6l.293.707A1 1 0 0120 18h-1v1a3 3 0 01-6 0v-1H4a1 1 0 01-.707-1.707zM4 16v-6c0-2.57 1.897-4.657 4.502-5.057l.498-.144C8.194 5.114 8 4.57 8 4h8c0 .57-.192 1.114-.513 1.204l.5.145C19.103 5.343 21 7.43 21 10v6h-1v1a1 1 0 11-2 0v-1H6v1a1 1 0 01-2 0v-1H4z"></path>
        </svg>
        <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-600 text-white text-xs font-semibold rounded-full text-center">3</span>
      </button>
      <img src="path-to-user-avatar.png" alt="User Avatar" class="w-8 h-8 rounded-full border border-gray-300">
    </div>
  </header>

  <div class="flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="transition-width w-64 bg-gray-200 p-6 h-screen fixed lg:relative lg:block">
      <nav class="space-y-4">
        <a href="#" class="flex items-center space-x-2 text-gray-700">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 4h18v2H3V4zm0 6h18v2H3v-2zm0 6h18v2H3v-2z"></path>
          </svg>
          <span>Item List</span>
        </a>
        <a href="#" class="flex items-center space-x-2 text-gray-700">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M5 3a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h14v4H5V5zm0 6h14v8H5v-8z"></path>
          </svg>
          <span>Rent Request</span>
        </a>
        <a href="#" class="flex items-center space-x-2 text-white bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 3h18v18H3V3zm16 16V5H5v14h14z"></path>
          </svg>
          <span>History</span>
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main id="mainContent" class="flex-1 ml-64 lg:ml-0 p-8 transition-width">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-blue-600 mb-4">History</h2>
        <p class="text-gray-600 mb-4">History</p>
        <hr class="mb-4">

        <!-- Search Bar -->
        <div class="flex justify-end mb-4">
          <input type="text" placeholder="Search" class="w-1/3 px-4 py-2 border rounded-l-lg focus:outline-none" />
          <button class="bg-gray-300 px-4 py-2 rounded-r-lg">
            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
              <path d="M21.707 20.293l-6.388-6.388A7.455 7.455 0 0018 10.5a7.5 7.5 0 10-7.5 7.5c1.8 0 3.464-.63 4.904-1.681l6.388 6.388a1 1 0 001.415-1.414zM10.5 16a5.5 5.5 0 110-11 5.5 5.5 0 010 11z"></path>
            </svg>
          </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="w-full border-collapse border">
            <thead>
              <tr class="bg-blue-600 text-white">
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">NIM/NIP</th>
                <th class="border px-4 py-2">Item</th>
                <th class="border px-4 py-2">Price</th>
                <th class="border px-4 py-2">Rent Date</th>
                <th class="border px-4 py-2">Return Date</th>
              </tr>
            </thead>
            <tbody>
              <!-- Sample Table Rows -->
              <tr class="text-center">
                <td class="border px-4 py-2">1</td>
                <td class="border px-4 py-2">Agus Supriyanto</td>
                <td class="border px-4 py-2">13030330303</td>
                <td class="border px-4 py-2">Sensor DHT22</td>
                <td class="border px-4 py-2">Rp 11.000</td>
                <td class="border px-4 py-2">13/10/2024</td>
                <td class="border px-4 py-2">17/10/2024</td>
              </tr>
              <!-- Repeat table rows as needed -->
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4">
          <button class="text-blue-500 hover:underline">Previous</button>
          <div class="flex space-x-2">
            <button class="bg-blue-600 text-white px-3 py-1 rounded">1</button>
            <button class="text-blue-500 hover:underline">2</button>
            <button class="text-blue-500 hover:underline">3</button>
            <span>...</span>
            <button class="text-blue-500 hover:underline">67</button>
            <button class="text-blue-500 hover:underline">68</button>
          </div>
          <button class="text-blue-500 hover:underline">Next</button>
        </div>
      </div>
    </main>
  </div>

  <!-- Footer -->
  <footer class="w-full py-4 text-center bg-white text-gray-500 text-sm border-t mt-8">
    <p>&copy; 2024 HES VAULT. All rights reserved.</p>
  </footer>

  <!-- Script for sidebar toggle -->
  <script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('w-64');
      sidebar.classList.toggle('w-20'); // Reduced width when collapsed
      mainContent.classList.toggle('ml-64');
      mainContent.classList.toggle('ml-20');
    });
  </script>
</body>
</html>

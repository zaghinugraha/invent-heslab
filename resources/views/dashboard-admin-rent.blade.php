<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HES Vault Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    /* Sidebar Styles */
    #sidebar {
      transition: width 0.3s ease;
    }

    /* Hide text and adjust icon size when sidebar is collapsed */
    #sidebar.collapsed .sidebar-text {
      display: none;
    }
    #sidebar.collapsed svg {
      width: 28px;
      height: 28px;
    }

    #sidebar.collapsed nav a {
      justify-content: center;
    }

    #sidebar nav a {
      display: flex;
      align-items: center;
      padding: 0.5rem;
    }

    #sidebar nav a svg {
      width: 24px;
      height: 24px;
      flex-shrink: 0;
    }
    /* Adjust main content margin when sidebar is collapsed */
    #mainContent {
      transition: margin-left 0.3s ease;
    }

    .footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
    }
  </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
  <div class="flex flex-col flex-grow">
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
        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M5.6 9.45798V8.4C5.6 4.86538 8.46538 2 12 2C15.5346 2 18.4 4.86537 18.4 8.4V9.45798C18.4 11.7583 19.0649 14.0096 20.3146 15.9409L21 17H3L3.68539 15.9408C4.93512 14.0096 5.6 11.7583 5.6 9.45798Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M11 20.8889V20.8889C11.5344 21.4827 12.4656 21.4827 13 20.8889V20.8889" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
          <!-- ini span buat jumlah notip, disesuaiin sama jumlah notip user yang ada di db -->
          <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-600 text-white text-xs font-semibold rounded-full text-center">3</span>
        </button>
        <!-- poto propil user -->
        <img src="images/profil.png" alt="User Avatar" class="w-8 h-8 rounded-full border border-gray-300">
      </div>
    </header>

    <div class="flex">
      <!-- Sidebar -->
      <aside id="sidebar" class="transition-width w-64 bg-gray-200 h-screen fixed lg:relative lg:block p-2">
      <div class="bg-white rounded p-2">  
        <nav class="space-y-2 bg-white rounded p-2">
            <a href="#" class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <line x1="5" y1="7" x2="19" y2="7" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="5" y1="12" x2="19" y2="12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="5" y1="17" x2="19" y2="17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
              <span class="sidebar-text">Item List</span>
            </a>
            <a href="#" class="flex items-center space-x-2 text-white bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 2H6C5.44772 2 5 2.44772 5 3V22L7.5 20L9.5 22L12 20L14.5 22L16.5 20L19 22V3C19 2.44772 18.5523 2 18 2Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9 6H15" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9 10H15" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9 14H10" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <span class="sidebar-text">Rent Request</span>
            </a>
            <a href="#" class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M12 6V12L16 16" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <span class="sidebar-text ml-3">History</span>
            </a>
            <a href="#" class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="7" r="4" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M4 21V17C4 15.8954 4.89543 15 6 15H18C19.1046 15 20 15.8954 20 17V21" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
              <span class="sidebar-text ml-3">Manage Users</span>
            </a>
          </nav>
      </div>
      </aside>

      <!-- Main Content -->
      <main id="mainContent" class="flex-1 ml-64 lg:ml-0 p-8 transition-width">
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-2xl font-bold text-blue-600 mb-4">Rent Request</h2>
          <p class="text-gray-600 mb-4">
            Selamat datang di halaman <span class="font-bold">Rent Request</span>!
          </p>
          <p class="text-gray-600 mb-4">
            ACC PEMINJAMAN BWANG!
          </p>
          <hr class="mb-4">

          <!-- Container for Status Cards and Table -->
          <div class="flex flex-col items-center">

          <!-- Status Cards -->
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 w-full">
            <!-- Approved Card -->
            <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
              <div class="bg-green-500 text-white font-semibold py-2">Approved</div>
              <div class="bg-white py-4 text-2xl font-bold text-black">0</div>
            </div>

            <!-- Rejected Card -->
            <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
              <div class="bg-red-500 text-white font-semibold py-2">Rejected</div>
              <div class="bg-white py-4 text-2xl font-bold text-black">0</div>
            </div>

            <!-- Waiting Card -->
            <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
              <div class="bg-yellow-500 text-white font-semibold py-2">Waiting</div>
              <div class="bg-white py-4 text-2xl font-bold text-black">0</div>
            </div>

            <!-- Returned Card -->
            <div class="w-full text-center rounded-lg shadow-lg overflow-hidden">
              <div class="bg-blue-500 text-white font-semibold py-2">Returned</div>
              <div class="bg-white py-4 text-2xl font-bold text-black">0</div>
            </div>
          </div>

          <!-- Table -->
          <div class="overflow-x-auto w-full">
            <table class="min-w-full table-auto border">
              <thead>
                <tr class="bg-blue-600 text-white">
                  <th class="px-4 py-2 border">No</th>
                  <th class="px-4 py-2 border">Name</th>
                  <th class="px-4 py-2 border">NIM/NIP</th>
                  <th class="px-4 py-2 border">Item</th>
                  <th class="px-4 py-2 border">Price</th>
                  <th class="px-4 py-2 border">Rent Date</th>
                  <th class="px-4 py-2 border">Return Date</th>
                  <th class="px-4 py-2 border">Action</th>
                  <th class="px-4 py-2 border">Status</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50 text-center">
                  <td class="px-4 py-2 border">1</td>
                  <td class="px-4 py-2 border">Agus Supriyanto</td>
                  <td class="px-4 py-2 border">13030330303</td>
                  <td class="px-4 py-2 border">Sensor DHT22</td>
                  <td class="px-4 py-2 border">Rp 12.000</td>
                  <td class="px-4 py-2 border">13/10/2024</td>
                  <td class="px-4 py-2 border">18/10/2024</td>
                  <td class="px-4 py-2 border">
                    <div class="flex justify-center space-x-2">
                      <button class="w-24 text-center bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Approve</button>
                      <button class="w-24 text-center bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Reject</button>
                    </div>
                  </td>
                  <td class="px-4 py-2 border">
                    <!-- <span class="inline-block px-2 py-1 text-white rounded 
                      {{ 'approved' ? 'bg-green-500' : '' }}
                      {{  'rejected' ? 'bg-red-500' : '' }}
                      {{  'waiting' ? 'bg-yellow-500' : '' }}
                      {{  'returned' ? 'bg-blue-500' : '' }}">
                    </span> -->
                    <!-- contoh doang -->
                     <span class="inlline-block px-2 py-1 text-white rounded bg-yellow-500">Waiting</span>
                  </td>
                </tr>
                <!-- Repeat for other rows -->
              </tbody>
            </table>
          </div>
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
        </div>
      </main>
    </div>

    <!-- Footer -->
    <footer class="footer w-full text-center p-4 bg-white">
    <div class="flex items-center justify-center">
      <img src="{{ asset('images/logo_text.png') }}" alt="HES Vault Logo" class="h-6 mr-2">
      <p class="text-xs text-black font-semibold">&copy; 2024 HES VAULT. All rights reserved.</p>
    </div>
  </footer>
  </div>
  <!-- Script for sidebar toggle -->
  <script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('w-64');
      sidebar.classList.toggle('w-20'); // Reduced width when collapsed
      sidebar.classList.toggle('collapsed');
      mainContent.classList.toggle('ml-64');
      mainContent.classList.toggle('ml-20');
    });
  </script>
</body>
</html>

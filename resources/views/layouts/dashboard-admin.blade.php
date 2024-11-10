<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'HES Vault Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <style>
    /* Sidebar Styles */
    #sidebar {
      transition: width 0.3s ease;
    }
    .gradient-text {
      background: linear-gradient(to right, #4f46e5, #3b82f6);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
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
    
    .preview-image {
      display: none;
      position: absolute;
      top: 0;
      left: 0;
      transform: translate(10px, 10px);
    }
    .group:hover .preview-image {
      display: block;
    }
  </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen" x-data="{ confirmLogout : false, propil : false, addTeam : false, newItem : false, showNotifications : false, editItem : false }">

  @yield('modals')
  <!-- Notifications Modal -->
  <div x-show="showNotifications" @click.away="showNotifications = false" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-20">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/3 mb-8">
      <h2 class="text-xl font-bold gradient-text mb-4">Notifications</h2>
      <ul>
        <li class="mb-2">Notification 1: Your item has been approved.</li>
        <li class="mb-2">Notification 2: Your item is due for return tomorrow.</li>
        <li class="mb-2">Notification 3: A new item has been added to the inventory.</li>
      </ul>
      <div class="flex justify-end">
        <button type="button" @click="showNotifications = false" class="bg-gray-500 text-white px-4 py-2 rounded">Close</button>
      </div>
    </div>
  </div>

  <!-- Logout Confirmation Modal -->
  <div x-show="confirmLogout" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
      <h2 class="text-xl font-bold mb-4">Confirm Logout</h2>
      <p class="mb-4">Are you sure you want to log out?</p>
      <div class="flex justify-end">
        <button type="button" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded" @click="confirmLogout = false">Cancel</button>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Log Out</button>
        </form>
      </div>
    </div>
  </div>
  <div class="flex flex-col flex-grow">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 flex items-center justify-between px-6 py-4 bg-white shadow-md z-10">
      <div class="flex items-center space-x-9">
          <img src="{{ asset('images/logo_text.png') }}" alt="HES Vault Logo" class="h-8">
        <button id="sidebarToggle" class="text-gray-600 focus:outline-none">
          <img id="menu-icon" src="{{ asset('svg/menu-hambuger-svgrepo-com.svg') }}" class="w-5 h-5 text-gray-400" alt="Menu">
        </button>
      </div>
      <div class="flex items-center space-x-4">
        <button class="relative" @click="showNotifications = !showNotifications">
        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5.6 9.45798V8.4C5.6 4.86538 8.46538 2 12 2C15.5346 2 18.4 4.86537 18.4 8.4V9.45798C18.4 11.7583 19.0649 14.0096 20.3146 15.9409L21 17H3L3.68539 15.9408C4.93512 14.0096 5.6 11.7583 5.6 9.45798Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M11 20.8889V20.8889C11.5344 21.4827 12.4656 21.4827 13 20.8889V20.8889" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
          <!-- ini span buat jumlah notip, disesuaiin sama jumlah notip user yang ada di db -->
          <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-600 text-white text-xs font-semibold rounded-full text-center">3</span>
        </button>
        <!-- poto propil user -->
        <div class="relative">
          <img src="{{ asset('images/profil.png') }}" alt="User Avatar" class="w-8 h-8 rounded-full border border-gray-300 cursor-pointer" @click="propil = !propil">
          <div x-show="propil" @click.away="propil = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
            <a href="#" @click.prevent="confirmLogout = true, propil = false" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Log Out</a>
          </div>
        </div>
      </div>
    </header>

    <div class="flex">
      <!-- Sidebar -->
      @yield('sidebar')

      <!-- Main Content -->
      <main id="mainContent" class="flex-1 ml-64 lg:ml-0 p-8 transition-width">
        <div class="bg-white p-6 rounded-lg shadow-md my-10">
          <h2 class="text-2xl font-bold text-blue-600 mb-4">@yield('heading')</h2>
          <p class="text-gray-600 mb-4">
            Selamat datang di halaman <span class="font-bold">@yield('headingDesc')</span>!
          </p>
          <p class="text-gray-600 mb-4">
            @yield('description')
          </p>
          <hr class="mb-4">

          @yield('content')
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

    @yield('scripts')
  </script>
</body>
</html>
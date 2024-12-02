<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #7983ff;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen" x-data="{ confirmLogout: false, propil: false, addTeam: false, newItem: false, showNotifications: false, showFilter: false, changeLang: false, documentationModal: false, rentId: null, documentationType: null }">
    <!-- Notifications Modal -->
    <div x-show="showNotifications" @click.away="showNotifications = false" class="fixed right-10 top-20 z-20">
        <div class="bg-white p-6 rounded-lg shadow-lg sm:w-1/2 md:w-full mb-8">
            <div class="flex justify-between items-center mb-4 gap-3">
                <h2 class="md:text-xl sm:text-sm font-bold gradient-text">Notifikasi</h2>
                <form method="POST" action="{{ route('notifications.readAllReg') }}">
                    @csrf
                    <button type="submit" class="text-blue-600 hover:underline sm:text-xs md:text-sm">
                        Tandai semua sudah dibaca
                    </button>
                </form>
            </div>
            <hr class="mb-4">
            <ul class="max-h-40 overflow-y-auto">
                @forelse (auth()->user()->unreadNotifications as $notification)
                    @if ($notification->type === 'App\Notifications\RentApprovedNotification')
                        <li class="mb-2">
                            <a href="{{ route('rent.details', ['id' => $notification->data['rent_id'], 'notification_id' => $notification->id]) }}"
                                class="text-blue-500 hover:underline">
                                {{ $notification->data['message'] }} ({{ $notification->data['rent_id'] }})
                            </a>
                            <div class="text-gray-600 text-xs">
                                {{ \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans() }}
                            </div>
                        </li>
                    @elseif ($notification->type === 'App\Notifications\RentRejectedNotification')
                        <li class="mb-2">
                            <a href="{{ route('rent.details', ['id' => $notification->data['rent_id'], 'notification_id' => $notification->id]) }}"
                                class="text-red-500 hover:underline">
                                {{ $notification->data['message'] }} ({{ $notification->data['rent_id'] }})
                            </a>
                            <div class="text-gray-600 text-xs">
                                {{ \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans() }}
                            </div>
                        </li>
                    @endif
                @empty
                    <li class="mb-2 text-center">
                        Tidak ada notifikasi baru
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="flex flex-col flex-grow">
        <!-- Header -->
        <header class="fixed top-0 left-0 right-0 flex items-center justify-between px-6 py-4 bg-white shadow-md z-10">
            <div class="flex items-center space-x-9">
                <img src="{{ asset('images/logo_text.png') }}" alt="HES Vault Logo" class="h-8">
                <button id="sidebarToggle" class="text-gray-600 focus:outline-none">
                    <img id="menu-icon" src="{{ asset('svg/menu-hambuger-svgrepo-com.svg') }}"
                        class="w-5 h-5 text-gray-400" alt="Menu">
                </button>
            </div>
            <div class="flex items-center space-x-5">
                <a class="relative" href="{{ route('cart.index') }}">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M2 1C1.44772 1 1 1.44772 1 2C1 2.55228 1.44772 3 2 3H3.21922L6.78345 17.2569C5.73276 17.7236 5 18.7762 5 20C5 21.6569 6.34315 23 8 23C9.65685 23 11 21.6569 11 20C11 19.6494 10.9398 19.3128 10.8293 19H15.1707C15.0602 19.3128 15 19.6494 15 20C15 21.6569 16.3431 23 18 23C19.6569 23 21 21.6569 21 20C21 18.3431 19.6569 17 18 17H8.78078L8.28078 15H18C20.0642 15 21.3019 13.6959 21.9887 12.2559C22.6599 10.8487 22.8935 9.16692 22.975 7.94368C23.0884 6.24014 21.6803 5 20.1211 5H5.78078L5.15951 2.51493C4.93692 1.62459 4.13696 1 3.21922 1H2ZM18 13H7.78078L6.28078 7H20.1211C20.6742 7 21.0063 7.40675 20.9794 7.81078C20.9034 8.9522 20.6906 10.3318 20.1836 11.3949C19.6922 12.4251 19.0201 13 18 13ZM18 20.9938C17.4511 20.9938 17.0062 20.5489 17.0062 20C17.0062 19.4511 17.4511 19.0062 18 19.0062C18.5489 19.0062 18.9938 19.4511 18.9938 20C18.9938 20.5489 18.5489 20.9938 18 20.9938ZM7.00617 20C7.00617 20.5489 7.45112 20.9938 8 20.9938C8.54888 20.9938 8.99383 20.5489 8.99383 20C8.99383 19.4511 8.54888 19.0062 8 19.0062C7.45112 19.0062 7.00617 19.4511 7.00617 20Z"
                            fill="#0F0F0F" />
                    </svg>
                    <span
                        class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-600 text-white text-xs font-semibold rounded-full text-center">{{ Cart::instance('cart')->count() }}</span>
                </a>
                <button class="relative" @click="showNotifications = !showNotifications">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.6 9.45798V8.4C5.6 4.86538 8.46538 2 12 2C15.5346 2 18.4 4.86537 18.4 8.4V9.45798C18.4 11.7583 19.0649 14.0096 20.3146 15.9409L21 17H3L3.68539 15.9408C4.93512 14.0096 5.6 11.7583 5.6 9.45798Z"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11 20.8889V20.8889C11.5344 21.4827 12.4656 21.4827 13 20.8889V20.8889"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <!-- ini span buat jumlah notip, disesuaiin sama jumlah notip user yang ada di db -->
                    <span
                        class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-600 text-white text-xs font-semibold rounded-full text-center">
                        {{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\RentApprovedNotification')->count() + auth()->user()->unreadNotifications->where('type', 'App\Notifications\RentRejectedNotification')->count() }}</span>
                </button>
                {{-- add button for change language --}}
                <div class="relative">
                    <!-- poto propil user -->
                    <div class="relative">
                        <img src="{{ asset('images/profil.png') }}" alt="User Avatar"
                            class="w-8 h-8 rounded-full border border-gray-300 cursor-pointer"
                            @click="propil = !propil">
                        <div x-show="propil" @click.away="propil = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
                            <a href="#" @click.prevent="confirmLogout = true, propil = false"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Keluar</a>
                        </div>
                    </div>
                </div>
        </header>

        <div class="flex">
            <!-- Sidebar -->
            @yield('sidebar')

            <!-- Logout Confirmation Modal -->
            <div x-show="confirmLogout"
                class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                    <h2 class="text-xl font-bold mb-4">Konfirmasi Logout</h2>
                    <p class="mb-4">
                        Apakah Anda yakin ingin logout?
                    </p>
                    <div class="flex justify-end">
                        <button type="button" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded"
                            @click="confirmLogout = false">Batal</button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main id="mainContent" class="flex-1 ml-64 lg:ml-0 p-8 transition-width">
                <div class="bg-white p-6 rounded-lg shadow-md my-10">
                    <h2 class="text-2xl font-bold text-blue-600 mb-4">@yield('heading')</h2>
                    <!-- Breadcrumb Section -->
                    @if (View::hasSection('breadcrumb'))
                        <nav class="bg-white border-b pb-3">
                            @yield('breadcrumb')
                        </nav>
                    @endif
                    @if (View::hasSection('headingDesc'))
                        <p class="text-gray-600 mb-4">
                            Selamat datang di halaman <span class="font-bold">@yield('headingDesc')</span>!
                        </p>
                        <p class="text-gray-600 mb-4">
                            @yield('description')
                        </p>
                        @if (View::hasSection('warnings'))
                            @yield('warnings')
                        @endif
                        <hr class="mb-4">
                    @endif
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

    @yield('modals')
</body>

</html>

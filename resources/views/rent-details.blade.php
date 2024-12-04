@extends('layouts.dashboard-admin')

@section('title', 'Rincian Peminjaman')

@section('heading', 'Rincian Peminjaman')
@section('sidebar')
    <aside id="sidebar" class="transition-width w-64 h-max fixed top-16 bottom-16 lg:relative p-2">
        <div class="bg-white rounded p-2">
            <nav class="space-y-2 bg-white rounded p-2">
                <a href="{{ route('dashboard-admin-items') }}"
                    class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                    <span class="sidebar-text ml-3">Kelola Pengguna</span>
                </a>
            </nav>
        </div>
    </aside>
@endsection

@section('breadcrumb')
    <ol class="flex text-sm text-gray-500">
        <li><a href="{{ route('dashboard-admin-rent') }}" class="hover:underline">Status Peminjaman</a></li>
        <li class="mx-2">/</li>
        <li class="font-bold">
            {{ $rent->id }}
        </li>
    </ol>
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
    <div class="max-w-4xl mx-auto bg-white p-4 md:p-8 rounded-lg shadow-lg my-8">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">
            Rincian Peminjaman #{{ $rent->id }} oleh {{ $rent->user->name }}
        </h2>
        <!-- Rent Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
            <div class="space-y-4">
                <!-- Display rent details -->
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <span class="w-full md:w-1/3 font-semibold">ID:</span>
                    <span class="w-full md:w-2/3">{{ $rent->user_id }}</span>
                </div>
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <span class="w-full md:w-1/3 font-semibold">NIM/NIP:</span>
                    <span class="w-full md:w-2/3">{{ $rent->nim_nip }}</span>
                </div>
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <span class="w-full md:w-1/3 font-semibold">No. WA:</span>
                    <span class="w-fit">
                        <a href="https://wa.me/62{{ $rent->phone }}">
                            <div class="flex items-center border p-2 rounded-md">
                                <svg class="w-7 h-7 mr-2" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16 31C23.732 31 30 24.732 30 17C30 9.26801 23.732 3 16 3C8.26801 3 2 9.26801 2 17C2 19.5109 2.661 21.8674 3.81847 23.905L2 31L9.31486 29.3038C11.3014 30.3854 13.5789 31 16 31ZM16 28.8462C22.5425 28.8462 27.8462 23.5425 27.8462 17C27.8462 10.4576 22.5425 5.15385 16 5.15385C9.45755 5.15385 4.15385 10.4576 4.15385 17C4.15385 19.5261 4.9445 21.8675 6.29184 23.7902L5.23077 27.7692L9.27993 26.7569C11.1894 28.0746 13.5046 28.8462 16 28.8462Z"
                                        fill="#BFC8D0" />
                                    <path
                                        d="M28 16C28 22.6274 22.6274 28 16 28C13.4722 28 11.1269 27.2184 9.19266 25.8837L5.09091 26.9091L6.16576 22.8784C4.80092 20.9307 4 18.5589 4 16C4 9.37258 9.37258 4 16 4C22.6274 4 28 9.37258 28 16Z"
                                        fill="url(#paint0_linear_87_7264)" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 18.5109 2.661 20.8674 3.81847 22.905L2 30L9.31486 28.3038C11.3014 29.3854 13.5789 30 16 30ZM16 27.8462C22.5425 27.8462 27.8462 22.5425 27.8462 16C27.8462 9.45755 22.5425 4.15385 16 4.15385C9.45755 4.15385 4.15385 9.45755 4.15385 16C4.15385 18.5261 4.9445 20.8675 6.29184 22.7902L5.23077 26.7692L9.27993 25.7569C11.1894 27.0746 13.5046 27.8462 16 27.8462Z"
                                        fill="white" />
                                    <path
                                        d="M12.5 9.49989C12.1672 8.83131 11.6565 8.8905 11.1407 8.8905C10.2188 8.8905 8.78125 9.99478 8.78125 12.05C8.78125 13.7343 9.52345 15.578 12.0244 18.3361C14.438 20.9979 17.6094 22.3748 20.2422 22.3279C22.875 22.2811 23.4167 20.0154 23.4167 19.2503C23.4167 18.9112 23.2062 18.742 23.0613 18.696C22.1641 18.2654 20.5093 17.4631 20.1328 17.3124C19.7563 17.1617 19.5597 17.3656 19.4375 17.4765C19.0961 17.8018 18.4193 18.7608 18.1875 18.9765C17.9558 19.1922 17.6103 19.083 17.4665 19.0015C16.9374 18.7892 15.5029 18.1511 14.3595 17.0426C12.9453 15.6718 12.8623 15.2001 12.5959 14.7803C12.3828 14.4444 12.5392 14.2384 12.6172 14.1483C12.9219 13.7968 13.3426 13.254 13.5313 12.9843C13.7199 12.7145 13.5702 12.305 13.4803 12.05C13.0938 10.953 12.7663 10.0347 12.5 9.49989Z"
                                        fill="white" />
                                    <defs>
                                        <linearGradient id="paint0_linear_87_7264" x1="26.5" y1="7"
                                            x2="4" y2="28" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#5BD066" />
                                            <stop offset="1" stop-color="#27B43E" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <span class="text-green-500 font-semibold">Chat via WhatsApp</span>
                            </div>
                        </a>
                    </span>
                </div>
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <span class="w-full md:w-1/3 font-semibold">Tanggal Pemesanan:</span>
                    <span class="w-full md:w-2/3">{{ $rent->order_date }}</span>
                </div>
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <span class="w-full md:w-1/3 font-semibold">Tanggal Mulai:</span>
                    <span class="w-full md:w-2/3">{{ $rent->start_date }}</span>
                </div>
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <span class="w-full md:w-1/3 font-semibold">Tanggal Selesai:</span>
                    <span class="w-full md:w-2/3">{{ $rent->end_date }}</span>
                </div>
                @if ($rent->returned_date)
                    <div class="flex flex-col md:flex-row items-start md:items-center">
                        <span class="w-full md:w-1/3 font-semibold">Tanggal Pengembalian:</span>
                        <span class="w-full md:w-2/3">{{ $rent->returned_date }}</span>
                    </div>
                @endif
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <span class="w-full md:w-1/3 font-semibold">Total Hari:</span>
                    <span class="w-full md:w-2/3">
                        @php
                            $start = new DateTime($rent->start_date);
                            $end = new DateTime($rent->end_date);
                            $interval = $start->diff($end);
                            echo $interval->days;
                        @endphp
                    </span>
                </div>
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <span class="w-full md:w-1/3 font-semibold">Total Harga:</span>
                    <span class="w-full md:w-2/3">
                        @if (!$rent->user->hasType('Regular'))
                            Free
                        @else
                            Rp {{ number_format($rent->total_cost, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                @if ($rent->user->hasType('Regular'))
                    <div class="flex flex-col md:flex-row items-start md:items-center">
                        <span class="w-full md:w-1/3 font-semibold">Status Pembayaran:</span>
                        <span class="w-full md:w-2/3">
                            @if ($rent->payment_status == 'paid')
                                <span class="bg-green-500 text-white px-2 py-1 rounded-lg">Sudah dibayar</span>
                            @else
                                <span class="bg-red-500 text-white px-2 py-1 rounded-lg">Belum dibayar</span>
                            @endif
                        </span>
                    </div>
                @endif
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <span class="w-full md:w-1/3 font-semibold">Status Peminjaman:</span>
                    <span class="w-full md:w-2/3">
                        <span
                            class="inline-block px-2 py-1 text-white rounded-lg
                            @if ($rent->order_status == 'cancelled') bg-gray-500
                            @elseif($rent->order_status == 'rejected') bg-red-500
                            @elseif($rent->order_status == 'returned') bg-blue-500
                            @elseif($rent->order_status == 'approved') bg-green-500
                            @elseif($rent->order_status == 'active') bg-blue-500
                            @elseif($rent->order_status == 'overdue') bg-red-500
                            @elseif($rent->order_status == 'waiting') bg-yellow-500 @endif">
                            {{ $rent->order_status }}
                        </span>
                    </span>
                </div>
            </div>
            <div>
                <p class="font-bold mb-2">Barang:</p>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach ($rent->items as $item)
                        @if ($rent->user->hasType('Regular'))
                            <li>{{ $item->product->name }}: Rp {{ number_format($item->product->price, 0, ',', '.') }} x
                                {{ $item->quantity }} buah
                                x
                                @php echo ceil($interval->days/7); @endphp minggu</li>
                        @else
                            <li>{{ $item->product->name }} x{{ $item->quantity }}</li>
                        @endif
                    @endforeach
                </ul>
                <div class="mt-4">
                    <p class="font-bold">Catatan:</p>
                    <p class="text-gray-700">{{ $rent->notes }}</p>
                </div>
            </div>
        </div>

        <!-- Images -->
        <div
            class="grid grid-cols-1 md:grid-cols-{{ $rent->before_documentation && $rent->after_documentation ? '3' : '2' }} gap-6 mt-8">
            <div class="text-center">
                <p class="font-semibold mb-2">Foto KTM:</p>
                <img src="{{ url('/admin/rent/' . $rent->id . '/ktm-image') }}" alt="KTM Image"
                    class="w-full h-auto rounded-lg shadow">
            </div>
            @if ($rent->before_documentation)
                <div class="text-center">
                    <p class="font-semibold mb-2">
                        Dokumentasi Sebelum Peminjaman:
                    </p>
                    <img src="{{ url('/admin/rent/' . $rent->id . '/before-documentation') }}" alt="Before Documentation"
                        class="w-full h-auto rounded-lg shadow">
                </div>
            @endif
            @if ($rent->after_documentation)
                <div class="text-center">
                    <p class="font-semibold mb-2">
                        Dokumentasi Setelah Peminjaman:
                    </p>
                    <img src="{{ url('/admin/rent/' . $rent->id . '/after-documentation') }}" alt="After Documentation"
                        class="w-full h-auto rounded-lg shadow">
                </div>
            @endif
        </div>

        @if ($rent->order_status == 'waiting')
            <!-- Approve and Reject Buttons -->
            <div class="flex flex-col md:flex-row justify-end space-y-4 md:space-y-0 md:space-x-4 mt-8">
                <form action="{{ route('rent.approve', $rent) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
                        Terima
                    </button>
                </form>
                <form action="{{ route('rent.reject', $rent) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
                        Tolak
                    </button>
                </form>
            </div>
        @elseif (
            ($rent->order_status == 'active' || $rent->order_status == 'overdue') &&
                $rent->before_documentation_url &&
                $rent->after_documentation_url)
            <!-- Return Button -->
            <div class="flex flex-col md:flex-row justify-end space-y-4 md:space-y-0 md:space-x-4 mt-8">
                <form action="{{ route('rent.return', $rent) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
                        User ini telah mengembalikan barang
                    </button>
                </form>
                <!-- Reset Documentation Picture because they're not valid -->
                <form action="{{ route('rent.invalid', $rent) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
                        Dokumentasi tidak valid
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection

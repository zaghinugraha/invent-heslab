@extends('layouts.dashboard-admin')

@php
    $currentUserId = Auth::id();
@endphp

@section('title', 'Kelola Pengguna')

@section('heading', 'Kelola Pengguna')
@section('headingDesc', 'Kelola Pengguna')
@section('description', 'Anda dapat mengubah peran pengguna dengan memilih peran yang sesuai dari daftar dropdown.')

@section('sidebar')
    <aside id="sidebar" class="transition-width w-64 h-full fixed top-16 bottom-16 lg:relative lg:h-screen p-2">
        <div class="bg-white rounded p-2">
            <nav class="space-y-2 bg-white rounded p-2">
                <a href="{{ route('dashboard-admin-items') }}"
                   class="flex items-center space-x-2 text-gray-700 rounded hover:bg-gray-100 p-2">
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
                   class="flex items-center space-x-2 text-white bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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
    <div class="flex justify-between" x-data="{ addTeam: false }">
        <div class="w-full mb-4 flex justify-end">
            <form action="{{ route('users.index') }}" method="GET" class="flex w-full">
                <input type="text" name="search" placeholder="Cari pengguna..."
                       class="w-full px-4 py-2 border rounded-l-lg focus:outline-none"
                       value="{{ request()->query('search') }}" />

                <select name="team_id" onchange="this.form.submit()"
                        class="px-4 py-2 border-t border-b border-l-none focus:outline-none">
                    <option value="">Semua Role</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team }}" {{ $selectedTeam == $team ? 'selected' : '' }}>
                            {{ $team }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-gray-300 px-4 py-2 rounded-r-lg">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M21.707 20.293l-6.388-6.388A7.455 7.455 0 0018 10.5a7.5 7.5 0 10-7.5 7.5c1.8 0 3.464-.63 4.904-1.681l6.388 6.388a1 1 0 001.415-1.414zM10.5 16a5.5 5.5 0 110-11 5.5 5.5 0 010 11z">
                        </path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full table-auto border">
            @if ($users->isEmpty())
                <div class="text-center py-4">
                    <p class="text-gray-600 italic">Tidak ada data yang tersedia</p>
                </div>
            @else
                <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Role</th>
                    <!-- Additional headers -->
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 text-center">
                        <td class="px-4 py-2 border">{{ $user->id }}</td>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border">
                            <form action="{{ route('users.updateRole', $user->id) }}" method="POST"
                                  class="role-change-form" data-user-id="{{ $user->id }}">
                                @csrf
                                @method('PUT')
                                <select name="role"
                                        class="role-select border rounded p-2 focus:outline-none min-w-fit text-center"
                                        data-original-value="{{ $user->currentTeam->name ?? 'Regular' }}">
                                    @foreach (['Admin', 'Dosen', 'Koordinator', 'Research Group', 'Study Group', 'Regular'] as $role)
                                        <option value="{{ $role }}"
                                            {{ ($user->currentTeam->name ?? 'Regular') == $role ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentUserId = {{ $currentUserId }};

            document.querySelectorAll('.role-change-form').forEach(form => {
                const select = form.querySelector('.role-select');
                const userId = parseInt(form.getAttribute('data-user-id'));

                select.addEventListener('change', function(event) {
                    if (userId === currentUserId) {
                        event.preventDefault();
                        const confirmed = confirm('Are you sure you want to change your own role?');
                        if (confirmed) {
                            form.submit();
                        } else {
                            // Revert to previous value
                            select.value = select.getAttribute('data-original-value');
                        }
                    } else {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection

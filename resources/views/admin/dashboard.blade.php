@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <!-- Section: Daftar Toko dan Makanan -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Daftar Toko dan Makanan</h2>

        <!-- Add Toko Button -->
        <div class="mt-6 mb-8">
            <a href="{{ route('admin.tambahTokoForm') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Tambah Toko</a>
        </div>

        <!-- Add Makanan Button -->
        <div class="mt-6 mb-8">
            <a href="{{ route('admin.makanan.tambah') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Tambah Makanan</a>
        </div>

        <!-- Daftar Toko -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Toko</h3>
            <table class="w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="p-4 text-left border-b">ID Toko</th>
                        <th class="p-4 text-left border-b">Nama Toko</th>
                        <th class="p-4 text-left border-b">Deskripsi Toko</th>
                        <th class="p-4 text-left border-b">Makanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stores as $store)
                        <tr class="border-b">
                            <td class="p-4">{{ $store->id }}</td>
                            <td class="p-4">{{ $store->name }}</td>
                            <td class="p-4">{{ $store->description }}</td>
                            <td class="p-4">
                                <ul>
                                    @foreach ($store->makanan as $item)
                                        <li class="mb-2">{{ $item->nama_makanan }} - Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            <form action="{{ route('admin.hapusMakanan', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Hapus</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section: Manage Users -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Manage Users</h2>
        <table class="w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">Username</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Role</th>
                    <th class="p-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="p-4">{{ $user->id }}</td>
                        <td class="p-4">{{ $user->username }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">{{ $user->role }}</td>
                        <td class="p-4">
                            <a href="{{ route('admin.editUserForm', $user->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a> |
                            <form action="{{ route('admin.hapusUser', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6 mb-8">
            <a href="{{ route('admin.tambahUserForm') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Tambah User</a>
        </div>
    </div>

    <!-- Section: Log Activities -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Log Aktivitas User</h2>
        <p class="text-gray-600">Fitur log aktivitas user dapat diimplementasikan di sini.</p>
        <a href="{{ route('admin.activity_log') }}" class="text-blue-500 hover:text-blue-700">Lihat Log Aktivitas</a>
    </div>
</div>
@endsection

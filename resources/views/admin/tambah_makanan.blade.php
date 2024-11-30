{{-- resources/views/admin/tambah_makanan.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Makanan')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Tambah Makanan</h1>

    <!-- Menampilkan pesan jika ada kesalahan atau keberhasilan -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.makanan.tambah') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="nama_makanan" class="block text-sm font-medium text-gray-700">Nama Makanan</label>
            <input type="text" id="nama_makanan" name="nama_makanan" value="{{ old('nama_makanan') }}" required
                class="mt-1 p-2 w-full border rounded-md @error('nama_makanan') border-red-500 @enderror">
            @error('nama_makanan')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="3"
                class="mt-1 p-2 w-full border rounded-md @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" id="harga" name="harga" value="{{ old('harga') }}" required
                class="mt-1 p-2 w-full border rounded-md @error('harga') border-red-500 @enderror">
            @error('harga')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="store_id" class="block text-sm font-medium text-gray-700">Pilih Toko</label>
            <select id="store_id" name="store_id" required class="mt-1 p-2 w-full border rounded-md @error('store_id') border-red-500 @enderror">
                @foreach ($stores as $store)
                    <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
            @error('store_id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>
            <input type="file" id="gambar" name="gambar" class="mt-1 p-2 w-full border rounded-md">
            @error('gambar')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
            Tambah Makanan
        </button>
    </form>
</div>
@endsection

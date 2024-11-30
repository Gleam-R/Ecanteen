@extends('layouts.app')

@section('title', 'Makanan di Toko')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Makanan di {{ $store->name }}</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($store->makanan as $makanan)
            <div class="border p-4 rounded-lg shadow-md">
                <img src="{{ asset('storage/' . $makanan->gambar) }}" alt="{{ $makanan->nama_makanan }}" class="w-full h-48 object-cover mb-4">
                <h3 class="font-semibold text-lg">{{ $makanan->nama_makanan }}</h3>
                <p>{{ Str::limit($makanan->deskripsi, 100) }}</p>
                <p class="font-bold text-blue-500">Rp {{ number_format($makanan->harga, 0, ',', '.') }}</p>
                <form action="{{ route('user.rating', $makanan->id) }}" method="POST" class="mt-2">
                @csrf
                <label for="rating" class="mr-2">Berikan Rating:</label>
                <select name="rating" id="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white py-1 px-4 rounded-md hover:bg-blue-600 mt-2">Berikan Rating</button>
            </form>

            <!-- Komentar Section -->
            <form action="{{ route('user.komentar', $makanan->id) }}" method="POST" class="mt-4">
                @csrf
                <label for="komentar" class="block">Komentar:</label>
                <textarea name="komentar" id="komentar" rows="4" class="w-full p-2 border rounded-md" required></textarea>
                <button type="submit" class="bg-green-500 text-white py-1 px-4 rounded-md hover:bg-green-600 mt-2">Kirim Komentar</button>
            </form>
                <form action="{{ route('user.cart.add', $makanan->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md mt-4 hover:bg-blue-600">Tambah ke Keranjang</button>
                </form>
            </div>
        @endforeach
    </div>
        <!-- Tampilkan Total Keranjang -->
        <div class="mt-6">
        <a href="{{ route('user.cart') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
            Lihat Keranjang
        </a>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Review Order')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Review Order</h1>

    @if (!empty($cart))
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($cart as $makananId => $details)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <!-- Gambar Makanan -->
                    @if(isset($details['image']) && file_exists(public_path('storage/' . $details['image'])))
                        <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-full h-32 object-cover rounded-md mb-4">
                    @else
                        <img src="{{ asset('images/default-placeholder.png') }}" alt="Gambar Tidak Tersedia" class="w-full h-32 object-cover rounded-md mb-4">
                    @endif

                    <!-- Detail Makanan -->
                    <h2 class="text-lg font-semibold">{{ $details['name'] }}</h2>
                    <p class="text-gray-600">Jumlah: {{ $details['quantity'] }}</p>
                    <p class="text-gray-600">Harga: Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <p class="text-lg font-semibold">Total Harga: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>

            <!-- Form untuk memilih metode pembayaran dan melanjutkan ke checkout -->
            <form action="{{ route('user.checkout') }}" method="POST" class="mt-6">
                @csrf
                <div class="mb-4">
                    <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="w-full mt-2 p-2 border border-gray-300 rounded-md">
                        <option value="cod">Cash on Delivery</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>

                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600">
                    Proses Pembayaran
                </button>
            </form>
        </div>
    @else
        <p class="text-center text-gray-500 mt-6">Keranjang belanja kosong.</p>
    @endif
</div>
@endsection

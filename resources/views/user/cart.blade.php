@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>

    @if (session()->has('cart') && count(session('cart')) > 0)
        <!-- Grid Layout untuk Cart -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach (session('cart') as $makananId => $details)
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

                    <!-- Tombol Hapus -->
                    <form action="{{ route('user.removeFromCart', $makananId) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Tombol Checkout -->
        <form action="{{ route('user.reviewOrder') }}" method="GET" class="mt-6">
            @csrf
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                Checkout
            </button>
        </form>
    @else
        <!-- Jika Keranjang Kosong -->
        <p class="text-center text-gray-500 mt-6">Kosong.. Seperti dompet mu</p>
    @endif
</div>
@endsection

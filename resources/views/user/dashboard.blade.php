@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Selamat datang di Dashboard User</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($stores as $store)
            <div class="border p-4 rounded-lg shadow-md">
                <h2 class="font-bold text-xl">{{ $store->name }}</h2>
                <p>{{ Str::limit($store->description, 100) }}</p>
                <a href="{{ route('user.makanan.by.store', $store->id) }}" class="text-blue-500 hover:underline">Lihat Makanan</a>
            </div>
        @endforeach
    </div>
</div>
@endsection

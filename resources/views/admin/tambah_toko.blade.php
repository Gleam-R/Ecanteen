@extends('layouts.app')

@section('title', 'Tambah Toko')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Tambah Toko</h1>

    <form action="{{ route('admin.tambahToko') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold">Nama Toko</label>
            <input type="text" name="name" id="name" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold">Deskripsi</label>
            <textarea name="description" id="description" class="w-full p-2 border rounded"></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Tambah Toko</button>
    </form>
</div>
@endsection

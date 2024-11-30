@extends('layouts.app')

@section('title', 'Log Aktivitas User')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Log Aktivitas User</h1>

    <!-- Table to Display Log Activities -->
    <div class="mb-8">
        <table class="w-full bg-white rounded-lg shadow-md">
            <thead>
                <tr>
                    <th class="p-4 text-left">ID User</th>
                    <th class="p-4 text-left">Nama User</th>
                    <th class="p-4 text-left">Aktivitas</th>
                    <th class="p-4 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logActivities as $log)
                    <tr class="border-b">
                        <td class="p-4">{{ $log->user_id }}</td>
                        <td class="p-4">{{ $log->user->username }}</td>
                        <td class="p-4">{{ $log->aktivitas }}</td>
                        <td class="p-4">{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

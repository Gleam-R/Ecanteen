<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Use Vite for assets -->
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <header class="bg-blue-500 text-white shadow-md">
            <nav class="container mx-auto flex justify-between items-center py-4 px-6">
                <div>
                    <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard') }}" class="text-lg font-bold">
                        UMB-Canteen
                    </a>
                </div>
                <div>
                    <ul class="flex space-x-4">
                        @if(Auth::user()->role === 'admin')
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('user.dashboard') }}" class="hover:underline">Home</a>
                            </li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="hover:underline">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto p-6 flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-200 text-gray-700 text-center py-4">
            <p>&copy; 2024 UMB-Canteen. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

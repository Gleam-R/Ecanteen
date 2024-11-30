<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Use Vite for assets -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-sm w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Login</h2>

        @if(session('error'))
            <div class="mb-4 text-red-500">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-md" required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 p-2 w-full border rounded-md" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Login</button>
        </form>
    </div>
</body>
</html>

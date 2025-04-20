<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">MyAdmin</a>
            <ul class="flex space-x-4 text-gray-700">
                <li><a href="{{ route('dashboard') }}" class="hover:text-blue-500">Dashboard</a></li>
                <li><a href="{{ route('customers.index') }}" class="hover:text-blue-500">Customers</a></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-blue-500">Products</a></li>
                <li><a href="#" class="hover:text-blue-500">Logout</a></li>
            </ul>
        </div>
    </nav>
    <!-- Main Content -->
    <main class="py-8">
        @yield('content')
    </main>
    <!-- Footer -->
    <footer class="text-center py-4 text-sm text-gray-500">
        © {{ date('Y') }} MyAdmin. All rights reserved.
    </footer>
    @stack('scripts')
</body>
</html>

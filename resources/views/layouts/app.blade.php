<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Admin Panel'))</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">MyAdmin</a>
            <ul class="flex space-x-4 text-gray-700">
                <li><a href="{{ route('dashboard') }}" class="hover:text-blue-500">{{ __('Dashboard') }}</a></li>
                <li><a href="{{ route('customers.index') }}" class="hover:text-blue-500">{{ __('Customers') }}</a></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-blue-500">{{ __('Products') }}</a></li>
            </ul>
            <!-- Language Selector -->
            <select name="selectLocale" id="selectLocale" class="border rounded px-2 py-1">
                <option @if(app()->getLocale() == 'ar') selected @endif value="ar">العربية</option>
                <option @if(app()->getLocale() == 'fr') selected @endif value="fr">Français</option>
                <option @if(app()->getLocale() == 'en') selected @endif value="en">English</option>
                <option @if(app()->getLocale() == 'es') selected @endif value="es">Español</option>
            </select>
        </div>
    </nav>
    <!-- Main Content -->
    <main class="py-8">
        @yield('content')
    </main>
    <!-- Footer -->
    <footer class="text-center py-4 text-sm text-gray-500">
        © {{ date('Y') }} MyAdmin. {{ __('All rights reserved.') }}
    </footer>
    @stack('scripts')

    <script>
    $(document).ready(function() {
        $("#selectLocale").on('change', function(){
            var locale = $(this).val();
            window.location.href = "/changeLocale/" + locale;
        });
    });
    </script>
</body>
</html>

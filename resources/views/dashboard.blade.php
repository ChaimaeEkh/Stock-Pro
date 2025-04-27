@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    @if(session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if(session('session_status'))
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
            {{ session('session_status') }}
        </div>
    @endif

    @if(session('avatar_status'))
        <div class="bg-purple-100 border-l-4 border-purple-500 text-purple-700 p-4 mb-6" role="alert">
            {{ session('avatar_status') }}
        </div>
    @endif

    <!-- Logout -->
    <div class="flex justify-end mb-6">
        <a href="{{ url('/') }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
            <i class="fas fa-sign-out-alt mr-2"></i>Logout
        </a>
    </div>

    <!--  Avatar -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">Your Avatar</h2>

        <div class="flex flex-col md:flex-row items-start gap-8">
            <div class="flex-shrink-0">
                <div class="w-40 h-40 rounded-full overflow-hidden bg-gray-200 border-4 border-white shadow-lg">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar of {{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-500">
                            <i class="fas fa-user text-4xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-grow">
                <form action="{{ route('upload.avatar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">Choose a new avatar</label>
                        <input type="file" name="avatar" id="avatar"
                            class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100"
                            accept="image/*"
                            required>
                        @error('avatar')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition duration-200">
                            <i class="fas fa-upload mr-2"></i>Upload
                        </button>
                    </div>

                    <p class="text-xs text-gray-500 mt-2">Accepted formats: JPG, PNG, GIF. Maximum size: 2MB.</p>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!--  Cookie -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Name (stored in cookie)</h2>

            @if($userName)
                <p class="text-gray-700 mb-4">Welcome, <span class="font-semibold">{{ $userName }}</span>!</p>
            @endif

            <form action="{{ route('save.name') }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-grow">
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="nom" id="nom" value="{{ $userName ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-save mr-2"></i>{{ $userName ? 'Update' : 'Save' }}
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">This name will be remembered even after closing the browser (cookie).</p>
            </form>
        </div>

        <!--  Session -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Name (stored in session)</h2>

            @if($sessionName)
                <p class="text-gray-700 mb-4">Hello, <span class="font-semibold">{{ $sessionName }}</span>!</p>
            @endif

            <form action="{{ route('save.session.name') }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-grow">
                        <label for="session_nom" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="session_nom" id="session_nom" value="{{ $sessionName ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition duration-200">
                        <i class="fas fa-save mr-2"></i>{{ $sessionName ? 'Update' : 'Save' }}
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">This name will be lost when closing the browser (session).</p>
            </form>
        </div>
    </div>

    <p class="text-gray-500 mb-6">Choose an action below:</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('customers.index') }}" class="dashboard-card">
            <div class="icon-box bg-blue-100 text-blue-600">
                <i class="fas fa-users"></i>
            </div>
            <span>List of Customers</span>
        </a>
        <a href="{{ route('suppliers.index') }}" class="dashboard-card">
            <div class="icon-box bg-green-100 text-green-600">
                <i class="fas fa-truck"></i>
            </div>
            <span>List of Suppliers</span>
        </a>
        <a href="{{ route('products.index') }}" class="dashboard-card">
            <div class="icon-box bg-yellow-100 text-yellow-600">
                <i class="fas fa-boxes"></i>
            </div>
            <span>List of Products</span>
        </a>
        <a href="{{ route('products.byCategory') }}" class="dashboard-card">
            <div class="icon-box bg-purple-100 text-purple-600">
                <i class="fas fa-tags"></i>
            </div>
            <span>Products by Category</span>
        </a>
        <a href="{{ route('orders.byCustomer') }}" class="dashboard-card">
            <div class="icon-box bg-red-100 text-red-600">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <span>Orders by Customer</span>
        </a>
    </div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
    .dashboard-card {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: box-shadow 0.3s ease;
        margin-bottom: 1rem;
        gap: 1rem;
    }
    .dashboard-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .icon-box {
        padding: 1rem;
        border-radius: 9999px;
        font-size: 1.25rem;
    }
</style>
@endpush

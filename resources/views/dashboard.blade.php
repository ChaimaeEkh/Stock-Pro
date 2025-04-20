@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
    <p class="text-gray-500 mb-6">Welcome to your dashboard. Choose an action below:</p>

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
<!-- Font Awesome for icons -->
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

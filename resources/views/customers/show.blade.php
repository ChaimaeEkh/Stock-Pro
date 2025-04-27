@extends('layouts.app')
@section('title', 'Customer Details')
@section('content')
<div class="container mx-auto px-6">
    <div class="mb-6">
        <a href="{{ route('customers.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i> Back to Customers
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Customer Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('customers.edit', $customer->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <button onclick="confirmDelete({{ $customer->id }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-4">Basic Information</h2>
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Customer ID</p>
                    <p class="font-medium">{{ $customer->id }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Full Name</p>
                    <p class="font-medium">{{ $customer->first_name . ' ' . $customer->last_name }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium">{{ $customer->email }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Phone</p>
                    <p class="font-medium">{{ $customer->phone ?? 'N/A' }}</p>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-4">Orders</h2>
                @if($customer->orders && $customer->orders->count() > 0)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-medium">Total Orders: {{ $customer->orders->count() }}</p>
                        <p class="text-sm text-gray-600 mt-2">Latest Order Date: {{ $customer->orders->sortByDesc('created_at')->first()->created_at->format('Y-m-d') }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('orders.byCustomer') }}?customer_id={{ $customer->id }}" class="text-blue-600 hover:text-blue-800">
                            View All Orders <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @else
                    <p class="text-gray-500">No orders for this customer.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteConfirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <div class="mb-4">
            <h2 class="text-xl font-bold">Confirm Delete</h2>
            <p class="text-gray-600 mt-2">Are you sure you want to delete this customer? This action cannot be undone.</p>
        </div>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-2">
                <button type="button" id="cancelDelete" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
@endpush

@push('scripts')
<script>
    // Delete Modal
    const deleteModal = document.getElementById('deleteConfirmModal');
    const cancelDeleteBtn = document.getElementById('cancelDelete');
    const deleteForm = document.getElementById('deleteForm');

    function confirmDelete(customerId) {
        deleteForm.action = `/customers/${customerId}`;
        deleteModal.classList.remove('hidden');
    }

    cancelDeleteBtn.addEventListener('click', () => {
        deleteModal.classList.add('hidden');
    });
</script>
@endpush

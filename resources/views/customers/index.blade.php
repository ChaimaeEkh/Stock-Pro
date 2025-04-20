@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="container mx-auto px-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">List of Customers</h1>
        <button id="openAddModal" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Customer
        </button>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <form action="{{ route('customers.index') }}" method="GET" class="flex">
            <div class="relative flex-grow">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by customer name..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @if(request('search'))
                    <a href="{{ route('customers.index') }}" class="absolute right-0 top-0 h-full flex items-center px-3 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-lg">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $customer->id }}</td>
                        <td class="px-4 py-2">{{ $customer->first_name . ' ' . $customer->last_name }}</td>
                        <td class="px-4 py-2">{{ $customer->email }}</td>
                        <td class="px-4 py-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('customers.show', $customer->id) }}" class="bg-blue-100 text-blue-600 px-2 py-1 rounded hover:bg-blue-200">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded hover:bg-yellow-200">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button
                                    onclick="confirmDelete({{ $customer->id }})"
                                    class="bg-red-100 text-red-600 px-2 py-1 rounded hover:bg-red-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if($customers->count() == 0)
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            @if(request('search'))
                                No customers found matching "{{ request('search') }}".
                            @else
                                No customers found.
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination with search parameter preserved -->
    <div class="mt-6">
        @if(request('search'))
            {{ $customers->appends(['search' => request('search')])->links() }}
        @else
            {{ $customers->links() }}
        @endif
    </div>
</div>

<!-- Add Customer Modal -->
<div id="addCustomerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Add New Customer</h2>
            <button id="closeAddModal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="first_name" class="block text-gray-700 font-medium mb-2">First Name</label>
                <input type="text" id="first_name" name="first_name" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-gray-700 font-medium mb-2">Last Name</label>
                <input type="text" id="last_name" name="last_name" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone</label>
                <input type="text" id="phone" name="phone"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" id="cancelAddCustomer" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Save Customer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
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
<style>
    /* Styles personnalisés pour la pagination */
    nav[aria-label="Pagination Navigation"] {
        @apply flex justify-center mt-4;
    }

    .pagination {
        @apply flex rounded-md list-none;
    }

    .page-item {
        @apply mx-1;
    }

    .page-link, .page-item span {
        @apply px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded hover:bg-gray-50 flex items-center;
    }

    .page-item.active .page-link {
        @apply bg-blue-500 text-white border-blue-500;
    }

    .page-item.disabled span {
        @apply bg-gray-100 text-gray-400 cursor-not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add Customer Modal
    const addModal = document.getElementById('addCustomerModal');
    const openAddModalBtn = document.getElementById('openAddModal');
    const closeAddModalBtn = document.getElementById('closeAddModal');
    const cancelAddBtn = document.getElementById('cancelAddCustomer');

    openAddModalBtn.addEventListener('click', () => {
        addModal.classList.remove('hidden');
    });

    closeAddModalBtn.addEventListener('click', () => {
        addModal.classList.add('hidden');
    });

    cancelAddBtn.addEventListener('click', () => {
        addModal.classList.add('hidden');
    });

    // Delete Confirmation Modal
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

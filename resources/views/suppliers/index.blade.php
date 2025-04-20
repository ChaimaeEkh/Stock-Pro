@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-2xl font-bold mb-6">List of Suppliers</h1>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $supplier->id }}</td>
                        <td class="px-4 py-2">{{ $supplier->first_name . ' ' . $supplier->last_name }}</td>
                        <td class="px-4 py-2">{{ $supplier->phone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

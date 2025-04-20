@extends('layouts.app')

@section('title', 'Products by Category')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-2xl font-bold mb-6">Products by Category</h1>

    @foreach ($categories as $category)
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">{{ $category->name }}</h2>

            @if ($category->products->isEmpty())
                <p class="text-gray-500">No products in this category.</p>
            @else
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category->products as $product)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $product->id }}</td>
                                    <td class="px-4 py-2">{{ $product->name }}</td>
                                    <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endforeach
</div>
@endsection

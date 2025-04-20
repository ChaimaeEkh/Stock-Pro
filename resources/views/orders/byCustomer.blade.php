@extends('layouts.app')

@section('title', 'Orders by Customer')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-2xl font-bold mb-6">Orders by Customer</h1>

    @foreach ($customers as $customer)
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">{{ $customer->name }} ({{ $customer->email }})</h2>

            @if ($customer->orders->isEmpty())
                <p class="text-gray-500">No orders for this customer.</p>
            @else
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">Order ID</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer->orders as $order)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $order->id }}</td>
                                    <td class="px-4 py-2">{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2">${{ number_format($order->total, 2) }}</td>
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

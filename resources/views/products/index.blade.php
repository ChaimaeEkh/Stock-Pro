@extends('layouts.app')
@section('title', 'Products')
@section('content')
<div class="container">
    <div class="header-actions">
        <h1>List of Products</h1>
        <div class="action-buttons">
            <a href="{{ route('products.export') }}" class="btn export-btn">
                <i class="fa fa-download"></i> Export Products Data
            </a>
            <button type="button" class="btn import-btn" id="openImportModalBtn">
                <i class="fa fa-file"></i> Import
            </button>
        </div>
    </div>

    <div class="products-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('products.partials.import-modal')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    h1 {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        border: none;
        text-decoration: none;
    }

    .export-btn {
        background-color: #ffc107;
        color: #212529;
    }

    .import-btn {
        background-color: #28a745;
        color: white;
    }

    .products-table {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background-color: #f1f1f1;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

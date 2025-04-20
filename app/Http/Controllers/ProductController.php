<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function byCategory()
    {
        $categories = Category::with('products')->get();
        return view('products.byCategory', compact('categories'));
    }
}

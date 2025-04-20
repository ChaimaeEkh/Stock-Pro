<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Imports\ProductImport;


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


    /**
    * @return \Illuminate\Support\Collection
    */
    public function export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }

      /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request)
    {
        try {
            Excel::import(new ProductImport, $request->file('file'));

            if ($request->ajax()) {
                return response()->json(['message' => 'Products imported successfully.']);
            }

            return back()->with('success', 'Products imported successfully.');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[$failure->attribute()] = $failure->errors();
            }

            if ($request->ajax()) {
                return response()->json(['errors' => $errors], 422);
            }

            return back()->withErrors($errors);
        }
    }

}

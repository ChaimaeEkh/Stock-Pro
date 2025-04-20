<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Log;


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
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    try {
        Excel::import(new ProductImport, $request->file('file'));
        return back()->with('success', 'Products imported successfully.');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();
        $errors = [];

        foreach ($failures as $failure) {
            $rowError = 'Row: ' . $failure->row() . ', ';
            $rowError .= 'Attribute: ' . $failure->attribute() . ', ';
            $rowError .= 'Error: ' . implode(', ', $failure->errors());
            $errors[] = $rowError;
        }

        return back()->withErrors(['file' => $errors])->withInput();
    } catch (\Exception $e) {
        Log::error('Excel import error: ' . $e->getMessage());
        return back()->withErrors(['file' => 'An error occurred during import: ' . $e->getMessage()])->withInput();
    }
}

}

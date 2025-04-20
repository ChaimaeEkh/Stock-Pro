<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class OrderController extends Controller
{
    public function byCustomer()
    {
        $customers = Customer::with('orders')->get();
        return view('orders.byCustomer', compact('customers'));
    }
}

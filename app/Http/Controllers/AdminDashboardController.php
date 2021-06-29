<?php

namespace App\Http\Controllers;

use App\Input;
use App\OrderForm;
use App\Output;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Product;

class AdminDashboardController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }

    function show()
    {
        $product_qty = Product::sum('qty');
        $input_price = Input::sum('total_price');
        $output_price = Output::sum('total_price');
        $orderform_cancel = OrderForm::where('status', '=', 'not-yet')->get();
        $orderform_list_cancel = $orderform_cancel->count($orderform_cancel);
        $orderform_success = OrderForm::where('status', '=', 'delivered')->get();
        $orderform_list_success = $orderform_success->count($orderform_success);
        
        $orderform = OrderForm::paginate(5);
        return view('admin.dashboard', compact('product_qty', 'input_price', 'output_price', 'orderform_list_cancel', 'orderform_list_success', 'orderform'));

        if (Gate::allows('is-admin')) {
            return view('admin.dashboard');
        } else {
            // abort(403);            
        }
    }
}

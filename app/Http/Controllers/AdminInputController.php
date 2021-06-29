<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Input;
use App\Product;
use Illuminate\Contracts\Session\Session;

class AdminInputController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'input']);
            return $next($request);
        });
    }

    function list(Request $request)
    {

        //    $total_p = session()->get('total_price');
        //    $price = session()->get('price');
        //    $qty = session()->get('qty');
        // return  $qty;
        // dd(session()->all());  
        $list_act = [
            'empty' => 'Chọn',
            'forceDelete' => 'Xoá'
        ];
        $input = Input::paginate(3);
        $status = $request->input('status');
        if ($status == 'delivered') {
            $input = Input::where('status', 'delivered')->paginate(3);
            $input->appends(['status' => 'delivered']);
            $list_act = [
                'empty' => 'Chọn',
                'forceDelete' => 'Xoá'
            ];
        }

        if ($status == 'not-yet') {
            $input = Input::where('status', 'not-yet')->paginate(3);
            $input->appends(['status' => 'not-yet']);
            $list_act = [
                'empty' => 'Chọn',
                'forceDelete' => 'Xoá'
            ];
        }


        if ($status == 'not-enough-stock') {
            $input = Input::where('status', 'not-enough-stock')->paginate(3);
            $input->appends(['status' => 'not-enough-stock']);
            $list_act = [
                'empty' => 'Chọn',
                'forceDelete' => 'Xoá'
            ];
        }

        $count_input_delivered = Input::where('status', 'delivered')->count();
        $count_input_ny = Input::where('status', 'not-yet')->count();
        $count_input_net = Input::where('status', 'not-enough-stock')->count();
        $count = [$count_input_delivered,  $count_input_ny, $count_input_net];
        return view('admin.input.list', compact('input', 'list_act', 'count'));
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'forceDelete') {
                   Input::whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/input/list')->with('status', 'Bạn đã xoá thành công');
                }
                if ($act == 'empty') {
                    return redirect('admin/input/list')->with('error', 'Bạn cần chọn tác vụ');
                }
            }
        } else {
            return redirect('admin/input/list')->with('error', 'Bạn cần chọn phiếu nhập hàng thực hiện');
        }
    }

    function edit($id)
    {
        $input = session('input');
        $product_id = $input['product_id'];
        // $qty = $input['qty'];                       
        // $price = $input['price'];                       
        // $total_price = $input['total_price'];                       
        // return $product_id. "<br>". $qty. "<br>" . $price. "<br>". $total_price;   

        $product = Product::all();
        // $product_qty = Product::where('id', $product_id)->get('qty');                
        // return $product_qty;        
        // $product = Product::find($id);
        // dd(session()->all());               
        // $product = Product::where('id',$product_id);
        // return $product;
        // $price_product = Product::find($id);
        // return $price_product;                          

        $supplier = Supplier::all();
        $input = Input::find($id);
        return view('admin.input.edit', compact('product', 'supplier', 'input'));
    }

    function update(Request $request, $id)
    {
        $input = session('input');
        $product_id = $input['product_id'];
        $qty = $input['qty'];
        $price = $input['price'];
        // $total_price = $input['total_price'];
        // return $product_id. "<br>". $qty. "<br>" . $price. "<br>". $total_price;                 

        // $qty_product = Product::where('id', $product_id);
        // $qty_pr = $qty_product['qty']; 

        // $product = Product::find($product_id);
        // $product->qty = $qty + $request->input('qty'); 
        // $product->qty = $product->qty + 100;
        Product::where('id', $product_id)->update([
            'qty' => $qty + $request->input('qty'),
            'price' => $request->input('price'),
            'total_price' => ($qty + $request->input('qty')) * $request->input('price'),
            'user_id' => $request->user_id = Auth::id(),
        ]);

        Input::Where('id', $id)->update([
            'status' => $request->input('status'),
            'user_id' => $request->user_id = Auth::id(),
        ]);

        // $request->session()->forget('input');
        // dd(session()->all());


        return redirect('admin/input/list')->with('status', 'Đã cập nhật phiếu nhập hàng thành công');
    }

    function delete($id)
    {
        $input = Input::find($id);
        $input->delete();
        return redirect('admin/input/list')->with('status', 'Đã xoá phiếu nhập hàng thành công');
    }

    function input_product(Request $request)
    {
        // $test = Input::get()->first()->product_id; 
        $product = Product::all();
        $supplier = Supplier::all();
        $input = Input::all();

        return view('admin.input.add', compact('supplier', 'product', 'input'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'product_id' => 'required|string',
                'content' => 'required|string',
                'address' => 'required|string',
                'supplier_cat' => 'required|string',
                'status' => 'required|string',
                'qty' => 'required|integer',
                'price' => 'required|integer'
            ],
            [
                'required' => ':attribute không được để trống',
                'exists' => ':attribute đã tồn tại trong hệ thống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'product_id' => 'Sản phẩm',
                'qty' => 'Giá',                
                'content' => 'Nội dung',
                'supplier_cat' => 'Nhà cung cấp',
                'address' => 'Địa chỉ',
                'status' => 'Trạng thái',
                'price' => 'Giá'              
            ],
        );

        Input::create([
            'supplier_cat' => $request->input('supplier_cat'),
            'content' => $request->input('content'),
            'address' => $request->input('address'),
            'product_id' => $request->input('product_id'),
            'qty' => $request->input('qty'),
            'user_id' => $request->user_id = Auth::id(),
            'price' => $request->input('price'),
            'total_price' => $request->input('price') * $request->input('qty'),
            'status' => $request->input('status'),
        ]);


        // $input = session('input');
        // $product_id = $input['product_id'];
        // $qty = $input['qty'];
        // $price = $input['price'];
        // $total_price = $input['total_price'];
        // return $product_id. "<br>". $qty. "<br>" . $price. "<br>". $total_price; 

        // Product::where('id', $product_id)->update([
        //     'qty' => $qty,
        //     'price' => $price,
        //     'total_price' => $total_price,
        // ]);

        $array = ([
            'supplier_cat' => $request->input('supplier_cat'),
            'content' => $request->input('content'),
            'address' => $request->input('address'),
            'product_id' => $request->input('product_id'),
            'qty' => $request->input('qty'),
            'user_id' => $request->user_id = Auth::id(),
            'price' => $request->input('price'),
            'total_price' => $request->input('price') * $request->input('qty'),
            'status' => $request->input('status'),
        ]);

        $request->session()->put('input', $array);
        // $request->session()->forget('input');
        // $request->session()->flush();
        // dd(session()->all());

        return redirect('admin/input/list')->with('status', 'Đã lưu phiếu nhập hàng thành công');
    }
}

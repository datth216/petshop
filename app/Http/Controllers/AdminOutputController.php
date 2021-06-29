<?php

namespace App\Http\Controllers;

use App\Product;
use App\Output;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOutputController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'output']);
            return $next($request);
        });
    }

    function list(Request $request){
        $list_act = [
            'empty' => 'Chọn',
            'forceDelete' => 'Xoá'
        ];
        $output = Output::paginate(3);
        $status = $request->input('status');

        if ($status == 'delivered') {
            $output = Output::where('status', 'delivered')->paginate(3);
            $output->appends(['status' => 'delivered']);
            $list_act = [
                'empty' => 'Chọn',
                'forceDelete' => 'Xoá'
            ];
        }

        if ($status == 'not-yet') {
            $output = Output::where('status', 'not-yet')->paginate(3);
            $output->appends(['status' => 'not-yet']);
            $list_act = [
                'empty' => 'Chọn',
                'forceDelete' => 'Xoá'
            ];
        }

        $count_output_delivered = Output::where('status', 'delivered')->count();
        $count_output_ny = Output::where('status', 'not-yet')->count();
        $count = [$count_output_delivered,  $count_output_ny];
        return view('admin.output.list', compact('output', 'list_act', 'count'));
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'forceDelete') {
                   Output::whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/output/list')->with('status', 'Bạn đã xoá thành công');
                }
                if ($act == 'empty') {
                    return redirect('admin/output/list')->with('error', 'Bạn cần chọn tác vụ');
                }
            }
        } else {
            return redirect('admin/output/list')->with('error', 'Bạn cần chọn phiếu nhập hàng thực hiện');
        }
    }

    function add(){
        $supplier = Supplier::all();
        return view('admin.output.add', compact('supplier'));
    }

    function edit($id)
    {
        $output = session('output');
        $product_id = $output['product_id'];  

        $product = Product::all();                      
        $supplier = Supplier::all();
        $output = Output::find($id);
        return view('admin.output.edit', compact('product', 'supplier', 'output'));
    }

    function update(Request $request, $id)
    {
        $output = session('output');
        $product_id = $output['product_id'];
        $qty = $output['qty'];
        $price = $output['price'];

        Product::where('id', $product_id)->update([
            'qty' => $request->input('qty') - $qty,
            'price' => $request->input('price'),
            'total_price' => ($request->input('qty') - $qty) * $request->input('price'),
            'user_id' => $request->user_id = Auth::id(),
        ]);

        Output::Where('id', $id)->update([
            'status' => $request->input('status'),
            'user_id' => $request->user_id = Auth::id(),
        ]);

        // $request->session()->forget('input');
        // dd(session()->all());


        return redirect('admin/input/list')->with('status', 'Đã cập nhật phiếu nhập hàng thành công');
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
                'qty' => 'Số lượng',                
                'content' => 'Nội dung',
                'supplier_cat' => 'Nhà cung cấp',
                'address' => 'Địa chỉ',
                'status' => 'Trạng thái',
                'price' => 'Giá'              
            ],
        );

        Output::create([
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

        $request->session()->put('output', $array);
        // dd(session()->all());

        return redirect('admin/output/list')->with('status', 'Đã lưu phiếu xuất hàng thành công');
    }
}

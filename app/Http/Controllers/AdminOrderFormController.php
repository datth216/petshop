<?php

namespace App\Http\Controllers;

use App\Category;
use App\OrderForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Supplier;


class AdminOrderFormController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'orderform']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $keyword = "";
        $list_act = [];
        $status = $request->input('status');
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $orderform = OrderForm::where("name", "LIKE", "%{$keyword}%")->orWhere("status", "LIKE", "%{$keyword}%")->paginate(3);
            $orderform->withPath("list?keyword={$keyword}&btn-search=Tìm+kiếm"); //Tuỳ chỉnh url
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá',
            ];
        } else {
            $orderform = OrderForm::paginate(3);
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá',
            ];
        }
        if ($status == 'delivered') {
            $orderform = OrderForm::where('status', 'delivered')->paginate(3);
            $orderform->appends(['status' => 'delivered']);
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá'
            ];
        }

        if ($status == 'not-yet') {
            $orderform = OrderForm::where('status', 'not-yet')->paginate(3);
            $orderform->appends(['status' => 'not-yet']);
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá',
            ];
        }
        $count_orderform_delivered = Orderform::where('status', 'delivered')->count();
        $count_orderform_ny = OrderForm::where('status', 'not-yet')->count();
        $count = [$count_orderform_delivered,  $count_orderform_ny];

        return view('admin.orderform.list', compact('orderform', 'list_act', 'status', 'count'));
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    OrderForm::whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/orderform/list')->with('status', 'Bạn đã xoá thành công');
                }
                if ($act == 'empty') {
                    return redirect('admin/orderform/list')->with('error', 'Bạn cần chọn tác vụ');
                }
            }
        } else {
            return redirect('admin/orderform/list')->with('error', 'Bạn cần chọn phiếu đặt hàng thực hiện');
        }
    }

    function add()
    {
        $product = Product::all();
        $supplier = Supplier::all();
        $category = Category::all();
        return view('admin.orderform.add', compact('supplier', 'category', 'product'));
    }

    function fetch(Request $request)
    {
        $data = Product::select('name', 'id')->where('supplier_cat', $request->sup_id)->take(100)->get();        
        $output = "";
        foreach ($data as $row) {
            $output .= "<option value='$row->id'>$row->name</option>";
        }
        echo $output;
        // return response()->json($data);
    }

    function detail(Request $request, $id)
    {
        $orderform = OrderForm::find($id);
        // $product = Product::find($id);
        // return $orderform;
        return view('admin.orderform.detail', compact('orderform'));
    }

    function edit($id)
    {
        $orderform = OrderForm::find($id);
        $supplier = Supplier::all();
        return view('admin.orderform.edit', compact('orderform', 'supplier'));
    }

    function delete($id)
    {
        $orderform = OrderForm::find($id);
        $orderform->delete();
        return redirect('admin/orderform/list')->with('status', 'Đã xoá phiếu đặt hàng thành công');
    }

    function store(Request $request)
    {
        $request->validate(
            [
                // 'product_id' => 'required|string|unique:orderform',
                // 'qty' => 'required|integer',
                'content' => 'required|string',
                'address' => 'required|string',
                'name' => 'required|string',
                // 'note' => 'string',
                'supplier_cat' => 'required|string',
                // 'product_cat' => 'required|string'
                'status' => 'required|string',
                // 'price' => 'required|int',
            ],
            [
                'required' => ':attribute không được để trống',
                'exists' => ':attribute đã tồn tại trong hệ thống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                // 'product_id' => 'Sản phẩm',
                // 'qty' => 'Giá',
                'name' => 'Tên',
                'content' => 'Nội dung',
                // 'note' => 'Ghi chú',
                'supplier_cat' => 'Nhà cung cấp',
                // 'product_cat' => 'Danh mục',
                'status' => 'Trạng thái',
                'address' => 'Địa chỉ'
                // 'price' => 'Giá',
            ],
        );
        OrderForm::create([
            // 'product_id' => $request->input('product_id'),
            // 'qty' => $request->input('qty'),
            'content' => $request->input('content'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'supplier_cat' => $request->input('supplier_cat'),
            // 'product_id' => $request->input('product_cat'),
            'status' => $request->input('status'),
            // 'qty_od' => $request->input('qty_od'),
            'user_id' => $request->user_id = Auth::id(),
            // 'price' => $request->input('price'),
            // 'total_price' => $request->input('price')*$request->input('qty_od')
        ]);


        return redirect('admin/orderform/list')->with('status', 'Đã lưu phiếu đặt hàng thành công');
    }

    function update(Request $request, $id)
    {
        $request->validate(
            [
                'content' => 'required|string',
                'address' => 'required|string',
                'name' => 'required|string',
                'supplier_cat' => 'required|string',
                'status' => 'required|string',
            ],
            [
                'required' => ':attribute không được để trống',
                'exists' => ':attribute đã tồn tại trong hệ thống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên',
                'content' => 'Nội dung',
                'supplier_cat' => 'Nhà cung cấp',
                'status' => 'Trạng thái',
                'address' => 'Địa chỉ'
            ],
        );
        OrderForm::Where('id', $id)->update([
            'content' => $request->input('content'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'supplier_cat' => $request->input('supplier_cat'),
            'status' => $request->input('status'),
            'user_id' => $request->user_id = Auth::id(),
        ]);
        return redirect('admin/orderform/list')->with('status', 'Đã cập nhật phiếu đặt hàng thành công');
    }
}

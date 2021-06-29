<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Supplier;
use Laravel\Ui\Presets\React;

class AdminProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $keyword = "";
        $list_act = [];
        $status = $request->input('status');
        $product = Product::all();
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $product = Product::where("name", "LIKE", "%{$keyword}%")->orWhere("price", "LIKE", "%{$keyword}%")->paginate(3);
            $product->withPath("list?keyword={$keyword}&btn-search=Tìm+kiếm"); //Tuỳ chỉnh url       
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá tạm thời',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        } else {
            $product = Product::paginate(3);
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá tạm thời',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        }

        if ($status == 'trash') {
            $product = Product::onlyTrashed()->paginate(3);
            $product->appends(['status' => 'trash']);
            $list_act = [
                'empty' => 'Chọn',
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        }

        if ($status == 'active') {
            $product = Product::paginate(3);
            $product->appends(['status' => 'active']);
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá tạm thời',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        }

        $count_product_active = Product::count();
        $count_product_trash = Product::onlyTrashed()->count();
        $count = [$count_product_active, $count_product_trash];

        return view('admin.product.list', compact('product', 'list_act', 'count', 'status'));
    }

    function add()
    {
        $supplier = Supplier::all();
        $category = Category::all();
        return view('admin.product.add', compact('category', 'supplier'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required|integer',
                'desc' => 'required|string',
                'detail' => 'required|string',
                'supplier_cat' => 'required',
                'product_cat' => 'required',
                'qty' => 'required|integer',
                'status' => 'required|string',
                'img' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'integer' => ':attribute phải là ký tự số',
                'mimes' => ':attribute phải có định dạng jpeg,jpg,png,gif',
            ],
            [
                'name' => 'Tên nhà cung cấp',
                'price' => 'Giá',
                'desc' => 'Mô tả',
                'detail' => 'Chi tiết sản phẩm',
                'supplier_cat' => 'Nhà cung cấp',
                'product_cat' => 'Danh mục sản phẩm',
                'qty' => 'Số lượng',
                'status' => 'Trạng thái',
                'img' => 'Hình ảnh'
            ],
        );
        if ($request->hasFile('img')) {
            //Kiểm tra file có tồn tại
            $file = $request->file('img');
            //lấy tên file
            $filename =  $file->getClientOriginalName();
            //lấy đuôi file
            // $file->getClientOriginalExtension();
            //lấy kích thước file
            // $file->getSize();

            $path = $file->move('public/uploads', $file->getClientOriginalName());
            $thumbnail = 'public/uploads/' . $filename;
            $input['img'] = $thumbnail;
        }

        Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'desc' => $request->input('desc'),
            'detail' => $request->input('detail'),
            'supplier_cat' => $request->supplier_cat,
            'product_cat' => $request->product_cat,
            'qty' => $request->input('qty'),
            'status' => $request->input('status'),
            'img' => $thumbnail,
            'user_id' => $request->user_id = Auth::id(),
            'total_price' => $request->input('qty') * $request->input('price'),
        ]);

        return redirect('admin/product/list')->with('status', 'Đã thêm sản phẩm thành công');
    }

    function edit($id)
    {
        $supplier = Supplier::all();
        $category = Category::all();
        $product = Product::find($id);
        return view('admin.product.edit', compact('supplier', 'category', 'product'));
    }

    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required|integer',
                'desc' => 'required|string',
                'detail' => 'required|string',
                'supplier_cat' => 'required',
                'product_cat' => 'required',
                'qty' => 'required|integer',
                'status' => 'required|string',
                'img' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'integer' => ':attribute phải là ký tự số',
                'mimes' => ':attribute phải có định dạng jpeg,jpg,png,gif',
            ],
            [
                'name' => 'Tên nhà cung cấp',
                'price' => 'Giá',
                'desc' => 'Mô tả',
                'detail' => 'Chi tiết sản phẩm',
                'supplier_cat' => 'Nhà cung cấp',
                'product_cat' => 'Danh mục sản phẩm',
                'qty' => 'Số lượng',
                'status' => 'Trạng thái',
                'img' => 'Hình ảnh'
            ],
        );
        if ($request->hasFile('img')) {
            //Kiểm tra file có tồn tại
            $file = $request->file('img');
            //lấy tên file
            $filename =  $file->getClientOriginalName();
            //lấy đuôi file
            // $file->getClientOriginalExtension();
            //lấy kích thước file
            // $file->getSize();

            $path = $file->move('public/uploads', $file->getClientOriginalName());
            $thumbnail = 'public/uploads/' . $filename;
            $input['img'] = $thumbnail;
        }

        Product::Where('id', $id)->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'desc' => $request->input('desc'),
            'detail' => $request->input('detail'),
            'supplier_cat' => $request->supplier_cat,
            'product_cat' => $request->product_cat,
            'qty' => $request->input('qty'),
            'status' => $request->input('status'),
            'img' => $thumbnail,
            'user_id' => $request->user_id = Auth::id(),
            'total_price' => $request->input('qty') * $request->input('price'),
        ]);

        return redirect('admin/product/list')->with('status', 'Đã cập nhật sản phẩm thành công');
    }

    function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('admin/product/list')->with('status', 'Đã xoá sản phẩm thành công');
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    Product::destroy($list_check);
                    return redirect('admin/product/list')->with('status', 'Bạn đã xoá thành công');
                }

                if ($act == 'restore') {
                    Product::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect('admin/product/list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($act == 'forceDelete') {
                    Product::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/product/list')->with('status', 'Bạn đã xoá vĩnh viễn thành công');
                }

                if ($act == 'empty') {
                    return redirect('admin/product/list')->with('error', 'Bạn cần chọn tác vụ');
                }
            }
        } else {
            return redirect('admin/product/list')->with('error', 'Bạn cần chọn sản phẩm để thực hiện');
        }
    }


    function restore($id)
    {
        Product::withTrashed()
            ->where('id', $id)
            ->restore();
        return redirect('admin/product/list')->with('status', 'Đã phục hồi sản phẩm thành công');
    }

    function detail(Request $request, $id)
    {
        $product = Product::find($id);
        return view('admin.product.detail', compact('product'));
    }
}
